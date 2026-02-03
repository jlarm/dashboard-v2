<?php

declare(strict_types=1);

it('consultant access dashboard when logged in', function () {
    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertSee('OSHA Rating')
        ->assertSeeLivewire('dealer.home.osha-stats')
        ->assertSeeLivewire('dealer.home.body-shop-stats')
        ->assertSeeLivewire('dealer.home.glba-stats')
        ->assertSeeLivewire('dealer.home.deal-jacket-stats')
        ->assertSeeLivewire('dealer.employee.department-completion-stats')
        ->assertSeeLivewire('dealer.home.note');
});

it('manager access dashboard when logged in', function () {
    $this->actingAs($this->manager)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertDontSee('OSHA Rating')
        ->assertSee('Courses')
        ->assertDontSeeLivewire('dealer.home.osha-stats')
        ->assertDontSeeLivewire('dealer.home.body-shop-stats')
        ->assertDontSeeLivewire('dealer.home.glba-stats')
        ->assertDontSeeLivewire('dealer.home.deal-jacket-stats')
        ->assertDontSeeLivewire('dealer.employee.completed-courses-stat')
        ->assertDontSeeLivewire('dealer.home.note')
        ->assertSeeLivewire('dealer.course.index');
});
