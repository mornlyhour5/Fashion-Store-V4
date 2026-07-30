<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface WishlistService
{
    public function getWistList(Request $request);

    public function create(Request $request);



    //for admin
    public function getWishlishAdmin();
}
