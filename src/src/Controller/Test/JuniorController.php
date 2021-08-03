<?php

namespace App\Controller\Test;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\Brand\UseCase as BrandUseCase;
use App\Service\Product\UseCase as ProductUseCase;
use App\Form\Test\Junior\Brand\Add\AddBrand;
use App\Form\Test\Junior\Brand\Add\AddBrandType;
use App\Form\Test\Junior\Brand\Edit\EditBrand;
use App\Form\Test\Junior\Brand\Edit\EditBrandType;
/**
 * Class JuniorController
 *
 * @Route("/test/junior", name="test_junior_")
 */
class JuniorController extends AbstractController
{
    /**
     * @var BrandUseCase $brandUseCase
     */
    private $brandUseCase;

    /**
     * @var ProductUseCase $productUseCase
     */
    private $productUseCase;

    /**
     * JuniorController constructor.
     * @param BrandUseCase $brandUseCase
     * @param ProductUseCase $productUseCase
     * @param EntityManagerInterface $em
     */
    public function __construct(BrandUseCase $brandUseCase, ProductUseCase $productUseCase){
        $this->brandUseCase = $brandUseCase;
        $this->productUseCase = $productUseCase;
    }

    /**
     * Mise en place de l'algorithme de tri afin de remonter pour chaque marque, le produit associé qui a fait le plus de ventes.
     *
     * @Route("/step1", name="step_1")
     */
    public function step1()
    {
        $products = $this->productUseCase->getProductsSoldPerBrands();

        // Ici ta fonction de tri des ventes
        $mostSoldProductsPerBrand = $this->brandUseCase->getMostSoldProductPerBrands();

        return $this->render('test/junior/step1.html.twig', [
            'products' => $products,
            'results' => $mostSoldProductsPerBrand,
        ]);
    }

    /**
     * Mise en place d'un formulaire de création/édition de marque. Les données doivent être persistées sur l'entité Brand.
     *
     * @Route("/step2", name="step_2")
     */
    public function step2(Request $request)
    {
        $brands = $this->brandUseCase->getBrandsNameAndId();

        $payload = json_decode($request->getContent(), true);

        if($request->getMethod() === 'POST'){
            $addBrand = new AddBrand();
            $form = $this->createForm(AddBrandType::class, $addBrand);
            $result = $this->brandUseCase->addBrand($payload, $form, $addBrand);

            if(!$result->isSuccessful()){
                $this->addFlash('danger',json_encode($result->errors));
            }else{
                $this->addFlash('success', 'Une nouvelle marque a été ajoutée');
            }

            return $this->render('test/junior/step2.html.twig', [
                'brands' => $brands,
            ]);
        }

        if($request->getMethod() === 'PATCH'){
            $editBrand = new EditBrand();
            $form = $this->createForm(EditBrandType::class, $editBrand);

            if(array_key_exists('productName', $payload)){
                $result = $this->brandUseCase->addProductToBrand($payload, $form, $editBrand);
            }else{
                $result = $this->brandUseCase->editBrand($payload, $form, $editBrand);
            }

            if(!$result->isSuccessful()){
                $this->addFlash('danger', json_encode($result->errors));
            }else{
                $this->addFlash('success', 'La marque a été modifiée');
            }

            return $this->render('test/junior/step2.html.twig', [
                'brands' => $brands,
            ]);
        }

        return $this->render('test/junior/step2.html.twig', [
            'brands' => $brands,
        ]);
    }
}
