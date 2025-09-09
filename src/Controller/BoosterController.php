<?php

namespace App\Controller;

use App\Repository\BoosterRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BoosterController extends AbstractController
{
    #[Route('/boosters', name: 'booster_index', methods: ['GET'])]
    public function index(BoosterRepository $boosterRepository): Response
    {
        $boosters = $boosterRepository->findAll();

        return $this->render('boosters/index.html.twig', [
            'boosters' => $boosters,
        ]);
    }

    #[Route('/booster/{id}', name: 'booster_show', methods: ['GET'])]
    public function show(int $id, BoosterRepository $boosterRepository): Response
    {
        $booster = $boosterRepository->find($id);

        if (!$booster) {
            throw $this->createNotFoundException('Booster non trouvé.');
        }

        return $this->render('boosters/show.html.twig', [
            'booster' => $booster,
        ]);
    }
}