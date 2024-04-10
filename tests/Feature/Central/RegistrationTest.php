<?php

test('public registration page does not exist', function () {
    $response = $this->get('/registration');

    $response->assertStatus(404);
});

test('cannot publicly register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'lj@kj.com',
        'phone' => '1234567890',
        'password' => 'aklfjalkfjbvaklfj',
        'password_confirmation' => 'aklfjalkfjbvaklfj',
    ]);

    $response->assertStatus(404);
});
