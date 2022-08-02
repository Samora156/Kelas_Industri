<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class SiswaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id;

    function __construct($id) {
            $this->id = $id;
    }

    public function collection()
    {
        $cetak = DB::table('siswas')
                ->join('sekolahs', 'siswas.id_sekolah', '=', 'sekolahs.id')
                ->join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
                ->select('siswas.*', 'kelas.nama_kelas', 'sekolahs.nama_sekolah')
                ->whereIn('siswas.id', [$this->id])
                ->orderby('id_sekolah', 'asc')
                ->orderby('id_kelas', 'asc')->get();

        $data = [];

        array_push($data, ['No', 'Sekolah', 'Kelas', 'Nama', 'Tahun Ajaran', 'Angkatan', 'Email']);

        foreach ($cetak as $no => $m) {
            $no = 1;

            array_push($data, [
                $no + 1,
                $m->nama_sekolah,
                $m->nama_kelas,
                $m->nama,
                $m->tahun_ajaran,
                $m->angkatan,
                $m->email,
            ]);
        }
            
        return new Collection($data);
    }
}
