<?php

use App\Services\Auth\AuthServiceImpl;
use App\Services\Admin\AdminStockServiceImpl;

use App\Services\Customer\{
    AddressServiceImpl,
    CustomerServiceImpl
};

use App\Services\Notification\NotificationServiceImpl;

use App\Services\Order\{
    OrderItemServicesImpl,
    OrdersServicesImpl
};

use App\Services\Coupon\{
    CouponServiceImpl,
    CouponUsageServiceImpl
};

use App\Services\Product\{
    CategoryServiceImpl,
    BrandServicesImpl,
    ProductServicesImpl,
    ProductVariantServicesImpl,
    ProductImageServicesImpl,
};

use App\Services\Contracts\{
    AdminStockService,
    AddressService,
    BrandService,
    CustomerService,
    CategoryServices,
    CouponService,
    CouponUsageService,
    NotificationService,
    OrderService,
    OrderItemService,
    ProductServices,
    ProductVariantServices,
    ProductImageServices,
    AuthService,
    WishlistService,
    WishlistItemService
};

use App\Services\Wishlist\{
    WishlistServiceImpl,
    WishlistItemServiceImpl
};


return [
    AdminStockService::class => AdminStockServiceImpl::class,
    AuthService::class => AuthServiceImpl::class,
    AddressService::class => AddressServiceImpl::class,
    BrandService::class => BrandServicesImpl::class,
    CategoryServices::class => CategoryServiceImpl::class,
    CustomerService::class => CustomerServiceImpl::class,
    CouponService::class => CouponServiceImpl::class,
    CouponUsageService::class => CouponUsageServiceImpl::class,
    NotificationService::class => NotificationServiceImpl::class,
    OrderService::class => OrdersServicesImpl::class,
    OrderItemService::class => OrderItemServicesImpl::class,
    ProductServices::class => ProductServicesImpl::class,
    ProductVariantServices::class => ProductVariantServicesImpl::class,
    ProductImageServices::class => ProductImageServicesImpl::class,
    WishlistService::class => WishlistServiceImpl::class,
    WishlistItemService::class => WishlistItemServiceImpl::class,
];
