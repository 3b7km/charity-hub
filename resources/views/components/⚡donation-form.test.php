<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('donation-form')
        ->assertStatus(200);
});
