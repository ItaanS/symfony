<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index', methods: ['GET'])]
    public function index(): Response
    {
        
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series',
        ]);
    }

    #[Route('/program/{id}', requirements: ['id'=>'\d+'],name: 'program_show', methods: ['GET'] )]
    public function show(int $id): Response
    {
        
        // Vérifier si l'id est un entier
        if (!is_int($id)) {
            throw $this->createNotFoundException('Page not found');
        }

        return $this->render('program/show.html.twig', [
            'id' => $id,
        ]);

    }
}