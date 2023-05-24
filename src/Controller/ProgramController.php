<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgrammRepository;

#[Route('/program/', name: 'program_', methods: ['GET'])]
class ProgramController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(ProgrammRepository $programRepository): Response
    {
        
        $programs = $programRepository->findAll();
        
        return $this->render('program/index.html.twig', [
            'programs' => $programs
        ]);
    }

    #[Route('{id}', requirements: ['id'=>'\d+'],name: 'show', methods: ['GET'] )]
    public function show(int $id, ProgrammRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        
        // Vérifier si l'id est un entier
        if (!is_int($id)) {
            throw $this->createNotFoundException('Page not found');
        }

        return $this->render('program/show.html.twig', [   
            'program' => $program
        ]);

    }
}