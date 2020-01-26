<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AlertMessage extends Component
{
    public $alertMessage = null;
    public $alertNumber;
    public $alertActiveNumber;

    public function mount($alertNumber = 0)
    {
        $this->alertNumber = $alertNumber;
    }

    protected $listeners = ['alertMessageShow' => 'show'];

    public function show($message, $alertActiveNumber = 0)
    {
        $this->alertMessage = $message;
        $this->alertActiveNumber = $alertActiveNumber;
    }

    public function close()
    {
        $this->alertMessage = null;
    }

    public function render()
    {
        return view('livewire.alert-message');
    }
}
