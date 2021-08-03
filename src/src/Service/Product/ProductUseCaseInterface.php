<?php


namespace App\Service\Product;


interface ProductUseCaseInterface
{
    /**
     * @return array
     */
    public function getProductsSoldPerBrands(): array;

}