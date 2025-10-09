<?php

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\Store;
use Cookie;
use Exception;
use Http;
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

            if (tenant('locations')) {
                return redirect()->route('dealer.stores.scans', $this->store);
            }

            return redirect()->route('dealer.scan.index');

        } catch (Exception $e) {
            $this->addError('email', 'Invalid credentials');
        }
    }

    public function render()
    {
        return view('livewire.dealer.scan.login');
    }
}
