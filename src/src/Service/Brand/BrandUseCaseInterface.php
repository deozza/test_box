<?php


namespace App\Service\Brand;


use App\Entity\Brand;
use App\Form\Test\Junior\Brand\Add\AddBrand;
use App\Form\Test\Junior\Brand\Edit\EditBrand;
use App\Service\Utils\UseCaseResults\Result;
use Symfony\Component\Form\FormInterface;

interface BrandUseCaseInterface
{
    /**
     * @return Brand[]
     */
    public function getMostSoldProductPerBrands(): array;

    /**
     * @return Brand[]
     */
    public function getBrandsNameAndId(): array;

    /**
     * @param array $payload
     * @param FormInterface $form
     * @param AddBrand $addBrand
     * @return Result
     */
    public function addBrand(array $payload, FormInterface $form, AddBrand $addBrand): Result;

    /**
     * @param array $payload
     * @param FormInterface $form
     * @param EditBrand $editBrand
     * @return Result
     */
    public function editBrand(array $payload, FormInterface $form, EditBrand $editBrand): Result;

    /**
     * @param array $payload
     * @param FormInterface $form
     * @param EditBrand $editBrand
     * @return Result
     */
    public function addProductToBrand(array $payload, FormInterface $form, EditBrand $editBrand): Result;
}