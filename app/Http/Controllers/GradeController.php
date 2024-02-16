<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    /**
     * Define the middleware.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('api.admin', ['only' => ['index', 'store', 'show', 'update']]);
        $this->middleware('api.superadmin', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Grade $grade)
    {
        return response()->json([
            'success' => true,
            'message' => 'Menampilkan semua data',
            'data' => $grade::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request, Grade $grade)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $save = $grade::create([
            'nama_kelas' => $request->nama_kelas
        ]);

        if ($save) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $save
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan',
                'error' => $validator->errors()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade, $id_kelas)
    {
        if ($grade::where('id_kelas', $id_kelas)->exists()) {
            $data = $grade::where('grades.id_kelas', '=', $id_kelas)->get();

            return response()->json([
                'success' => true,
                'message' => 'Menampilkan data per id_siswa',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeRequest $request, Grade $grade, $id_kelas)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        if ($grade::where('id_kelas', $id_kelas)->exists() == false) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $update = $grade::where('id_kelas', $id_kelas)->update([
            'nama_kelas' => $request->nama_kelas
        ]);

        if ($update) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
                'data' => $update
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal diupdate',
                'error' => $validator->errors()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade, $id_kelas)
    {
        $delete = $grade::where('id_kelas', $id_kelas)->delete();

        if ($delete) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dihapus',
            ], 500);
        }
    }
}
