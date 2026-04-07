<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $name = 'Ndoro';
    public $asset = 15000000;
    public $transactionCount = 0;

    #[Validate('required|numeric|min:10000', message: 'Minimum 10.000')]
    public $nominal;
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
    public function topUp()
    {
        //Menjalankan validasi berdasarkan #[Validate]
        $this->validate();

        $this->asset += $this->nominal;
        $this->transactionCount++;

        $this->reset('nominal');
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
