<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $name = 'Ndoro';
    public $asset = 15000000;
    public $transactionCount = 0;
    public function plusAsset()
    {
        $this->asset += 1000000;
        $this->transactionCount++;
    }
    public function minusAsset()
    {
        if ($this->asset >= 1000000) {
            $this->asset -= 1000000;
            $this->transactionCount++;
        }
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
