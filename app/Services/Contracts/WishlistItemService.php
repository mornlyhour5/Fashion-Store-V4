<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface WishlistItemService
{
    public function getallitems(Request $request);

    public function getallitemAdmin(Request $request);

    public function create(Request $request);

    public function delete(int $id);


    // for admin
    public function getWishlishItemAdmin(Request $request, int $id);
}
