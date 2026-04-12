<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Dashboard extends Component
{
    
    public $name = 'Ndoro';
    public $search = "";

    #[Validate('required|numeric|min:10000', message: 'Minimum 10.000')]
    public $amount;
     #[On('transaction.updated')]
    public function refreshStats(){}
   
    public function topUp()
    {
        //Menjalankan validasi berdasarkan #[Validate]
        $this->validate();

        sleep(2); //Simulasi proses yang memakan waktu
        //Simpan ke database
        Transaction::create([
            'type' => 'masuk',
            'amount' => $this->amount,
            'description' => 'Top Up Kostum',
        ]);

        $this->reset('amount');

        $this->dispatch('transaction.updated');
    }

    public function delete($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        $this->dispatch('transaction.updated');

    }
    public function render()
    {
        $history = Transaction::query()
            ->when($this->search, function($query){
                $query->where('description', 'like', '%'.$this->search.'%')
                      ->orWhere('amount', 'like', '%'.$this->search.'%');
            })->latest()->get();
        return view('livewire.dashboard', [
            'assets' => $this->getAssets(),
            'transactions' => Transaction::count(),
            'history' => $history
        ]);
        
    }
}
