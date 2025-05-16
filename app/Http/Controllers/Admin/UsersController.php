<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $menu = "Users";
        $kelompok = Kelompok::all();
        if ($request->ajax()) {
            $data = User::select(['id', 'kelompok_id', 'name', 'email', 'password'])->get();
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

        return view('user.data', compact('menu', 'kelompok'));
    }

    public function store(Request $request)
    {
        $message = array(
            'kelompok_id.required'  => 'Kelompok harus diisi.',
            'name.required'         => 'Nama User harus diisi.',
            'email.required'        => 'Email harus diisi.',
            'email.unique'          => 'Email sudah terdaftar.',
            'email.email'           => 'Penulisan email tidak benar.',
            'password.required'     => 'Password harus diisi.',
            'password.min'          => 'Password minimal 8 karakter.',
            'password.min'          => 'Password minimal 8 karakter.',
            'repassword.required'   => 'Harap konfirmasi password.',
            'repassword.same'       => 'Password harus sama.',
            'repassword.min'        => 'Password minimal 8 karakter.',
        );

        if ($request->hidden_id) {
            $ruleEmail      = 'nullable|email';
            $rulePassword   = 'nullable|min:8';
            $ruleRePassword   = 'nullable|same:password|min:8';
        } else {
            $ruleEmail      = 'required|email|unique:users,email';
            $rulePassword   = 'required|min:8';
            $ruleRePassword = 'required|same:password|min:8';
        }

        $validator = Validator::make($request->all(), [
            'kelompok_id'   => 'required',
            'name'          => 'required',
            'email'         => $ruleEmail,
            'password'      => $rulePassword,
            'repassword'    => $ruleRePassword,
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if ($request->hidden_id) {

            $existingRecord = User::where('kelompok_id', $request->kelompok_id)
                ->where('id', '!=', $request->hidden_id)
                ->exists();

            if ($existingRecord) {
                return response()->json(['errors' => ['Kelompok sudah digunakan.']]);
            }
        } else {

            $existingRecord = User::where('kelompok_id', $request->kelompok_id)
                ->exists();

            if ($existingRecord) {
                return response()->json(['errors' => ['Kelompok sudah digunakan.']]);
            }
        }

        if ($request->filled('password')) {
            $password = $request->password;
        } elseif ($request->hidden_id) {
            if ($request->filled('password')) {
                $password = $request->password;
            } else {
                $oldPassword = User::find($request->hidden_id);
                $password = $oldPassword->password;
            }
        } else {
            $password = null;
        }

        User::updateOrCreate(
            [
                'id' => $request->hidden_id
            ],
            [
                'kelompok_id'    => $request->kelompok_id,
                'name'           => $request->name,
                'email'          => $request->email,
                'password'       => $password,
                'role'           => 2
            ]
        );

        return response()->json(['success' => 'User berhasil disimpan.']);
    }

    public function edit($id)
    {
        $desa = User::find($id);
        return response()->json($desa);
    }

    public function destroy($id)
    {
        $data = User::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => 'User ' . $data->name . ' berhasil dihapus.']);
        } else {
            return response()->json(['error' => 'User tidak ditemukan.']);
        }
    }
}
