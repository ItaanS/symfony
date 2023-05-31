<?php

namespace App\Controller;

use App\Form\CategoryType;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProgrammRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



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
     * The controller for the category add form
     * Display the form or deal with it
     */
    #[Route('new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            // handle data, in example, an insert into database
            $categoryRepository->save($category, true);

            // Redirect to categories list
            return $this->redirectToRoute('category_index');
        }

        // Render the form
        return $this->render('category/new.html.twig', [
            'form' => $form,
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
