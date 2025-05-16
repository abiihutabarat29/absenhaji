<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\KonfirmasiTugas;
use App\Models\Peserta;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AbsensiController extends Controller
{
    public function index()
    {
        $menu = 'Tugas';
        $tugas = Tugas::all();
        $user = Auth::user();

        if ($user->role == 1) {
            // Ambil semua user dengan role 2 (user biasa)
            $totalUser = User::where('role', 2)->count();

            // Ambil jumlah status=1 per tugas
            $konfirmasiQuery = KonfirmasiTugas::select('tugas_id')
                ->selectRaw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as jumlah_selesai')
                ->groupBy('tugas_id')
                ->get();

            $konfirmasi = [];

            foreach ($tugas as $t) {
                $baris = $konfirmasiQuery->firstWhere('tugas_id', $t->id);
                $jumlahSelesai = $baris ? $baris->jumlah_selesai : 0;

                $konfirmasi[$t->id] = ($jumlahSelesai == $totalUser) ? 1 : 0;
            }
        } else {
            $konfirmasi = KonfirmasiTugas::where('user_id', $user->id)
                ->pluck('status', 'tugas_id');
        }

        return view('absensi.data', compact('menu', 'tugas', 'konfirmasi'));
    }

    public function store(Request $request)
    {
        $message = array(
            'title.required'       => 'Judul tugas harus diisi.',
            'keterangan.required'  => 'Keterangan harus diisi.',
        );

        $validator = Validator::make($request->all(), [
            'title'           => 'required',
            'keterangan'      => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        Tugas::updateOrCreate(
            [
                'id' => $request->hidden_id
            ],
            [
                'user_id'      => Auth::user()->id,
                'title'        => $request->title,
                'keterangan'   => $request->keterangan,
            ]
        );

        return response()->json(['success' => 'Tugas berhasil dibuat.']);
    }

    public function edit($id)
    {
        $desa = Tugas::find($id);
        return response()->json($desa);
    }

    public function absen(Request $request, $id)
    {
        $menu = 'Absensi';
        $id = Crypt::decrypt($id);
        $user = Auth::user();

        if ($user->role == 1) {
            $peserta = Peserta::get();
            $tugas = Tugas::where('id', $id)->first();
            $absensis = Absensi::where('tugas_id', $tugas->id)->get()->keyBy('peserta_id');
        } else {
            $peserta = Peserta::where('kelompok_id', $user->kelompok_id)->get();
            $tugas = Tugas::where('id', $id)->first();
            $absensis = Absensi::where('tugas_id', $tugas->id)->get()->keyBy('peserta_id');
        }

        return view('absensi.check', compact('menu', 'peserta', 'tugas', 'absensis'));
    }

    public function storeAbsen(Request $request, $id)
    {
        $user = Auth::user();

        $absensiInput = $request->input('absensi', []);

        if (empty($absensiInput)) {
            return response()->json(['error' => 'Minimal satu peserta harus diabsen.'], 422);
        }

        $pesertaIds = Peserta::where('kelompok_id', $user->kelompok_id)->pluck('id');

        foreach ($pesertaIds as $peserta_id) {
            $status = array_key_exists($peserta_id, $absensiInput) ? 1 : null;

            Absensi::updateOrCreate(
                [
                    'tugas_id'   => $id,
                    'peserta_id' => $peserta_id,
                ],
                [
                    'user_id'    => $user->id,
                    'status'     => $status,
                ]
            );
        }

        return response()->json(['success' => 'Absensi berhasil disimpan.']);
    }

    public function konfirmasi($id)
    {
        $user = Auth::user();

        // Cek apakah user ini sudah mengisi minimal 1 absensi dengan status 1
        $jumlahAbsen = Absensi::where('tugas_id', $id)
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->count();

        if ($jumlahAbsen < 1) {
            return response()->json(['error' => 'Minimal satu peserta harus diabsen terlebih dahulu.'], 422);
        }

        // Jika lolos validasi, tandai tugas sebagai selesai
        KonfirmasiTugas::updateOrCreate(
            [
                'tugas_id' => $id,
                'user_id' => $user->id
            ],
            ['status' => 1]
        );

        return response()->json(['success' => 'Tugas telah diselesaikan.']);
    }
}
