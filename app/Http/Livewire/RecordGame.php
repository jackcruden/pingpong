<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Game;

class RecordGame extends Component
{
    public $player1;

    public $player2;

    public $player1Score;

    public $player2Score;

    public $winner;

    protected $rules = [
        'player1' => 'required|exists:users,id|different:player2',
        'player2' => 'required|exists:users,id|different:player1',
        'player1Score' => 'nullable|integer',
        'player2Score' => 'nullable|integer',
        'winner' => 'required|exists:users,id',
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

    public function submit()
    {
        $this->validate($this->rules);

        $game = auth()->user()->currentTeam->games()->create();

        // Attach player 1
        $game->players()->save(User::find($this->player1), [
            'is_winner' => $this->player1 == $this->winner,
            'score' => $this->player1Score
        ]);

        // Attach player 2
        $game->players()->save(User::find($this->player2), [
            'is_winner' => $this->player2 == $this->winner,
            'score' => $this->player2Score
        ]);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.record-game', [
            'teammates' => auth()->user()->currentTeam->allUsers(),
        ]);
    }
}
