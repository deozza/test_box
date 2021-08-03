<?php


namespace App\Service\Product;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Product;

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
    public function getProductsSoldPerBrands(): array {
        return $this->em->getRepository(Product::class)->getProductsSoldPerBrands();
    }

}