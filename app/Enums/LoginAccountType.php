<?php

namespace App\Enums;

enum LoginAccountType:string
{
    case PHONE = 'phone';
    case EMAIL = 'email';
    case USERNAME = 'username';
    case FACEBOOK = 'facebook';
    case GOOGLE = 'google';
}
