<?php

namespace App\View\Components;

use Illuminate\View\Component;

class User extends Component
{
    public $user;

    public $position;

    protected $awards = [
        '🥇',
        '🥈',
        '🥉',
        '👤',
    ];

    /**
     * Create a new component instance.
     *
     * @param $user
     */
    public function __construct($user, $position)
    {
        $this->user = $user;
        $this->position = $this->awards[$position < 3 ? $position : 3];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.user');
    }
}
