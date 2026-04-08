<?php

namespace App\CommandBus\Commands\Products;

use Spatie\DataTransferObject\DataTransferObject;

class CreateProductCommand extends DataTransferObject
{
    public string $name;
    public ?string $description;
    public int $price;
    public array $images;
}
