<?php

namespace App\Services\Auth/RegisterImpl;

use App\Repository\Auth/RegisterImpl\Auth/RegisterImplRepository;

class Auth/RegisterImplServices
{
    public function __construct(protected Auth/RegisterImplRepository $Auth/RegisterImplrepository)
    {
        $this->Auth/RegisterImplrepository = $Auth/RegisterImplrepository;
    }

    public function getAll()
    {
        return $this->Auth/RegisterImplrepository->getAll();
    }

    public function getWhereId($id)
    {
        return $this->Auth/RegisterImplrepository->findId($id);
    }

    public function create(array $data)
    {
        $data = [
            '' => $data[''],
        ];

        return $this->Auth/RegisterImplrepository->create($data);
    }

    public function update(array $data, $id)
    {
        $cart = $this->Auth/RegisterImplrepository->findId($id);

        $data = [
            '' => $data[''],
        ];

        return $this->Auth/RegisterImplrepository->update($data, $cart);
    }

    public function delete($id)
    {
        $cart = $this->Auth/RegisterImplrepository->findId($id);

        return $this->Auth/RegisterImplrepository->delete($cart);
    }
}
