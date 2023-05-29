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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProgramType;


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

    #[Route('new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProgrammRepository $programRepository)
    {
        $programm = new Programm();
        $form = $this->createForm(ProgramType::class, $programm);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $programRepository->save($programm, true);

            // Redirect to categories list
            return $this->redirectToRoute('program_index');
        }

        // Render the form
        return $this->render('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('{id}', requirements: ['id' => '\d+'], name: 'show', methods: ['GET'])]
    public function show(Programm $programm): Response
    {
        return $this->render('program/show.html.twig', [
            'program' => $programm
        ]);
    }

    #[Route('{programId}/season/{seasonId}', name: 'season_show', methods: 'GET')]
    #[ParamConverter('programm', options: ['mapping' => ['programId' => 'id']])]
    #[ParamConverter('season', options: ['mapping' => ['seasonId' => 'id']])]
    public function showSeason(Programm $programm, Season $season)
    {

        // $program = $programRepository->findOneBy(['id' => $programId]);
        // $seasons = $seasonRepository->findOneBy(['id' => $seasonId]);

        return $this->render('program/season_show.html.twig', [
            'program' => $programm,
            'seasons' => $season
        ]);
    }

    #[Route('{programId}/season/{seasonId}/episode/{episodeId}', name: 'episode_show', methods: 'GET')]
    #[ParamConverter('programm', options: ['mapping' => ['programId' => 'id']])]
    #[ParamConverter('season', options: ['mapping' => ['seasonId' => 'id']])]
    #[ParamConverter('episode', options: ['mapping' => ['episodeId' => 'id']])]
    public function showEpisode(Programm $programm, Season $season, Episode $episode)
    {
        // $program = $programmRepository->findOneBy(['id' => $programId]);
        // $season = $seasonRepository->findOneBy(['id' => $seasonId]);
        // $episode = $episodeRepository->findOneBy(['id' => $episodeId]);

        return $this->render('program/episode_show.html.twig', [
            'program' => $programm,
            'season' => $season,
            'episode' => $episode
        ]);
    }
}
