<?php


namespace App\Service\Brand;

use App\Form\Test\Junior\Brand\Add\AddBrand;
use App\Form\Test\Junior\Brand\Edit\EditBrand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

use App\Entity\Brand;
use App\Entity\Product;
use App\Service\Utils\UseCaseResults\Result;

class UseCase
{
    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * UseCase constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getMostSoldProductPerBrands(): array {
        return $this->em->getRepository(Brand::class)->getMostSoldProductPerBrand();
    }

    /**
     * @return array
     */
    public function getBrandsNameAndId(): array {
        return $this->em->getRepository(Brand::class)->getBrandsNameAndId();
    }

    /**
     * @param array $payload
     * @param FormInterface $form
     * @param AddBrand $addBrand
     * @return Result
     */
    public function addBrand(array $payload, FormInterface $form, AddBrand $addBrand): Result{
        $result = new Result();
        $form->submit($payload);

        if($form->isValid() === false){
            $result->addError('INVALID FORM', 400);
            return $result;
        }

        $newBrand = new Brand();
        $newBrand->setName($addBrand->getName());

        $this->em->persist($newBrand);

        $result->setSuccess('CREATED', 201);
        return $result;
    }

    /**
     * @param array $payload
     * @param FormInterface $form
     * @param EditBrand $editBrand
     * @return Result
     */
    public function editBrand(array $payload, FormInterface $form, EditBrand $editBrand): Result {
        $result = new Result();

        $form->submit($payload);

        if($form->isValid() === false){
            $result->addError('INVALID FORM', 400);
            return $result;

        }
        $brand = $this->em->getRepository(Brand::class)->find($editBrand->getId());

        if(empty($brand)){
            $result->addError('BRAND NOT FOUND', 404);
            return $result;
        }

        $brand->setName($editBrand->getName());

        $result->setSuccess('EDITED', 200);
        return $result;
    }

    /**
     * @param array $payload
     * @param FormInterface $form
     * @param EditBrand $editBrand
     * @return Result
     */
    public function addProductToBrand(array $payload, FormInterface $form, EditBrand $editBrand): Result {
        $result = new Result();

        $form->submit($payload);

        if($form->isValid() === false){
            $result->addError('INVALID FORM', 400);
            return $result;

        }
        $brand = $this->em->getRepository(Brand::class)->find($editBrand->getId());

        if(empty($brand)){
            $result->addError('BRAND NOT FOUND', 404);
            return $result;
        }

        $product = new Product();
        $product->setName($editBrand->getProductName());
        $product->setSellCount($editBrand->getProductSellCount());
        $product->setBrand($brand);

        $this->em->persist($product);

        $result->setSuccess('EDITED', 200);
        return $result;
    }}