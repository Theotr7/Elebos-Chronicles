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

        return $this->render('boosters/boosters_list.html.twig', [
            'boosters' => $boosters,
        ]);
    }
}