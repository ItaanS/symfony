<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Season;
use App\Entity\Programm;
use App\Repository\EpisodeRepository;
use App\Repository\ProgrammRepository;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('{id}', requirements: ['id' => '\d+'], name: 'show', methods: ['GET'])]
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

    #[Route('{programId}/season/{seasonId}', name: 'season_show', methods: 'GET')]
    //#[Entity('program', options: ['mapping'=> ['programId'=>'id']])]
    //#[Entity('season', options: ['mapping'=>['seasonId'=>'id']])]
    public function showSeason(int $programId, int $seasonId, ProgrammRepository $programRepository, SeasonRepository $seasonRepository)
    {

        $program = $programRepository->findOneBy(['id' => $programId]);
        $seasons = $seasonRepository->findOneBy(['id' => $seasonId]);

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'seasons' => $seasons
        ]);
    }

    #[Route('{programId}/season/{seasonId}/episode/{episodeId}', name: 'episode_show', methods: 'GET')]
    public function showEpisode(ProgrammRepository $programmRepository, SeasonRepository $seasonRepository, EpisodeRepository $episodeRepository, int $programId, int $seasonId, int $episodeId)
    {
        $program = $programmRepository->findOneBy(['id' => $programId]);
        $season = $seasonRepository->findOneBy(['id' => $seasonId]);
        $episode = $episodeRepository->findOneBy(['id' => $episodeId]);

        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
        ]);
    }
}
