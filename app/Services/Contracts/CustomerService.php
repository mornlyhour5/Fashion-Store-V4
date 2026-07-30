<?php

namespace App\Services\Contracts;

// use Illuminate\Http\Request;

interface CustomerService
{
    public function getAllcustomer();

    public function customerProfile(int $id);

    public function customerProfileDetail(int $id); //this route for admin

    public function userProfile(int $id);

    public function updateProfile(int $id, array $data);

    public function getAllUser(array $filters = []); // get user role customer only

    public function getAllStaff(array $filters = []); // get data from user table where role staff

    public function updatecustomerStatus(array $data, int $id);

   public function getUserById(int $id);


   //for user
    public function updateAvatar(array $data, int $id);
}
