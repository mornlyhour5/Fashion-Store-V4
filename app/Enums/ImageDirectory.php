<?php

namespace App\Enums;

enum ImageDirectory:string
{
    case PROFILE = 'profile';
    case PRODUCT = 'product';
    case BRAND = 'brand';
    case CATEGORIES = 'category';
    case GROUP = 'group';
    case VARIANT = 'variant';
    case PAYMENT = 'payment';
    case PRODUCT_MODEL = 'product_model';
    case SERVICE = 'service';
    case AVATAR = 'avata';
}
