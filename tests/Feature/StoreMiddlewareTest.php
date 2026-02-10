<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class StoreMiddlewareTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function it_sets_the_current_store_in_session(): void
    {
        $this->get('/stores/liberty-kia');

        $this->assertEquals('liberty-kia', session('current_store'));
    }
}
