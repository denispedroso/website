<?php

namespace App\Observers;

use App\Brand;
use App\Product;
use App\Type;

class ProductObserver
{
    /**
     * Handle the product "saved" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function saved(Product $product)
    {
        Type::find($product->type_id)->brands()->attach(Brand::find($product->brand_id));
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        Type::find($product->type_id)->brands()->desattach(Brand::find($product->brand_id));
    }
}
