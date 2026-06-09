<?php

namespace App\DTO;

use Illuminate\Http\Request;

class CreateUserDto
{
    public function __construct(
        public readonly string  $name,
        public readonly string  $email,
        public readonly string  $password,
        public readonly ?string $phone              = null,
        public readonly ?string $gender             = null,
        public readonly ?string $date_of_birth      = null,
        public readonly ?string $preferred_language = 'EN',
        public readonly ?string $note               = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name:               $request->input('name'),
            email:              $request->input('email'),
            password:           $request->input('password'),
            phone:              $request->input('phone'),
            gender:             $request->input('gender'),
            date_of_birth:      $request->input('date_of_birth'),
            preferred_language: $request->input('preferred_language', 'EN'),
            note:               $request->input('note'),
        );
    }
}
