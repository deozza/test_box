<?php

namespace App\Controller\Test;

use App\Form\Test\Junior\Brand\Edit\EditBrand;
use App\Form\Test\Junior\Brand\Edit\EditBrandType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Brand;
use App\Entity\Product;
use App\Service\Brand\UseCase as BrandUseCase;
use App\Form\Test\Junior\Brand\Add\AddBrand;
use App\Form\Test\Junior\Brand\Add\AddBrandType;
use App\Form\Test\Junior\Brand\Edit\AddProductToBrand;
use App\Form\Test\Junior\Brand\Edit\AddProductToBrandType;

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
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * JuniorController constructor.
     * @param BrandUseCase $brandUseCase
     */
    public function __construct(BrandUseCase $brandUseCase, EntityManagerInterface $em){
        $this->brandUseCase = $brandUseCase;
        $this->em = $em;
    }

    /**
     * Mise en place de l'algorithme de tri afin de remonter pour chaque marque, le produit associé qui a fait le plus de ventes.
     *
     * @Route("/step1", name="step_1")
     */
    public function step1()
    {
        $products = $this->em->getRepository(Product::class)->findAll();

        // Ici ta fonction de tri des ventes
        $mostSoldProductsPerBrand = $this->brandUseCase->getMostSoldProductPerBrands($products);

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
        $brands = $this->em->getRepository(Brand::class)->findAll();

        $payload = json_decode($request->getContent(), true);

        if($request->getMethod() === 'POST'){
            $addBrand = new AddBrand();
            $form = $this->createForm(AddBrandType::class, $addBrand);
            $result = $this->brandUseCase->addBrand($payload, $form, $addBrand);

            if(!$result->isSuccessful()){
                $this->addFlash('danger',json_encode($result->errors));
            }else{
                $this->addFlash('success', 'Une nouvelle marque a été ajoutée');
                $this->em->flush();
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
                $this->em->flush();
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
