<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'Welcome to API',
        'available_endpoint' => [
            'auth' => [
                'login' => [
                    'method' => 'POST',
                    'url' => '/auth/login',
                    'body' => [
                        'username' => 'string|required|max:255',
                        'password' => 'string|required|min:8'
                    ]
                ],
                'register' => [
                    'method' => 'POST',
                    'url' => '/auth/register',
                    'body' => [
                        'username' => 'string|required|max:255',
                        'password' => 'string|required|min:8',
                        'nama_lengkap' => 'string|required|max:255',
                        'email' => 'string|required|max:255',
                        'type' => 'integer|required|max:255'
                    ]
                ],
                'refresh' => [
                    'method' => 'GET',
                    'url' => '/auth/refresh',
                    'body' => [
                        'token' => 'string|required|max:255'
                    ]
                ],
                'update' => [
                    'method' => 'PUT',
                    'url' => '/auth/update',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'username' => 'string|required|max:255',
                        'password' => 'string|required|min:8',
                        'nama_lengkap' => 'string|required|max:255',
                        'email' => 'string|required|max:255',
                        'type' => 'integer|required|max:255'
                    ]
                ],
                'delete-account' => [
                    'method' => 'DELETE',
                    'url' => '/auth/delete-account',
                    'body' => [
                        'token' => 'string|required|max:255'
                    ]
                ],
                'user' => [
                    'method' => 'GET',
                    'url' => '/auth/user',
                    'body' => [
                        'token' => 'string|required|max:255'
                    ]
                ],
                'logout' => [
                    'method' => 'POST',
                    'url' => '/auth/logout',
                    'body' => [
                        'token' => 'string|required|max:255'
                    ]
                ]
            ],
            'user' => [
                'index' => [
                    'method' => 'GET',
                    'url' => '/user',
                    'body' => [
                        'token' => 'string|required|max:255'
                    ]
                ],
                'show' => [
                    'method' => 'GET',
                    'url' => '/user/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required'
                    ]
                ],
                'destroy' => [
                    'method' => 'DELETE',
                    'url' => '/user/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required'
                    ]
                ],
            ],
            'kelas' => [
                'index' => [
                    'method' => 'GET',
                    'url' => '/kelas',
                    'body' => [
                        'token' => 'string|required|max:255'
                    ]
                ],
                'store' => [
                    'method' => 'POST',
                    'url' => '/kelas',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'nama_kelas' => 'string|required|max:255'
                    ]
                ],
                'show' => [
                    'method' => 'GET',
                    'url' => '/kelas/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required'
                    ]
                ],
                'update' => [
                    'method' => 'PUT',
                    'url' => '/kelas/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required',
                        'nama_kelas' => 'string|required|max:255'
                    ]
                ],
                'destroy' => [
                    'method' => 'DELETE',
                    'url' => '/kelas/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required'
                    ]
                ]
            ],
            'siswa' => [
                'index' => [
                    'method' => 'GET',
                    'url' => '/siswa',
                    'body' => [
                        'token' => 'string|required|max:255'
                    ]
                ],
                'store' => [
                    'method' => 'POST',
                    'url' => '/siswa',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'nama_siswa' => 'string|required|max:255',
                        'tanggal_lahir' => 'date|required',
                        'jenis_kelamin' => 'string|required|max:255',
                        'alamat' => 'string|required|max:255',
                        'id_kelas' => 'integer|required'
                    ]
                ],
                'show' => [
                    'method' => 'GET',
                    'url' => '/siswa/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required'
                    ]
                ],
                'update' => [
                    'method' => 'PUT',
                    'url' => '/siswa/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required',
                        'nama_siswa' => 'string|required|max:255',
                        'tanggal_lahir' => 'date|required',
                        'jenis_kelamin' => 'string|required|max:255',
                        'alamat' => 'string|required|max:255',
                        'id_kelas' => 'integer|required'
                    ]
                ],
                'destroy' => [
                    'method' => 'DELETE',
                    'url' => '/siswa/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required'
                    ]
                ]
            ],
            'buku' => [
                'index' => [
                    'method' => 'GET',
                    'url' => '/buku',
                    'body' => [
                        'token' => 'string|required|max:255'
                    ]
                ],
                'store' => [
                    'method' => 'POST',
                    'url' => '/buku',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'judul_buku' => 'string|required|max:255',
                        'author' => 'string|required|max:255',
                        'deskripsi' => 'string|required|max:255',
                        'cover' => 'image|required|mimes:jpeg,png,jpg'
                    ]
                ],
                'show' => [
                    'method' => 'GET',
                    'url' => '/buku/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required'
                    ]
                ],
                'update' => [
                    'method' => 'PUT',
                    'url' => '/buku/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required',
                        'judul_buku' => 'string|required|max:255',
                        'author' => 'string|required|max:255',
                        'deskripsi' => 'string|required|max:255'
                    ]
                ],
                'destroy' => [
                    'method' => 'DELETE',
                    'url' => '/buku/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required'
                    ]
                ],
                'updatecover' => [
                    'method' => 'POST',
                    'url' => '/buku/updatecover/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required',
                        'cover' => 'image|required|mimes:jpeg,png,jpg'
                    ]
                ]
            ],
            'pinjam' => [
                'index' => [
                    'method' => 'GET',
                    'url' => '/pinjam',
                    'body' => [
                        'token' => 'string|required|max:255'
                    ]
                ],
                'store' => [
                    'method' => 'POST',
                    'url' => '/pinjam',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id_buku' => 'integer|required',
                        'id_siswa' => 'integer|required',
                        'tanggal_pinjam' => 'date|required',
                        'tanggal_kembali' => 'date|required'
                    ]
                ],
                'show' => [
                    'method' => 'GET',
                    'url' => '/pinjam/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required'
                    ]
                ],
                'update' => [
                    'method' => 'PUT',
                    'url' => '/pinjam/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required',
                        'id_buku' => 'integer|required',
                        'id_siswa' => 'integer|required',
                        'tanggal_pinjam' => 'date|required',
                        'tanggal_kembali' => 'date|required'
                    ]
                ],
                'destroy' => [
                    'method' => 'DELETE',
                    'url' => '/pinjam/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required'
                    ]
                ]
            ],
            'kembali' => [
                'index' => [
                    'method' => 'GET',
                    'url' => '/buku-kembali',
                    'body' => [
                        'token' => 'string|required|max:255'
                    ]
                ],
                'store' => [
                    'method' => 'POST',
                    'url' => '/buku-kembali',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id_buku' => 'integer|required',
                        'id_siswa' => 'integer|required',
                        'tanggal_pinjam' => 'date|required',
                        'tanggal_kembali' => 'date|required'
                    ]
                ],
                'show' => [
                    'method' => 'GET',
                    'url' => '/buku-kembali/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required'
                    ]
                ],
                'update' => [
                    'method' => 'PUT',
                    'url' => '/buku-kembali/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required',
                        'id_buku' => 'integer|required',
                        'id_siswa' => 'integer|required',
                        'tanggal_pinjam' => 'date|required',
                        'tanggal_kembali' => 'date|required'
                    ]
                ],
                'destroy' => [
                    'method' => 'DELETE',
                    'url' => '/buku-kembali/{id}',
                    'body' => [
                        'token' => 'string|required|max:255',
                        'id' => 'integer|required'
                    ]
                ]
            ]
        ]
    ], 200);
});
