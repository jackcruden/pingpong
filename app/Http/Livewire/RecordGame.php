<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class RecordGame extends Component
{
    public $player1;

    public $player2;

    public $player1Score;

    public $player2Score;

    public $winner;

    protected $rules = [
        'player1' => 'required',
        'player2' => 'required',
        'player1Score' => 'integer',
        'player2Score' => 'integer',
    ];

    public function mount()
    {
        $this->player1 = auth()->user()->getKey();
    }

    public function updated()
    {
        if ($this->player1Score > $this->player2Score) {
            $this->winner = $this->player1;
        } elseif ($this->player1Score < $this->player2Score) {
            $this->winner = $this->player2;
        } else {
            $this->winner = null;
        }
    }

    public function render()
    {
        return view('livewire.record-game', [
            'teammates' => auth()->user()->currentTeam->users,
        ]);
    }
}
