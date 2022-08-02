<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sekolah = Sekolah::all();
        $nama = Auth::user()->name ;
        $arr = explode(' ', $nama);
        $singkatan = '';
            foreach($arr as $kata)
            {
                $singkatan .= substr($kata, 0, 1);
            }
        
        return view('sekolah', compact( 'sekolah', 'singkatan'));
    }

    public function data()
    {
        $siswa = Sekolah::get();
        
        return response()->json([
            'data' => $siswa,
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
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_sekolah' => 'required|string|unique:sekolahs',
            'alamat' => 'required|string',
            'kepala_sekolah' => 'required|string',
            'email_sekolah' => 'required|string',
            'telp_sekolah' => 'required|numeric',
        ]);

        $jml = Sekolah::count()->get(); 
        $kode_unik = $jml+1;
        dd($jml);
        $kode = substr($request->nama_sekolah ,0,2).$kode_unik;

        if ($foto = $request->file('foto')) {
            $lokasiFoto = "assets/media/sekolah/";
            $Foto =  date('YmdHis') . "." . $foto->getClientOriginalExtension();
            $foto->move(($lokasiFoto), $Foto);

            $sekolah = Sekolah::create([
                'logo' => "$Foto",
                'nama_sekolah' => $request->nama_sekolah,
                'alamat' => $request->alamat,
                'kepala_sekolah' => $request->kepala_sekolah,
                'email_sekolah' => $request->email_sekolah,
                'telp_sekolah' => $request->telp_sekolah,
            ]);
        } else {
            $sekolah = Sekolah::create($request->all());
        }
        return redirect()->route('sekolah.index')->with('success', 'Berhasil menambahkan data siswa');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
            $siswa = Siswa::join('kelas', 'kelas.id', '=', 'siswas.id_kelas')
            ->select('siswas.*', 'kelas.nama_kelas')
            ->where('siswas.id_sekolah',$id)->get();
            $kelas = Kelas::where('id_sekolah',$id)->get();
            $guru = Guru::where('id_sekolah',$id)->get();
            $sekolah = Sekolah::where('id', $id)->get();
            $nama = Auth::user()->name ;
            $arr = explode(' ', $nama);
            $singkatan = '';
                foreach($arr as $kata)
                {
                    $singkatan .= substr($kata, 0, 1);
                }

            return view('sekolah_detail', compact('siswa', 'kelas', 'guru', 'sekolah', 'singkatan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa, $id)
    {
        //
        $sekolah = Sekolah::find($id);
        // $id_kelas = Kelas::all();
        if ($sekolah) {
            return response()->json([
                'status' => 200,
                'sekolah' => $sekolah,
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
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $id = $request->id;
        $sekolah = Sekolah::find($id);
        
        if ($request->hasFile('foto')) {
            
            //upload new image
            $foto = $request->file('foto');
            $Foto =  date('YmdHis') . "." . $foto->getClientOriginalExtension();
            $foto->move('assets/media/sekolah/', $Foto);
            
            //delete old image
            Storage::delete('assets/media/sekolah/'.$sekolah->logo);
            
            //update post with new image
            $sekolah->update([
                'logo'     => $Foto,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'kepala_sekolah' => $request->kepala_sekolah,
                'email_sekolah' => $request->email,
                'telp_sekolah' => $request->telp,
            ]);
            
        } else {
            
            //update post without image
            $sekolah->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'kepala_sekolah' => $request->kepala_sekolah,
                'email_sekolah' => $request->email,
                'telp_sekolah' => $request->telp,
            ]);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sekolah = Sekolah::find($id);
        if($sekolah)
        {
            $sekolah->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Sekolah Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Sekolah Found.'
            ]);
        }
    }
}