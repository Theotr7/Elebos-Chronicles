<?php

namespace App\Controller;

use App\Repository\CardRepository;
use App\Repository\BoosterRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(BoosterRepository $boosterRepository): Response
    {
        $boosters = $boosterRepository->findAll();

        return $this->render('home.html.twig', [
            'boosters' => $boosters,
        ]);
    }

    #[Route('/', name: 'home')]
public function mythic(CardRepository $cardRepository, BoosterRepository $boosterRepository): Response
{
        // Récupérer toutes les cartes mythiques
        $boosters = $boosterRepository->findAll();

        // 🎴 Récupère toutes les cartes mythiques
        $mythicCards = $cardRepository->findBy(['rarity' => 'mythique']);

        // 🔀 Mélange aléatoire
        shuffle($mythicCards);

        // 🧙‍♂️ Garde 3 cartes aléatoires
        $randomMythics = array_slice($mythicCards, 0, 3);

    return $this->render('home.html.twig', [
        'boosters' => $boosters,
        'mythics' => $randomMythics,
    ]);
}

}