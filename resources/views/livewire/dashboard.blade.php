<div>
    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 p-1">
        <div
            class="h-16 w-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center justify-center text-white shadow-lg shadow-indigo-200">
            <span class="text-2xl font-mono font-bold">
                {{ substr($name, 0, 1) }}
            </span>
        </div>
    </div>
    <div class="">
        <h1 class="text-3xl font-black text-slate-800 tracking-tight">
            Selamat Datang , <span class="text-indigo-600">{{ $name }} !</span>
            <p class="text-slate-400 mt-1 font-medium italic">Ubah profilmu secara real-time disini.</p>
        </h1>
    </div>
    <div class="flex flex-col gap-2 mt-5 mx-4">
        <label class="text-xs font-bold text-slate-600 uppercase tracking-widest" for="name">Ganti nama:</label>
        <input type="text" name="name" id="name"
            class="px-4 py-2 rounded-xl border-2 border-slate-100 focus:border-indigo-500 focus:ring-0 outline-none trasition-all text-slate-700 font-medium"
            wire:model.live="name" placeholder="Masukkan nama baru">

    </div>

    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 ">
        <div class="p-8 bg-slate-50 rounded-2xl border border-slate-300 transition-hover hover:border-indigo-700">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Total Aset</p>
            <p class="text-3xl font-black text-slate-800 mt-2">
                Rp{{ number_format($assets ?? 0, 0, ',', '.') }}
            </p>

            <button wire:click="minusAssets" class="mt-4 w-full bg-white border-2 border-red-200 text-red-500 py-2 rounded-lg font-bold hover:bg-red-50 transition-all">- Tarik 10k</button>
        </div>
        <div class="p-8 bg-indigo-600 rounded-2xl border border-indigo-500 text-white shadow-xl shadow-indigo-200">
            <p class="text-indigo-100 text-xs font-bold uppercase tracking-widest text-opacity-70">Progress Belajar</p>
            <p class="text-3xl font-black mt-2">Bab 6 : Loading State</p>
        </div>
    </div>

    <div class="mt-12 p-10 bg-slate-900 rounded-3xl text-white shadow-2xl">
        <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
            🌩️ Top Up Kostum
        </h2>
        <form wire:submit="topUp" class="flex flex-col md:flex-row gap-6 items-end">
            <input type="number" wire:model="amount"
                class="bg-slate-800 border-none rounded-xl px-6 py-4 text-xl font-bold text-indigo-300 focus:ring-2 focus:ring-indigo-500 outline-none trasition-all placeholder:text-slate-700"
                placeholder="Minimal Top Up 10.000">

            <button 
            type="submit"
            class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-500 px-9 py-4 rounded-xl font-black tracking-widest shadow-lg shadow-indigo-900/50 transition-all active:scale-95 disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="topUp">Top Up</span>
                <span wire:loading wire:target="topUp" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Memproses...
                </span>
            </button>
            @error('amount')
                <span class="text-red-400 text-xs mt-1 font-bold tracking-tight">⚠️ {{ $message }}</span>
            @enderror
        </form>
    </div>

    <div class="mt-12">
        <h2 class="p-2 text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">🧾 Riwayat Transaksi</h2>
        <div wire:loading wire:target="topUp, minusAssets" class="text-indigo-600 text-xs font-bold flex items-center gap-2 animate-pulse">
            Memperbarui data
        </div>
        <div class="overflow-hidden rounded-2xl border border-slate-200">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50">
                    <tr class="px-6 py-4 text-xs font-bold text-slate-400 upprcase"></tr>
                    <tr class="px-6 py-4 text-xs font-bold text-slate-400 upprcase"></tr>
                    <tr class="px-6 py-4 text-xs font-bold text-slate-400 upprcase"></tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($history as $item)
                        <tr class="hover:bg-slate-50/50">
                            <td>{{ $item->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-slate-500 text-sm font-medium">
                                {{ $item->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold {{ $item->type == 'masuk' ? 'bg-green-500' : 'bg-red-500 text-white' }}">{{ strtoupper($item->type) }}</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-700">
                                {{ $item->type == 'masuk' ? '+' : '-' }}
                                Rp.{{ number_format($item->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-400 italic">Tidak ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
