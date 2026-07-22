<?php

use App\Repository\Auth\AuthRepositoryImpl;

use App\Repository\Customer\{
    AddressRepositoryImpl,
    CustomerRepositoryImpl,
    UserRepositoryImpl
};

use App\Repository\Notification\NotificationRepositoryImpl;

use App\Repository\Order\{
    OrderRepositoryImpl,
    OrderItemRepositoryImpl
};

use App\Repository\Coupon\{
    CouponRepositoryImpl,
    CouponUsageRepositoryImpl
};

use App\Repository\Product\{
    CategoryRepositoryImpl,
    BrandRepositoryImpl,
    ProductRepositoryImpl,
    ProductVariantRepositoryImpl,
    ProductImageRepositoryImpl,
};
use App\Repository\Contracts\{
    AuthRepository,
    AddressRepository,
    BrandRepository,
    CategoryRepository,
    CustomerRepository,
    UserRepository,
    CouponRepository,
    CouponUsageRepository,
    NotificationRepository,
    OrderRepository,
    OrderItemRepository,
    ProductRepository,
    ProductVariantRepository,
    ProductImageRepository,
    WishlistItemRepository,
    WishlistRepository,
};

use App\Repository\Wishlist\{
    WishlistRepositoryImpl,
    WishlistItemRepositoryImpl
};

return [
    AuthRepository::class => AuthRepositoryImpl::class,
    AddressRepository::class => AddressRepositoryImpl::class,
    BrandRepository::class => BrandRepositoryImpl::class,
    CategoryRepository::class => CategoryRepositoryImpl::class,
    CustomerRepository::class => CustomerRepositoryImpl::class,
    UserRepository::class => UserRepositoryImpl::class,
    NotificationRepository::class => NotificationRepositoryImpl::class,
    CouponRepository::class => CouponRepositoryImpl::class,
    CouponUsageRepository::class => CouponUsageRepositoryImpl::class,
    OrderItemRepository::class => OrderItemRepositoryImpl::class,
    OrderRepository::class => OrderRepositoryImpl::class,
    ProductRepository::class => ProductRepositoryImpl::class,
    ProductVariantRepository::class => ProductVariantRepositoryImpl::class,
    ProductImageRepository::class => ProductImageRepositoryImpl::class,
    WishlistRepository::class => WishlistRepositoryImpl::class,
    WishlistItemRepository::class => WishlistItemRepositoryImpl::class,
];
