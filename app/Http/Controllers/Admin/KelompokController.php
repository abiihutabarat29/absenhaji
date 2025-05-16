<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KelompokController extends Controller
{
    public function index(Request $request)
    {
        $menu = "Kelompok";

        if ($request->ajax()) {
            $data = Kelompok::select(['id', 'name'])->get();
            return DataTables::of($data)
                ->addColumn('jlh_peserta', function ($row) {
                    $total_peserta = $row->peserta->count();
                    return '<center>' . $total_peserta . '</center>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-warning btn-sm edit"><i class="tf-icons bx bx-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete"><i class="tf-icons bx bx-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['jlh_peserta', 'action'])
                ->make(true);
        }

        return view('kelompok.data', compact('menu'));
    }

    public function store(Request $request)
    {
        $message = array(
            'name.required'        => 'Nama Kelompok harus diisi.',
        );

        $validator = Validator::make($request->all(), [
            'name'           => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        Kelompok::updateOrCreate(
            [
                'id' => $request->hidden_id
            ],
            [
                'name'           => $request->name,
            ]
        );

        return response()->json(['success' => 'Kelompok berhasil disimpan.']);
    }

    public function edit($id)
    {
        $desa = Kelompok::find($id);
        return response()->json($desa);
    }

    public function destroy($id)
    {
        $data = Kelompok::find($id);
        $data->delete();
        return response()->json(['success' => 'Kelompok berhasil dihapus.']);
    }
}
