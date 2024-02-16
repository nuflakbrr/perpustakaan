<?php

namespace App\Http\Controllers;

use App\Models\BookReturn;
use App\Http\Requests\StoreBookReturnRequest;
use App\Http\Requests\UpdateBookReturnRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class BookReturnController extends Controller
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
    public function index(BookReturn $bookReturn)
    {
        return response()->json([
            'success' => true,
            'message' => 'Menampilkan semua data',
            'data' => $bookReturn::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookReturnRequest $request, BookReturn $bookReturn)
    {
        $validator = Validator::make($request->all(), [
            'id_penjam_buku' => 'required',
            // 'tanggal_kembali' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $check_data = $bookReturn::where('id_pinjam_buku', $request->id_pinjam_buku)->first();

        if ($check_data->count() == 0) {
            $return = $check_data;
            $date_now = Carbon::now()->format('Y-m-d');
            $return_date = new Carbon($return->tanggal_kembali);
            $amercement = 1500;

            if (strtotime($date_now) > strtotime($return_date)) {
                $total_days = $return_date->diffInDays($date_now);
                $total_amercement = $total_days * $amercement;
            } else {
                $total_days = 0;
                $total_amercement = 0;
            }

            $save = BookReturn::create([
                'id_pinjam_buku' => $request->id_pinjam_buku,
                'tanggal_kembali' => $return_date,
                'denda' => $total_amercement
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

        // $save = BookReturn::create([
        //     'id_penjam_buku' => $request->id_penjam_buku,
        //     'tanggal_kembali' => $request->tanggal_kembali,
        //     'denda' => $request->denda
        // ]);

        // if ($save) {
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Data berhasil disimpan',
        //         'data' => $save
        //     ], 200);
        // } else {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Data gagal disimpan',
        //         'data' => ''
        //     ], 400);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(BookReturn $bookReturn, $id_buku_kembali)
    {
        if ($bookReturn::where('id_buku_kembali', $id_buku_kembali)->exists()) {
            $data = $bookReturn::join('book_borrow', 'book_borrow.id_pinjam_buku', '=', 'book_returns.id_pinjam_buku')->where('book_returns.id_buku_kembali', '=', $id_buku_kembali)->get();

            return response()->json([
                'success' => true,
                'message' => 'Detail data',
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
    public function update(UpdateBookReturnRequest $request, BookReturn $bookReturn, $id_buku_kembali)
    {
        $validator = Validator::make($request->all(), [
            'id_penjam_buku' => 'required',
            'tanggal_kembali' => 'required',
            'denda' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $update = $bookReturn::where('id_buku_kembali', $id_buku_kembali)->update([
            'id_penjam_buku' => $request->id_penjam_buku,
            'tanggal_kembali' => $request->tanggal_kembali,
            'denda' => $request->denda
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
                'data' => ''
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookReturn $bookReturn, $id_buku_kembali)
    {
        $delete = $bookReturn::where('id_buku_kembali', $id_buku_kembali)->delete();

        if ($delete) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
                'data' => $delete
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dihapus',
                'data' => ''
            ], 400);
        }
    }
}
