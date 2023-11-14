<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnakAsuh;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AnakAsuhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = AnakAsuh::all();

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
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'status' => 'required',
            'akta_kelahiran' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // maksimal 2MB
            'kartu_keluarga' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'nama.required' => 'Data wajib diisi',
            'nama.unique' => 'Nama anak asuh sudah digunakan, harap pilih nama yang lain.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
            'agama.required' => 'Agama wajib diisi',
            'status.required' => 'Status wajib diisi',
            'akta_kelahiran.required' => 'Akta Kelahiran wajib diisi',
            'kartu_keluarga.required' => 'Kartu Keluarga wajib diisi',
            'ktp.required' => 'KTP wajib diisi',
            'akta_kelahiran.file' => 'Berkas Akta Kelahiran harus berupa file',
            'akta_kelahiran.mimes' => 'Format file Akta Kelahiran tidak valid. Pilih format pdf, jpg, jpeg, atau png',
            'akta_kelahiran.max' => 'Ukuran file Akta Kelahiran tidak boleh lebih dari 2MB',
            'kartu_keluarga.file' => 'Berkas Kartu Keluarga harus berupa file',
            'kartu_keluarga.mimes' => 'Format file Kartu Keluarga tidak valid. Pilih format pdf, jpg, jpeg, atau png',
            'kartu_keluarga.max' => 'Ukuran file Kartu Keluarga tidak boleh lebih dari 2MB',
            'ktp.file' => 'Berkas KTP harus berupa file',
            'ktp.mimes' => 'Format file KTP tidak valid. Pilih format pdf, jpg, jpeg, atau png',
            'ktp.max' => 'Ukuran file KTP tidak boleh lebih dari 2MB',
        ]);
        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $birthCertificatePath = $request->file('akta_kelahiran')->store('uploads/akta-kelahiran');
            $familyCardPath = $request->file('kartu_keluarga')->store('uploads/kartu-keluarga');
            $ktpPath = $request->file('ktp')->store('uploads/kartu-pengenal');

            $data = [
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'status' => $request->status,
                'akta_kelahiran' => $birthCertificatePath,
                'kartu_keluarga' => $familyCardPath,
                'ktp' => $ktpPath,
            ];

            AnakAsuh::create($data);

            return response()->json(['success' => "Berhasil menyimpan data"]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = AnakAsuh::find($id);
        if (!$data) {
            return response()->json(['errors' => ['Anak tidak ditemukan']]);
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
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'status' => 'required',
            'akta_kelahiran' => 'file|mimes:pdf,jpg,jpeg,png|max:2048', // maksimal 2MB
            'kartu_keluarga' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'nama.required' => 'Data wajib diisi',
            'nama.unique' => 'Nama anak asuh sudah digunakan, harap pilih nama yang lain.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
            'agama.required' => 'Agama wajib diisi',
            'status.required' => 'Status wajib diisi',
            'akta_kelahiran.file' => 'Berkas Akta Kelahiran harus berupa file',
            'akta_kelahiran.mimes' => 'Format file Akta Kelahiran tidak valid. Pilih format pdf, jpg, jpeg, atau png',
            'akta_kelahiran.max' => 'Ukuran file Akta Kelahiran tidak boleh lebih dari 2MB',
            'kartu_keluarga.file' => 'Berkas Kartu Keluarga harus berupa file',
            'kartu_keluarga.mimes' => 'Format file Kartu Keluarga tidak valid. Pilih format pdf, jpg, jpeg, atau png',
            'kartu_keluarga.max' => 'Ukuran file Kartu Keluarga tidak boleh lebih dari 2MB',
            'ktp.file' => 'Berkas KTP harus berupa file',
            'ktp.mimes' => 'Format file KTP tidak valid. Pilih format pdf, jpg, jpeg, atau png',
            'ktp.max' => 'Ukuran file KTP tidak boleh lebih dari 2MB',
        ]);
        // Cek jika validasi gagal
        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        }

        // Ambil data anak berdasarkan ID
        $data = AnakAsuh::find($id);

        // Cek jika data anak tidak ditemukan
        if (!$data) {
            return response()->json(['errors' => ['Anak tidak ditemukan']]);
        }

        $birthCertificatePath = $request->file('akta_kelahiran')->store('uploads/akta-kelahiran');
        $familyCardPath = $request->file('kartu_keluarga')->store('uploads/kartu-keluarga');
        $ktpPath = $request->file('ktp')->store('uploads/kartu-pengenal');

        // Update data anak
        $data->nama = $request->nama;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tanggal_lahir = $request->tanggal_lahir;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->agama = $request->agama;
        $data->status = $request->status;
        $data->akta_kelahiran = $birthCertificatePath;
        $data->kartu_keluarga = $familyCardPath;
        $data->ktp = $ktpPath;

        // Periksa dan simpan file-file yang diunggah jika ada
        if ($request->hasFile('akta_kelahiran')) {
            // Hapus file lama sebelum menyimpan yang baru
            Storage::delete($data->akta_kelahiran);

            // Simpan file yang baru
            $data->akta_kelahiran = $request->file('akta_kelahiran')->getClientOriginalName();
        }

        if ($request->hasFile('kartu_keluarga')) {
            Storage::delete($data->kartu_keluarga);
            $data->kartu_keluarga = $request->file('kartu_keluarga')->getClientOriginalName();
        }

        if ($request->hasFile('ktp')) {
            Storage::delete($data->ktp);
            $data->ktp = $request->file('ktp')->getClientOriginalName();
        }

        // Simpan perubahan
        $data->save();

        return response()->json(['success' => "Berhasil memperbarui data"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        AnakAsuh::find($id)->delete();
        return response()->json(['success'=>'Data berhasil Dihapus']);
    }
}
