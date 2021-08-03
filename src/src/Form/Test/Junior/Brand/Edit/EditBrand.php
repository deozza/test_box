<?php


namespace App\Form\Test\Junior\Brand\Edit;


class EditBrand
{
    /**
     * @var int $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $productName
     */
    private $productName;

    /**
     * @var int $productSellCount
     */
    private $productSellCount;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     */
    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    /**
     * @return int
     */
    public function getProductSellCount(): int
    {
        return $this->productSellCount;
    }

    /**
     * @param int $productSellCount
     */
    public function setProductSellCount(int $productSellCount): void
    {
        $this->productSellCount = $productSellCount;
    }

}