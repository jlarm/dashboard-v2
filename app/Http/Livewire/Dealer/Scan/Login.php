<?php

namespace App\Http\Livewire\Dealer\Scan;

use Cookie;
use Http;
use Livewire\Component;

class Login extends Component
{
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

            Cookie::queue('sentry', $this->token, 30);

            return redirect()->route('dealer.scan.index');
        } catch (\Exception $e) {
            $this->addError('email', 'Invalid credentials');
        }
    }
    public function render()
    {
        return view('livewire.dealer.scan.login');
    }
}
