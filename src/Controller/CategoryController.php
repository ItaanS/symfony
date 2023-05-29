<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgrammRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/category/', name: 'category_', methods: ['GET'])]
class CategoryController extends AbstractController
{

    /**
     * List all categories ordr by DESC 
     * 
     */
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        
        $categorys = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categorys' => $categorys

        ]);
    }


    /**
     * Show categories
     * 
     */
    #[Route('{categoryName}', name: 'show', methods: ['GET'])]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgrammRepository $programmRepository): Response
    {
        /** @var Category $category */
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);
        
        if (null === $category) {
            throw $this->createNotFoundException('No category');
        }
        
        $programs = $programmRepository->findBy(['category' => $category->getId()]);

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programs,
        ]);
    }

}
