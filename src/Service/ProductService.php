<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;


class ProductService
{
    private $categoryRepository;

    private $productRepository;

    private $paginator;

    /**
     * ProductService constructor.
     * @param CategoryRepository $categoryRepository
     * @param ProductRepository $productRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository, PaginatorInterface $paginator) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getStore(Request $request): array
    {
        $categories = $this->getAllCategories();
        $products = $this->getAllProducts($request);

        return [
            'categories' => $categories,
            'products' => $products
        ];
    }

    /**
     * @return array
     */
    private function getAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    /**
     * @param Request $request
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    private function getAllProducts(Request $request)
    {
        $queryProducts = $this->productRepository->findAll();

        return $this->paginator->paginate(
            $queryProducts,
            $request->query->getInt('page', 1),
            Product::LIMIT_FOR_STORE
        );
    }
}