<?php

namespace App\Http\Resources;

// use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
// use App\Enums\Role;
use Illuminate\Http\Request;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'role'          => $this->role,
            'avata'         => $this->avata,
            'date_of_birth' => $this->date_of_birth,
            'active'        => $this->active,
        ];
    }
}
