<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Scan;

use Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
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

            Cookie::queue('sentry', $this->token, 604800);

            return redirect()->route('dealer.store.single-store.scan');
        } catch (Exception) {
            $this->addError('email', 'Invalid credentials');
        }

        return null;
    }

    public function render()
    {
        return view('livewire.dealer.store.single-store.scan.login');
    }
}
