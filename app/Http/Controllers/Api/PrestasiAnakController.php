<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrestasiAnakAsuh;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PrestasiAnakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PrestasiAnakAsuh::all();

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
            'anak_id' => 'required',
            'judul' => 'required',
            'tanggal_lomba' => 'required',
            'status' => 'required',
            'bukti_prestasi' => 'required',

        ], [
            'anak_id.required' => 'Data wajib diisi',
            'judul.required' => 'Data wajib diisi',
            'tanggal_lomba.required' => 'Data wajib diisi',
            'status.required' => 'Data wajib diisi',
            'bukti_prestasi.required' => 'Data wajib diisi',
        ]);
        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $bukti_prestasi = $request->file('bukti_prestasi')->store('uploads/bukti_prestasi');
            $data = [
                'anak_id' => $request->anak_id,
                'judul' => $request->judul,
                'tanggal_lomba' => $request->tanggal_lomba,
                'status' => $request->status,
                'bukti_prestasi' => $bukti_prestasi,
            ];

            PrestasiAnakAsuh::create($data);

            return response()->json(['success' => "Berhasil menyimpan data"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = PrestasiAnakAsuh::find($id);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = Validator::make($request->all(), [
            'anak_id' => 'required',
            'judul' => 'required',
            'tanggal_lomba' => 'required',
            'status' => 'required',
            'bukti_prestasi' => 'required',

        ], [
            'anak_id.required' => 'Data wajib diisi',
            'judul.required' => 'Data wajib diisi',
            'tanggal_lomba.required' => 'Data wajib diisi',
            'status.required' => 'Data wajib diisi',
            'bukti_prestasi.required' => 'Data wajib diisi',
        ]);
        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        }

        $data = PrestasiAnakAsuh::find($id);

        if (!$data) {
            return response()->json(['errors' => ['Data tidak ditemukan']]);
        }

        $data->anak_id = $request->anak_id;
        $data->judul = $request->judul;
        $data->tanggal_lomba = $request->tanggal_lomba;
        $data->status = $request->status;

        if ($request->hasFile('bukti_prestasi')) {
            // Hapus file lama sebelum menyimpan yang baru
            Storage::delete($data->bukti_prestasi);

            // Simpan file yang baru
            $data->bukti_prestasi = $request->file('bukti_prestasi')->getClientOriginalName();
        }
        $data->save();

        return response()->json(['success' => "Berhasil memperbarui data"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PrestasiAnakAsuh::find($id)->delete();
        return response()->json(['success'=>'Data berhasil Dihapus']);
    }
}
