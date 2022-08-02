<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $guru = Guru::all();
        $sekolah = Sekolah::all();
        $jumlah = Guru::count();
        $nama = Auth::user()->name ;
        $arr = explode(' ', $nama);
        $singkatan = '';
            foreach($arr as $kata)
            {
                $singkatan .= substr($kata, 0, 1);
            }

        return view('guru', compact( 'guru', 'jumlah', 'sekolah', 'singkatan'));
    }

    public function hapusGuru(Request $request)
    {
        Guru::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus guru');
    }
    
    public function tampilan()
    {
        //
        $guru = Guru::all();
        $jumlah = Guru::count();

        return view('guru.index', compact( 'guru', 'jumlah'));
    }
    
    public function data()
    {
        $guru = Guru::join('sekolahs', 'gurus.id_sekolah', '=', 'sekolahs.id')
        ->select('gurus.*', 'sekolahs.nama_sekolah')->get();
        
        return response()->json([
            'data' => $guru,
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
        // dd($request->rekening);
        //
        $request->validate([
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_sekolah' => 'required',
            'nama_guru' => 'required|string',
            'alamat' => 'required|string',
            'tlpn' => 'required|numeric|min:12',
            'bank' => 'required',
            'rekening' => 'required|numeric',
            'email' => 'required|email|unique:gurus',
            'password' => 'required|min:6',
        ]);

        if ($foto = $request->file('foto')) {
            $lokasiFoto = 'assets/media/guru/';
            $Foto =  date('YmdHis') . "." . $foto->getClientOriginalExtension();
            $foto->move(($lokasiFoto), $Foto);

            $guru = Guru::create([
                'foto' => "$Foto",
                'nama_guru' => $request->nama_guru,
                'alamat' => $request->alamat,
                'tlpn' => $request->tlpn,
                'bank' => $request->bank,
                'rekening' => $request->rekening,
                'email' => $request->email,
                'id_sekolah' => $request->id_sekolah,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $request['password'] = Hash::make($request->password);

            $guru = Guru::create($request->all());
        }

        return redirect()->route('guru.index')->with('success', 'Berhasil menambahkan data siswa');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function show(Guru $guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function edit(Guru $guru, $id)
    {
        //
        $guru = Guru::find($id);
        $id_guru = Guru::all();
        if ($guru) {
            return response()->json([
                'status' => 200,
                'guru' => $guru,
                'id_guru' => $id_guru
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No guru Found.'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        // dd($request->rek);
        $id = $request->id;
        $guru = Guru::find($id);

        if ($request->hasFile('foto')) {

            //upload new image
            $foto = $request->file('foto');
            $Foto =  date('YmdHis') . "." . $foto->getClientOriginalExtension();
            $foto->move('assets/media/guru/', $Foto);
            
            //delete old image
            Storage::delete('assets/media/guru/'.$guru->foto);
            
            //update post with new image
            $guru->update([
                'foto'     => $Foto,
                'nama_guru' => $request->nama_guru,
                'alamat' => $request->alamat,
                'tlpn' => $request->tlpn,
                'bank' => $request->bank,
                'rekening' => $request->rek,
                'id_sekolah' => $request->sekolah,
                // 'email' => $request->email,
                // 'password' => $request->password
            ]);
            
        } else {
            
            //update post without image
            $guru->update([
                'nama_guru' => $request->nama_guru,
                'alamat' => $request->alamat,
                'id_sekolah' => $request->sekolah,
                'bank' => $request->bank,
                'rekening' => $request->rek,
                // 'email' => $request->email,
                // 'password' => $request->password
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
        $guru = Guru::find($id);
        if($guru)
        {
            $guru->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Guru Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Guru Found.'
            ]);
        }
    }

    // 
    // 
    // 
    //----------------------------------Export------------------------------------------- 
    // 
    // 
    // 

    public function pdfPilih(Request $request)
    {
        $id = $request->id_guru;

        $cetak = DB::table('gurus')
                ->join('sekolahs', 'gurus.id_sekolah', '=', 'sekolahs.id')
                ->join('kelas', 'gurus.id_kelas', '=', 'kelas.id')
                ->select('gurus.*', 'kelas.nama_kelas', 'sekolahs.nama_sekolah')
                ->whereIn('gurus.id', $id)
                ->orderby('id_sekolah', 'asc')
                ->orderby('id_kelas', 'asc')->get();

        $date = date('mdY');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('guru_pdf', compact('cetak'));
        return $pdf->download($date.'laporan-guru.pdf');
    }

    public function excelPilih($id)
    {
        $idg = explode(',', $id);

        $cetak = DB::table('gurus')
                ->join('sekolahs', 'gurus.id_sekolah', '=', 'sekolahs.id')
                ->join('kelas', 'gurus.id_kelas', '=', 'kelas.id')
                ->select('gurus.*', 'kelas.nama_kelas', 'sekolahs.nama_sekolah')
                ->whereIn('gurus.id', $idg)
                ->orderby('id_sekolah', 'asc')
                ->orderby('id_kelas', 'asc')->get();

                return (new FastExcel($cetak))->download('guru.xlsx', function ($user) use ($cetak) {
                    return [
                        'No' => array_search($user, $cetak->toArray())+1,
                        'Sekolah' => $user->nama_sekolah,
                        'Kelas' => $user->nama_kelas,
                        'Nama' => $user->nama_guru,
                        'Alamat' => $user->alamat,
                        'Telepon' => $user->tlpn,
                        'Bank' => $user->bank,
                        'No. Rekening' => $user->rekening,
                        'Email' => $user->email
                    ];
            });
    }
    
    public function export()
    {
        $cetak = DB::table('gurus')
                ->join('sekolahs', 'gurus.id_sekolah', '=', 'sekolahs.id')
                ->join('kelas', 'gurus.id_kelas', '=', 'kelas.id')
                ->select('gurus.*', 'kelas.nama_kelas', 'sekolahs.nama_sekolah')
                ->orderby('id_sekolah', 'asc')
                ->orderby('id_kelas', 'asc')->get();

        $date = date('mdY');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('guru_pdf', compact('cetak'));
    	return $pdf->download($date.'laporan-guru.pdf');
    }

    public function excel()
    {
        $cetak = DB::table('gurus')
                ->join('sekolahs', 'gurus.id_sekolah', '=', 'sekolahs.id')
                ->join('kelas', 'gurus.id_kelas', '=', 'kelas.id')
                ->select('gurus.*', 'kelas.nama_kelas', 'sekolahs.nama_sekolah')
                ->orderby('id_sekolah', 'asc')
                ->orderby('id_kelas', 'asc')->get();
        
        return (new FastExcel($cetak))->download('guru.xlsx', function ($user) use ($cetak) {
                return [
                    'No' => array_search($user, $cetak->toArray())+1,
                        'Sekolah' => $user->nama_sekolah,
                        'Kelas' => $user->nama_kelas,
                        'Nama' => $user->nama_guru,
                        'Alamat' => $user->alamat,
                        'Telepon' => $user->tlpn,
                        'Bank' => $user->bank,
                        'No. Rekening' => $user->rekening,
                        'Email' => $user->email
                ];
        });
    }

    public function import(Request $request)
    {
        # code...
        // dd($request->kelas_id);
        $file = $request->file;
        $users = (new FastExcel)->import($file, function ($line) use ($request) {
            return Guru::create([
                'nama_guru' => $line['Nama'],
                'email' => $line['Email'],
                'alamat' => $line['Alamat'],
                'tlpn' => $line['Telepon'],
                'bank' => $line['Bank'],
                'rekening' => $line['Rekening'],
                'password' => Hash::make($line['Password']),
                'id_sekolah' => $request->sekolah_id,
                'id_kelas' => $request->kelas_id,
                'foto' => $request->foto,
            ]);
        });

        return redirect()->route('guru.index')->with('success', 'Berhasil menambahkan data siswa');
    }

    public function kelas(Request $request)
    {
        $kelas = Kelas::where('id_sekolah', $request->id_sekolah)->get();

        return response()->json([
            'kelas' => $kelas
        ]);
    }
}
