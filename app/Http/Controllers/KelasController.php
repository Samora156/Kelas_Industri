<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $kelas = Kelas::all();

        return view('kelas', compact('kelas'));
    }

    public function data()
    {
        

        // $kelas = DB::table('siswas')
        // ->select('nama_kelas', DB::raw('count(*) as isi'))
        // ->join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
        // ->groupBy('nama_kelas')
        // ->orderby('id_kelas', 'asc')
        // ->get();

        $kelas = Kelas::all();

        // $jumlah = DB::table('siswas')
        // ->join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
        // ->select('nama_kelas', DB::raw('count(*) as isi'))
        // ->groupBy('nama_kelas')
        // ->orderby('id_kelas', 'asc')
        // ->get();

        // $siswa = Siswa::join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
        // ->join('sekolahs', 'siswas.id_sekolah', '=', 'sekolahs.id')
        // ->select('siswas.*', 'kelas.nama_kelas', 'sekolahs.nama_sekolah')->get();

        // $siswa = Kelas::join('siswas', 'siswas.id_kelas', '=', 'kelas.id')
        // ->select('kelas.*', 'siswas.id_kelas', 'kelas.nama_kelas')
        // ->get();
        // dd($siswa);
        // dd($jumlah);

        // dd($kelas);
        
        return response()->json([
            'data'=> $kelas,
            // 'jum'=> $jumlah
            // 'jumlah' => $hitungSiswa,
        ]);
    }

    public function jumlah()
    {
        # code...
        $jumlah = Siswa::select(DB::raw('id_kelas, count(id) as total'))
        ->groupby('id_kelas')
        ->orderby('id_kelas','asc')
        ->get();

        return response()->json([
            'jumlah'=> $jumlah,
            // 'jumlah' => $hitungSiswa,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string',
        ]);
            $siswa = Kelas::create($request->all());

        return redirect()->route('siswa.index')->with('success', 'Berhasil menambahkan data siswa');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas, $id)
    {
        $kelas = Kelas::find($id);
        $id_kelas = Kelas::all();
        if ($kelas) {
            return response()->json([
                'status' => 200,
                'kelas' => $kelas,
                'id_kelas' => $id_kelas
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Student Found.'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $kelas = Kelas::find($id);

        //
        $kelas->update([
            'nama_kelas' => $request->nama,
            'angkatan' => $request->angkatan,
            'id_sekolah' => $request->id_sekolah,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kelas, $id)
    {
        //
        $kelas = Kelas::find($id);
        if($kelas)
        {
            $kelas->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Student Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Student Found.'
            ]);
        }
    }
    
}
