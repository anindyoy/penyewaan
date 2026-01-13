<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Mobil;
use Livewire\Component;
use Livewire\Attributes\Layout;

class MobilAvailability extends Component
{
    public $tanggalHariIni;
    public $tanggalBesok;

    public function mount()
    {
        $this->tanggalHariIni = Carbon::today();
        $this->tanggalBesok   = Carbon::tomorrow();
    }

    protected function mobilTersedia($tanggal)
    {
        return Mobil::whereDoesntHave('pinjam', function ($q) use ($tanggal) {
            $q->where('status_sewa', '!=', 'dibatalkan')
                ->whereDate('tanggal_mulai', '<=', $tanggal)
                ->whereDate('tanggal_selesai_rencana', '>=', $tanggal);
        })->orderBy('merek')->get();
    }

    protected function mobilDipakai($tanggal)
    {
        return Mobil::whereHas('pinjam', function ($q) use ($tanggal) {
            $q->where('status_sewa', '!=', 'dibatalkan')
                ->whereDate('tanggal_mulai', '<=', $tanggal)
                ->whereDate('tanggal_selesai_rencana', '>=', $tanggal);
        })->orderBy('merek')->get();
    }

    public function render()
    {
        return view('livewire.mobil-availability', [
            'tersediaHariIni' => $this->mobilTersedia($this->tanggalHariIni),
            'dipakaiHariIni'  => $this->mobilDipakai($this->tanggalHariIni),
            'tersediaBesok'   => $this->mobilTersedia($this->tanggalBesok),
            'dipakaiBesok'    => $this->mobilDipakai($this->tanggalBesok),
        ]);
    }
}
