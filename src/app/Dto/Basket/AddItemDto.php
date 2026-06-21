<?php

namespace App\Dto\Basket;

final class AddItemDto
{
    public int $productId;
    public int $sizeId;
    public int $quantity;

    public function __construct(array $data)
    {
        $this->productId = $data['product_id'];
        $this->sizeId = $data['size_id'];
        $this->quantity = $data['quantity'];
    }

}
