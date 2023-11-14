<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KesehatanAnakAsuh;
use Illuminate\Support\Facades\Validator;

class KesehatanAnakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = KesehatanAnakAsuh::all();

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
            'penyakit_id' => 'required',
            'status' => 'required',
            'tanggal_sakit' => 'required',
            'obat_penyakit' => 'required',

        ], [
            'anak_id.required' => 'Data wajib diisi',
            'penyakit_id.required' => 'Data wajib diisi',
            'status.required' => 'Data wajib diisi',
            'tanggal_sakit.required' => 'Data wajib diisi',
            'obat_penyakit.required' => 'Data wajib diisi',
        ]);
        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'anak_id' => $request->anak_id,
                'penyakit_id' => $request->penyakit_id,
                'status' => $request->status,
                'tanggal_sakit' => $request->tanggal_sakit,
                'obat_penyakit' => $request->obat_penyakit,
            ];

            KesehatanAnakAsuh::create($data);

            return response()->json(['success' => "Berhasil menyimpan data"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = KesehatanAnakAsuh::find($id);
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
            'penyakit_id' => 'required',
            'status' => 'required',
            'tanggal_sakit' => 'required',
            'obat_penyakit' => 'required',

        ], [
            'anak_id.required' => 'Data wajib diisi',
            'penyakit_id.required' => 'Data wajib diisi',
            'status.required' => 'Data wajib diisi',
            'tanggal_sakit.required' => 'Data wajib diisi',
            'obat_penyakit.required' => 'Data wajib diisi',
        ]);
        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        }

        $data = KesehatanAnakAsuh::find($id);

        if (!$data) {
            return response()->json(['errors' => ['Data tidak ditemukan']]);
        }
        $data->anak_id = $request->anak_id;
        $data->penyakit_id = $request->penyakit_id;
        $data->status = $request->status;
        $data->tanggal_sakit = $request->tanggal_sakit;
        $data->obat_penyakit = $request->obat_penyakit;
        $data->save();

        return response()->json(['success' => "Berhasil memperbarui data"]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        KesehatanAnakAsuh::find($id)->delete();
        return response()->json(['success'=>'Data berhasil Dihapus']);
    }
}
