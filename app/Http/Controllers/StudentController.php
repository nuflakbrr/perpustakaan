<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
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
    public function index(Student $student)
    {
        $student_data = $student::join('grades', 'students.id_kelas', '=', 'grades.id_kelas')
            ->select('students.*', 'grades.nama_kelas')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Menampilkan semua data',
            'data' => $student_data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_siswa' => 'required|max:255',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'id_kelas' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $save = Student::create([
            'nama_siswa' => $request->nama_siswa,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'id_kelas' => $request->id_kelas
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
    public function show(Student $student, $id_siswa)
    {
        if ($student::where('id_siswa', $id_siswa)->exists()) {
            $student_data = $student::join('grades', 'students.id_kelas', '=', 'grades.id_kelas')
                ->where('students.id_siswa', '=', $id_siswa)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Menampilkan data per id_siswa',
                'data' => $student_data
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
    public function update(UpdateStudentRequest $request, Student $student, $id_siswa)
    {
        $validator = Validator::make($request->all(), [
            'nama_siswa' => 'required|max:255',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'id_kelas' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        if ($student::where('id_siswa', $id_siswa)->exists() == false) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $update = $student::where('id_siswa', $id_siswa)->update([
            'nama_siswa' => $request->nama_siswa,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'id_kelas' => $request->id_kelas
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
    public function destroy(Student $student, $id_siswa)
    {
        $delete = $student::where('id_siswa', $id_siswa)->delete();

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
