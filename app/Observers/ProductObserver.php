<?php

namespace App\Observers;

use App\Models\Product;
use App\Events\ProductEvent;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $product->message = "Product created successfully";
        event(new ProductEvent($product));
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $product->message = "Product updated successfully";
        event(new ProductEvent($product));
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $product->message = "Product deleted successfully";
        event(new ProductEvent($product));
    }

}
