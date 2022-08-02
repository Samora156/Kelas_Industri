<?php

namespace App\Http\Controllers;

use App\Exports\SiswaExport;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siswa = Siswa::all();
        $jumlah = Siswa::count();
        $kelas = Kelas::all();
        $sekolah = Sekolah::all();
        $kategoris = Siswa::select(DB::raw('id_kelas, count(id) as total'))
                    ->groupby('id_kelas')
                    ->orderby('id_kelas','asc')
                    ->get();
        $nama = Auth::user()->name ;
        $arr = explode(' ', $nama);
        $singkatan = '';
            foreach($arr as $kata)
            {
                $singkatan = substr($kata, 0, 1);
            }

        return view('siswa', compact('siswa', 'jumlah', 'kelas', 'kategoris', 'sekolah', 'singkatan'));
    }

    public function pdfPilih(Request $request)
    {
        $id = $request->id_siswa;

        $cetak = DB::table('siswas')
                ->join('sekolahs', 'siswas.id_sekolah', '=', 'sekolahs.id')
                ->join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
                ->select('siswas.*', 'kelas.nama_kelas', 'sekolahs.nama_sekolah')
                ->whereIn('siswas.id', $id)
                ->orderby('id_sekolah', 'asc')
                ->orderby('id_kelas', 'asc')->get();

        $date = date('mdY');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('siswa_pdf', compact('cetak'));
        return $pdf->download($date.'laporan-siswa.pdf');
    }

    public function excelPilih($id)
    {
        $ids = explode(',', $id);
        $cetak = DB::table('siswas')
                ->join('sekolahs', 'siswas.id_sekolah', '=', 'sekolahs.id')
                ->join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
                ->select('siswas.*', 'kelas.nama_kelas', 'sekolahs.nama_sekolah')
                ->whereIn('siswas.id', $ids)
                ->orderby('id_sekolah', 'asc')
                ->orderby('id_kelas', 'asc')
                ->orderby('nama', 'asc')
                ->get();

                return (new FastExcel($cetak))->download('siswa.xlsx', function ($user) use ($cetak) {
                    return [
                        'No' => array_search($user, $cetak->toArray())+1,
                        'Sekolah' => $user->nama_sekolah,
                        'Kelas' => $user->nama_kelas,
                        'Nama' => $user->nama,
                        'Tahun Ajaran' => $user->tahun_ajaran,
                        'Angkatan' => $user->angkatan,
                        'Email' => $user->email
                    ];
            });
        }

    public function export()
    {
        $cetak = DB::table('siswas')
                ->join('sekolahs', 'siswas.id_sekolah', '=', 'sekolahs.id')
                ->join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
                ->select('siswas.*', 'kelas.nama_kelas', 'sekolahs.nama_sekolah')
                ->orderby('id_sekolah', 'asc')
                ->orderby('id_kelas', 'asc')
                ->orderby('nama', 'asc')
                ->get();

        $date = date('mdY');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('siswa_pdf', compact('cetak'));
    	return $pdf->download($date.'laporan-siswa.pdf');
    }

    public function excel()
    {
        $cetak = DB::table('siswas')
                ->join('sekolahs', 'siswas.id_sekolah', '=', 'sekolahs.id')
                ->join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
                ->select('siswas.*', 'kelas.nama_kelas', 'sekolahs.nama_sekolah')
                ->orderby('id_sekolah', 'asc')
                ->orderby('id_kelas', 'asc')->get();
        
        return (new FastExcel($cetak))->download('siswa.xlsx', function ($user) use ($cetak) {
                return [
                    'No' => array_search($user, $cetak->toArray())+1,
                    'Sekolah' => $user->nama_sekolah,
                    'Kelas' => $user->nama_kelas,
                    'Nama' => $user->nama,
                    'Tahun Ajaran' => $user->tahun_ajaran,
                    'Angkatan' => $user->angkatan,
                    'Email' => $user->email
                ];
        });
    }

    public function import(Request $request)
    {
        $file = $request->file;
        $users = (new FastExcel)->import($file, function ($line) use ($request) {
            return Siswa::create([
                'nama' => $line['Nama'] ,
                'email' => $line['Email'],
                'password' => Hash::make($line['Email']),
                'id_sekolah' => $request->sekolah,
                'id_kelas' => $request->kelas,
                'tahun_ajaran' => $request->ajaran,
                'angkatan' => $request->angkatan,
                'foto' => $request->foto,
            ]);
        });

        if($users){
            return response()->json([
                'status' => '200'
            ]);
        } else {
            return response()->json([
                'status' => '500'
            ]);
        }
    }

    public function data()
    {
        $siswa = Siswa::join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
                ->join('sekolahs', 'siswas.id_sekolah', '=', 'sekolahs.id')
                ->select('siswas.*', 'kelas.nama_kelas', 'sekolahs.nama_sekolah')
                ->orderby('id_sekolah', 'asc')
                ->orderby('id_kelas', 'asc')->get();
        return response()->json([
            'data' => $siswa,
        ]);
    }

    public function angkatan(Request $request)
    {
        $kelas = Kelas::where('id_sekolah', $request->id_sekolah)
        ->where('angkatan', $request->angkatan)->get();

        return response()->json([
            'kelas' => $kelas
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

        $this->validate($request,[
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'angkatan' => 'required|numeric',
            'email' => 'required|email|unique:siswas',
            'password' => 'required|min:6',
        ]);

        if ($foto = $request->file('foto')) {
            $lokasiFoto = "assets/media/siswa/";
            $Foto =  date('YmdHis') . "." . $foto->getClientOriginalExtension();
            $foto->move(($lokasiFoto), $Foto);

            $siswa = Siswa::create([
                'foto' => "$Foto",
                'nama' => $request->nama,
                'id_kelas' => $request->id_kelas,
                'id_sekolah' => $request->id_sekolah,
                'tahun_ajaran' => $request->tahun_ajaran,
                'angkatan' => $request->angkatan,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $request['password'] = Hash::make($request->password);

            $siswa = Siswa::create($request->all());
        }

        return redirect()->route('siswa.index')->with('success', 'Berhasil menambahkan data siswa');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa, $id)
    {
        $student = Siswa::find($id);
        $id_kelas = Kelas::all();
        if ($student) {
            return response()->json([
                'status' => 200,
                'student' => $student,
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
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $student = Siswa::find($id);

        if ($request->hasFile('foto')) {

            //upload new image
            $foto = $request->file('foto');
            $Foto =  date('YmdHis') . "." . $foto->getClientOriginalExtension();
            $foto->move('assets/media/siswa/', $Foto);

            //delete old image
            Storage::delete('assets/media/siswa/'.$student->foto);

            //update post with new image
            $student->update([
                'foto'     => $Foto,
                'nama' => $request->nama,
                'tahun_ajaran' => $request->tahun_ajaran,
                'angkatan' => $request->angkatan,
                'id_kelas' => $request->kelas,
                'id_sekolah' => $request->sekolah,
            ]);
        } else {
            //update post without image
            $student->update([
                'nama' => $request->nama,
                'tahun_ajaran' => $request->tahun_ajaran,
                'angkatan' => $request->angkatan,
                'id_kelas' => $request->kelas,
                'id_sekolah' => $request->sekolah,
            ]);
        }
    }

    public function updateAngkatan(Request $request)
    {
        // dd($request);
        Siswa::whereIn('id', $request->ids)->update([
            'id_sekolah' => $request->id_sekolah,
            'tahun_ajaran' => $request->tahun_ajaran,
            'angkatan' => $request->angkatan,
            'id_kelas' => $request->id_kelas
        ]);

        return redirect()->back()->with('success', 'Berhasil mengubah angkatan siswa');
    }

    public function hapusSiswa(Request $request)
    {
        Siswa::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus siswa');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Siswa::find($id);
        if($student)
        {
            $student->delete();
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

    public function signin()
    {
        return view('login.signin');
        # code...
    }
}