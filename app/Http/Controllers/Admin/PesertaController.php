<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $menu = "Peserta";
        $kelompok = Kelompok::all();
        if ($request->ajax()) {
            $data = Peserta::select(['id', 'kelompok_id', 'name'])->get();
            return DataTables::of($data)
                ->addColumn('kelompok', function ($row) {
                    return optional($row->kelompok)->name ?? '-';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-warning btn-sm edit"><i class="tf-icons bx bx-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete"><i class="tf-icons bx bx-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('peserta.data', compact('menu', 'kelompok'));
    }

    public function store(Request $request)
    {
        $message = array(
            'kelompok_id.required' => 'Kelompok harus diisi.',
            'name.required'        => 'Nama Peserta harus diisi.',
        );

        $validator = Validator::make($request->all(), [
            'kelompok_id'    => 'required',
            'name'           => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        Peserta::updateOrCreate(
            [
                'id' => $request->hidden_id
            ],
            [
                'kelompok_id'    => $request->kelompok_id,
                'name'           => $request->name,
            ]
        );

        return response()->json(['success' => 'Peserta berhasil disimpan.']);
    }

    public function edit($id)
    {
        $desa = Peserta::find($id);
        return response()->json($desa);
    }

    public function destroy($id)
    {
        $data = Peserta::find($id);
        $data->delete();
        return response()->json(['success' => 'Peserta berhasil dihapus.']);
    }
}
