<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('volunteer.dashboard')
        ->assertStatus(200);
});
