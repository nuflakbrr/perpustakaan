<?php

namespace App\Http\Controllers;

use App\Models\BookBorrow;
use App\Http\Requests\StoreBookBorrowRequest;
use App\Http\Requests\UpdateBookBorrowRequest;
use Illuminate\Support\Facades\Validator;

class BookBorrowController extends Controller
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
    public function index(BookBorrow $bookBorrow)
    {
        return response()->json([
            'success' => true,
            'message' => 'Menampilkan semua data',
            'data' => $bookBorrow::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookBorrowRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $save = BookBorrow::create([
            'id_siswa' => $request->id_siswa,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali
        ]);

        if ($save) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $save
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BookBorrow $bookBorrow, $id_pinjam_buku)
    {
        if ($bookBorrow::where('id_pinjam_buku', $id_pinjam_buku)->exists()) {
            $borrow_data = $bookBorrow::join('students', 'students.id_siswa', '=', 'book_borrowing.id_siswa')->where('id_pinjam_buku', $id_pinjam_buku)->get();

            return response()->json([
                'success' => true,
                'message' => 'Detail Data Peminjaman Buku',
                'data' => $borrow_data
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
    public function update(UpdateBookBorrowRequest $request, BookBorrow $bookBorrow, $id_pinjam_buku)
    {
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        if ($bookBorrow::where('id_pinjam_buku', $id_pinjam_buku)->exists() == false) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $update = $bookBorrow::where('id_pinjam_buku', $id_pinjam_buku)->update([
            'id_siswa' => $request->id_siswa,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali
        ]);

        if ($update) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
                'data' => $bookBorrow::where('id_pinjam_buku', $id_pinjam_buku)->get()
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal diupdate',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookBorrow $bookBorrow, $id_pinjam_buku)
    {
        $delete = $bookBorrow::where('id_pinjam_buku', $id_pinjam_buku)->delete();

        if ($delete) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dihapus',
            ], 400);
        }
    }
}
