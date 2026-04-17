<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendCustomEmployeeMessageJob;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Throwable;
use WireElements\Pro\Components\Modal\Modal;

class CustomMessageModal extends Modal
{
    public array $userIds = [];
    public string $subject = '';
    public string $messageBody = '';
    protected array $rules = [
        'subject' => 'required|string|max:255',
        'messageBody' => 'required|string',
    ];

    public function mount(array $userIds): void
    {
        $this->userIds = $userIds;
        $this->subject = 'Message from '.(auth()->user()?->name ?? '');
    }

    public function send(): void
    {
        $this->validate();

        try {
            $users = User::query()->whereIn('id', $this->userIds)->get();

            foreach ($users as $user) {
                dispatch(new SendCustomEmployeeMessageJob(user: $user, subject: $this->subject, messageBody: $this->messageBody));
            }

            $this->close();

            Notification::make()
                ->title('Messages sent successfully.')
                ->body("A custom message has been sent for {$users->count()} employee(s).")
                ->success()
                ->send();
        } catch (Throwable $exception) {
            report($exception);

            Notification::make()
                ->title('Unable to send messages')
                ->body('Something went wrong while queuing the messages. Please try again.')
                ->danger()
                ->send();
        }
    }

    public function render(): View
    {
        return view('livewire.dealer.employee.custom-message-modal', [
            'userCount' => count($this->userIds),
        ]);
    }
}
