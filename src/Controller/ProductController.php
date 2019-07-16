<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductController extends AbstractController
{
    /**
     * @Route("/store", name="store")
     * @param ProductService $productService
     * @param Request $request
     *
     * @return Response
     */
    public function showStore(ProductService $productService, Request $request)
    {
        $store = $productService->getStore($request);

        return $this->render('product/store.html.twig', $store);
    }

    /**
     * @Route("/store/{productSlug}", name="product")
     * @ParamConverter("product", options={"mapping": {"productSlug": "slug"}})
     * @param Product $product
     *
     * @return Response
     */
    public function showProduct(Product $product)
    {
        return $this->render('product/product.html.twig', ['product' => $product]);
    }
}
