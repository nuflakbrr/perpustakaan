<?php

namespace App\Http\Controllers;

use App\Models\DetailBorrow;
use App\Http\Requests\StoreDetailBorrowRequest;
use App\Http\Requests\UpdateDetailBorrowRequest;

class DetailBorrowController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDetailBorrowRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailBorrow $detailBorrow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDetailBorrowRequest $request, DetailBorrow $detailBorrow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailBorrow $detailBorrow)
    {
        //
    }
}
