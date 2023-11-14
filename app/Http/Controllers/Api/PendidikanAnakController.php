<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendidikanAnakAsuh;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PendidikanAnakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PendidikanAnakAsuh::all();

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
            'nama_jenjang' => 'required',
            'nama_sekolah' => 'required',
            'tanggal_lulus' => 'required',
            'bukti_lulus' => 'required',

        ], [
            'anak_id.required' => 'Data wajib diisi',
            'nama_jenjang.required' => 'Data wajib diisi',
            'nama_sekolah.required' => 'Data wajib diisi',
            'tanggal_lulus.required' => 'Data wajib diisi',
            'bukti_lulus.required' => 'Data wajib diisi',
        ]);
        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $bukti_lulus = $request->file('bukti_lulus')->store('uploads/bukti_lulus');
            $data = [
                'anak_id' => $request->anak_id,
                'nama_jenjang' => $request->nama_jenjang,
                'nama_sekolah' => $request->nama_sekolah,
                'tanggal_lulus' => $request->tanggal_lulus,
                'bukti_lulus' => $bukti_lulus,
            ];

            PendidikanAnakAsuh::create($data);

            return response()->json(['success' => "Berhasil menyimpan data"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = PendidikanAnakAsuh::find($id);
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
            'anak_id' => 'required',
            'nama_jenjang' => 'required',
            'nama_sekolah' => 'required',
            'tanggal_lulus' => 'required',
            'bukti_lulus' => 'required',

        ], [
            'anak_id.required' => 'Data wajib diisi',
            'nama_jenjang.required' => 'Data wajib diisi',
            'nama_sekolah.required' => 'Data wajib diisi',
            'tanggal_lulus.required' => 'Data wajib diisi',
            'bukti_lulus.required' => 'Data wajib diisi',
        ]);
        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        }

        $data = PendidikanAnakAsuh::find($id);

        if (!$data) {
            return response()->json(['errors' => ['Data tidak ditemukan']]);
        }

        $data->anak_id = $request->anak_id;
        $data->nama_jenjang = $request->nama_jenjang;
        $data->nama_sekolah = $request->nama_sekolah;
        $data->tanggal_lulus = $request->tanggal_lulus;

        if ($request->hasFile('bukti_lulus')) {
            // Hapus file lama sebelum menyimpan yang baru
            Storage::delete($data->bukti_lulus);

            // Simpan file yang baru
            $data->bukti_lulus = $request->file('bukti_lulus')->getClientOriginalName();
        }
        $data->save();

        return response()->json(['success' => "Berhasil memperbarui data"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PendidikanAnakAsuh::find($id)->delete();
        return response()->json(['success'=>'Data berhasil Dihapus']);
    }
}
