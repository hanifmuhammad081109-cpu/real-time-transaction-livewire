<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Attributes\On;
use Livewire\Component;

class Stats extends Component
{
    #[On('transaction.updated')]
    public function refreshStats(){}

     public function minusAssets()
    {
        sleep(3);
        if ($this->getAssets() >= 10000) {
            Transaction::create([
                'type' => 'keluar',
                'amount' => 10000,
                'description' => 'Penarikan Cepat',
            ]);
        }

        $this->dispatch('transaction.updated');
        
    }
    public function getAssets()
    {
        $masuk = Transaction::where('type', 'masuk')->sum('amount');
        $keluar = Transaction::where('type', 'keluar')->sum('amount');
        return $masuk - $keluar;
    }
    public function render()
    {
        return view('livewire.stats', [
            'assets' => $this->getAssets()
        ]);
    }
}
