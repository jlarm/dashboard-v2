<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\Store;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Login extends Component
{
    public Store $store;
    public string $email;
    public string $password;
    public string $token;

    public function login()
    {
        try {
            $user = Http::post('https://blue-api.redsentry.com/login', [
                'username' => $this->email,
                'password' => $this->password,
            ]);

            $this->token = $user['token'];

            Cookie::queue('sentry', $this->token, 604800);

            return to_route('dealer.scan.archive');

        } catch (Exception) {
            $this->addError('email', 'Invalid credentials');
        }

        return null;
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.scan.login');
    }
}
