<?php

namespace App\Services\Cart;

use App\Repository\Cart\CartRepo;

class CartServices
{
    public function __construct(protected CartRepo $cartRepo)
    {
        $this->cartRepo = $cartRepo;
    }

    public function getAll()
    {
        return $this->cartRepo->getAll();
    }

    public function getWhereId($id)
    {
        return $this->cartRepo->findId($id);
    }

    public function create(array $data)
    {
        $data = [
            'user_id' => $data['user_id'],
            'session_id' => $data['session_id'] ?? null
        ];

        return $this->cartRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $cart = $this->cartRepo->findId($id);

        $data = [
            'user_id' => $data['user_id'],
            'session_id' => $data['session_id'] ?? null
        ];

        return $this->cartRepo->update($data, $cart);
    }

    public function delete($id)
    {
        $cart = $this->cartRepo->findId($id);

        return $this->cartRepo->delete($cart);
    }
}
