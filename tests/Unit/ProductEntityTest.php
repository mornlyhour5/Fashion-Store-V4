<?php

namespace Tests\Unit;

use App\DTO\ProductDTO;
use App\Domain\Entities\ProductEntity;
use Tests\TestCase;

class ProductEntityTest extends TestCase
{
    public function test_it_exposes_the_product_name(): void
    {
        $dto = new ProductDTO(
            category_id: 1,
            name: 'Summer Dress',
            slug: 'summer-dress',
            base_price: 49.99,
        );

        $entity = ProductEntity::fromDTO($dto);

        $this->assertSame('Summer Dress', $entity->name());
    }
}
