<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyakit;
use Illuminate\Support\Facades\Validator;

class PenyakitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Penyakit::all();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nama' => 'required|unique:penyakits,nama',

        ], [
            'nama.required' => 'Data wajib diisi',
            'nama.unique' => 'Nama penyakit sudah digunakan, harap pilih nama yang lain.',
        ]);
        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'nama' => $request->nama,
            ];

            Penyakit::create($data);

            return response()->json(['success' => "Berhasil menyimpan data"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Penyakit::find($id);
        if (!$data) {
            return response()->json(['errors' => ['Data tidak ditemukan']]);
        }
        else {
            return response()->json($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = Validator::make($request->all(), [
            'nama' => 'required|unique:penyakits,nama,' . $id,

        ], [
            'nama.required' => 'Data wajib diisi',
            'nama.unique' => 'Nama penyakit sudah digunakan, harap pilih nama yang lain.',
        ]);
        // Cek jika validasi gagal
        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        }

        // Ambil data anak berdasarkan ID
        $data = Penyakit::find($id);

        // Cek jika data anak tidak ditemukan
        if (!$data) {
            return response()->json(['errors' => ['Data tidak ditemukan']]);
        }

        $data->nama = $request->nama;
        $data->save();

        return response()->json(['success' => "Berhasil memperbarui data"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Penyakit::find($id)->delete();
        return response()->json(['success'=>'Data berhasil Dihapus']);
    }
}
