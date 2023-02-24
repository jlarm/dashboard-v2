<?php

namespace App\Http\Livewire\Dealer\Manual;

use App\Models\Dealer\Manual\Glb;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Livewire\Component;

class GlbForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Wizard::make([
                Wizard\Step::make('General Information')
                    ->schema([
                        Forms\Components\Hidden::make('user_id')->default(auth()->user()->id),
                        Forms\Components\TextInput::make('name')->default(tenant('name'))->required(),
                        Forms\Components\TextInput::make('address')->default(tenant('address'))->required(),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('phone')->default(tenant('phone'))->required(),
                                Forms\Components\TextInput::make('fax')->default(tenant('fax')),
                            ]),
                        Forms\Components\TextInput::make('website')->default(tenant('url'))->required(),
                        Forms\Components\TextInput::make('qi', 'Qualified Individual')->label('Qualified Individual')->required(),
                        Forms\Components\Repeater::make('receptacles', 'Security Receptical Locations')
                            ->schema([
                                Forms\Components\TextInput::make('name')->required(),
                            ])->createItemButtonLabel('Add Receptacle')
                    ]),
                Wizard\Step::make('Manager Information')
                    ->schema([
                        Forms\Components\Repeater::make('managers')
                            ->schema([
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('name')->required(),
                                        Forms\Components\TextInput::make('title')->required(),
                                        Forms\Components\TextInput::make('email')->required(),
                                    ]),
                            ])->createItemButtonLabel('Add Manager')
                    ]),
                Wizard\Step::make('Risk Assessment')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('assessment_company')->required(),
                                Forms\Components\TextInput::make('assessment_name')->required(),
                                Forms\Components\DatePicker::make('assessment_date')->required(),
                            ]),
                        Forms\Components\Section::make('General')
                            ->schema([
                                Forms\Components\Radio::make('q1a')
                                    ->options([
                                        'true' => 'Yes',
                                        'false' => 'No',
                                    ])->required()
                                    ->inline()
                                    ->boolean()
                                    ->label('Have you been in business less than five years? If so, how long have you been in business?'),
                                Forms\Components\RichEditor::make('q1c')
                                    ->disableAllToolbarButtons()
                                    ->label('Comments'),
                                Forms\Components\Radio::make('q2a')
                                    ->options([
                                        'true' => 'Yes',
                                        'false' => 'No',
                                    ])->required()
                                    ->inline()
                                    ->boolean()
                                    ->label('Are you a public entity? If not, what is your organizational type?'),
                                Forms\Components\RichEditor::make('q2c')
                                    ->disableAllToolbarButtons()
                                    ->label('Comments'),
                                Forms\Components\Radio::make('q3a')
                                    ->options([
                                        'true' => 'Yes',
                                        'false' => 'No',
                                    ])->required()
                                    ->inline()
                                    ->boolean()
                                    ->label('Have you provided the service/product under consideration for more than one year?'),
                                Forms\Components\RichEditor::make('q3c')
                                    ->disableAllToolbarButtons()
                                    ->label('Comments'),
                                Forms\Components\Radio::make('q4a')
                                    ->options([
                                        'true' => 'Yes',
                                        'false' => 'No',
                                    ])->required()
                                    ->inline()
                                    ->boolean()
                                    ->label('Have you recently merged or acquired another entity or are you in the process of merging or acquiring another entity? If so, provide a summary of the transaction, if disclosure is appropriate.'),
                                Forms\Components\RichEditor::make('q4c')
                                    ->disableAllToolbarButtons()
                                    ->label('Comments'),
                            ]),
                        Forms\Components\Section::make('Customer Privacy')
                            ->schema([
                                Forms\Components\Radio::make('q5a')
                                    ->options([
                                        'true' => 'Yes',
                                        'false' => 'No',
                                    ])->required()
                                    ->inline()
                                    ->boolean()
                                    ->label('Do you have a company privacy policy?'),
                                Forms\Components\RichEditor::make('q5c')
                                    ->disableAllToolbarButtons()
                                    ->label('Comments'),
                                Forms\Components\Radio::make('q6a')
                                    ->options([
                                        'true' => 'Yes',
                                        'false' => 'No',
                                    ])->required()
                                    ->inline()
                                    ->boolean()
                                    ->label('Does your privacy policy comply with the GLBA?'),
                                Forms\Components\RichEditor::make('q6c')
                                    ->disableAllToolbarButtons()
                                    ->label('Comments'),
                                Forms\Components\Radio::make('q7a')
                                    ->options([
                                        'true' => 'Yes',
                                        'false' => 'No',
                                    ])->required()
                                    ->inline()
                                    ->boolean()
                                    ->label('Do you have a data retention and/or data destruction policy?'),
                                Forms\Components\RichEditor::make('q7c')
                                    ->disableAllToolbarButtons()
                                    ->label('Comments'),
                                Forms\Components\Radio::make('q8a')
                                    ->options([
                                        'true' => 'Yes',
                                        'false' => 'No',
                                    ])->required()
                                    ->inline()
                                    ->boolean()
                                    ->label('Is your privacy policy communicated to all of your employees? If so, how often?'),
                                Forms\Components\RichEditor::make('q8c')
                                    ->disableAllToolbarButtons()
                                    ->label('Comments'),
                                Forms\Components\Radio::make('q9a')
                                    ->options([
                                        'true' => 'Yes',
                                        'false' => 'No',
                                    ])->required()
                                    ->inline()
                                    ->boolean()
                                    ->label('Are your employees required to sign non‐disclosure agreements?'),
                                Forms\Components\RichEditor::make('q9c')
                                    ->disableAllToolbarButtons()
                                    ->label('Comments'),
                                Forms\Components\Radio::make('q10a')
                                    ->options([
                                        'true' => 'Yes',
                                        'false' => 'No',
                                    ])->required()
                                    ->inline()
                                    ->boolean()
                                    ->label('Do you conduct background checks on your employees? If so, please explain the types of background checks performed, how often?'),
                                Forms\Components\RichEditor::make('q10c')
                                    ->disableAllToolbarButtons()
                                    ->label('Comments'),
                                Forms\Components\Radio::make('q11a')
                                    ->options([
                                        'true' => 'Yes',
                                        'false' => 'No',
                                    ])->required()
                                    ->inline()
                                    ->boolean()
                                    ->label('Do you have exit procedures in place to verify that customer non‐public information is no longer accessible to terminated or suspended employees?'),
                                Forms\Components\RichEditor::make('q11c')
                                    ->disableAllToolbarButtons()
                                    ->label('Comments'),
                                Forms\Components\Radio::make('q12a')
                                    ->options([
                                        'true' => 'Yes',
                                        'false' => 'No',
                                    ])->required()
                                    ->inline()
                                    ->boolean()
                                    ->label('Please provide a copy of your record retention policy.'),
                                Forms\Components\RichEditor::make('q12c')
                                    ->disableAllToolbarButtons()
                                    ->label('Comments'),
                            ]),
                    ]),
            ])
        ];
    }

    public function submit()
    {
        $manual = Glb::create($this->form->getState());

        redirect()->route('dashboard');

    }


}
