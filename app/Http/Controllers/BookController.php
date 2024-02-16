<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
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
    public function index(Book $book)
    {
        return response()->json([
            'success' => true,
            'message' => 'Menampilkan semua data',
            'data' => $book::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'judul_buku' => 'required|max:255',
            'author' => 'required',
            'deskripsi' => 'required',
            'cover' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $cover = null;

        if ($request->cover) {
            $fileName = $this->generateRandomString();
            $extention = $request->cover->getClientOriginalExtension();
            $cover = $fileName . '.' . $extention;

            Storage::putFileAs('public/cover', $request->cover, $cover);
        }

        $save = $book::create([
            'judul_buku' => $request->judul_buku,
            'author' => $request->author,
            'deskripsi' => $request->deskripsi,
            'cover' => $cover
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
    public function show(Book $book, $id_buku)
    {
        if ($book::where('id_buku', $id_buku)->exists()) {
            $data = $book::where('books.id_buku', '=', $id_buku)->get();

            return response()->json([
                'success' => true,
                'message' => 'Detail data',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => ''
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book, $id_buku)
    {
        $validator = Validator::make($request->all(), [
            'judul_buku' => 'required|max:255',
            'author' => 'required',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        if ($book::where('id_buku', $id_buku)->exists() == false) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $update = $book::where('id_buku', $id_buku)->update([
            'judul_buku' => $request->judul_buku,
            'author' => $request->author,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($update) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
                'data' => $book::where('id_buku', $id_buku)->get()
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal diupdate',
                'error' => $validator->errors()
            ], 500);
        }
    }

    public function updateimage(UpdateBookRequest $request, Book $book, $id_buku)
    {
        $validator = Validator::make($request->all(), [
            'cover' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $cover = null;

        if ($request->cover) {
            $data = $book::where('id_buku', $id_buku)->first();

            if ($data->cover) {
                Storage::delete('public/cover/' . $data->cover);
            }

            $fileName = $this->generateRandomString();
            $extention = $request->cover->getClientOriginalExtension();
            $cover = $fileName . '.' . $extention;

            Storage::putFileAs('public/cover', $request->cover, $cover);
        }

        $update = $book::where('id_buku', $id_buku)->update([
            'cover' => $cover
        ]);

        if ($update) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
                'data' => $book::where('id_buku', $id_buku)->get()
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
    public function destroy(Book $book, $id_buku)
    {
        $data = $book::where('id_buku', $id_buku)->first();

        if ($data->cover) {
            Storage::delete('public/cover/' . $data->cover);
        }

        $delete = $book::where('id_buku', $id_buku)->delete();

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

    /**
     * Generate random string for hashing request image filename.
     */
    protected function generateRandomString($length = 30)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0,  $charactersLength - 1)];
        }

        return $randomString;
    }
}
