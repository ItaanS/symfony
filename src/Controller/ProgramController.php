<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Season;
use App\Entity\Programm;
use App\Entity\Actor;
use App\Repository\EpisodeRepository;
use App\Repository\ProgrammRepository;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Service\ProgramDuration;


#[Route('/program/', name: 'program_', methods: ['GET'])]
class ProgramController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(ProgrammRepository $programRepository, RequestStack $requestStack): Response
    {

        $session = $requestStack->getSession();
        if (!$session->has('total')) {
            $session->set('total', 0);
        }
        $total = $session->get('total');
        $programs = $programRepository->findAll();


        return $this->render('program/index.html.twig', [
            'programs' => $programs
        ]);
    }

    #[Route('new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProgrammRepository $programRepository, SluggerInterface $slugger)
    {
        $programm = new Programm();
        $form = $this->createForm(ProgramType::class, $programm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($programm->getTitle());
            $programm->setSlug($slug);
            $programRepository->save($programm, true);

            $this->addFlash('success', 'Nouveau programme est crée !!');

            // Redirect to categories list
            return $this->redirectToRoute('program_index');
        }

        // Render the form
        return $this->render('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('{slug}', requirements: ['page' => '\d+'], name: 'show', methods: ['GET'])]
    public function show(Programm $programm, ProgramDuration $programDuration): Response
    {
        return $this->render('program/show.html.twig', [
            'program' => $programm,
            //'programDuration' => $programDuration->calculate($programm)
        ]);
    }

    #[Route('{programId}/season/{seasonId}', name: 'season_show', methods: 'GET')]
    #[ParamConverter('programm', options: ['mapping' => ['programId' => 'id']])]
    #[ParamConverter('season', options: ['mapping' => ['seasonId' => 'id']])]
    public function showSeason(Programm $programm, Season $season)
    {
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

    // function showActor(Actor $actor) 
    // {
    //     return $this->render('program/index.html.twig', [
    //         'actor' => $actor
    //     ]);
    // }
}
