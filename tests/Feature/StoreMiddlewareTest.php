<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreMiddlewareTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function it_sets_the_current_store_in_session()
    {
        $response = $this->get('/stores/liberty-kia');

        $this->assertEquals('liberty-kia', session('current_store'));
    }
}
