<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Define the middleware.
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    //     $this->middleware('api.admin', ['only' => ['index', 'show']]);
    //     $this->middleware('api.superadmin', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(User $usr)
    {
        return response()->json([
            'success' => true,
            'message' => 'Menampilkan semua data',
            'data' => $usr::all()
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usr, $id)
    {
        $user = $usr::where('id', $id)->first();

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Detail data',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usr, $id)
    {
        $delete = $usr::where('id', $id)->delete();

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
