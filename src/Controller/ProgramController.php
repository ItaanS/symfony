<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(): Response
    {
        
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series',
        ]);

        /*return new Response(
            '<!doctype html><html lang="en"><title>Wild Series</title><body>Wild Series Index</body></html>'
        );*/
    }
}