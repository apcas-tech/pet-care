<?php

namespace App\Livewire\User;

use Livewire\Component;

use function Livewire\Volt\layout;

Layout('layouts.user');
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.user.dashboard');
    }
}
