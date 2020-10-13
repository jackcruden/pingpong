<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Game extends Component
{
    public $game;

    public function render()
    {
        return view('livewire.game');
    }
}
