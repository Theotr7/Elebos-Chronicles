<?php

namespace App\Controller;

use App\Form\CollectionFilterType;
use App\Repository\CardRepository;
use App\Repository\UserCardRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CollectionController extends AbstractController
{
    #[Route('/collection', name: 'user_collection')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(Request $request, CardRepository $cardRepository, UserCardRepository $userCardRepository): Response
    {
        $user = $this->getUser();

        // 1. Récupère toutes les cartes déjà triées (par rareté et coût)
        $allCards = $cardRepository->findAllOrderedByRarity();

        // 2. Déterminer le coût max pour ajuster le filtre dynamique
        $maxCardCost = max(array_map(fn($card) => $card->getCost(), $allCards));

        // 3. Créer et gérer le formulaire de filtre
        $form = $this->createForm(CollectionFilterType::class, null, [
            'max_cost_limit' => $maxCardCost,
        ]);
        $form->handleRequest($request);
        $filters = $form->getData() ?? [];

        $selectedRarity = $filters['rarity'] ?? null;
        $cost = $filters['cost'] ?? null;

        // 4. Appliquer les filtres côté PHP (tout en gardant l’ordre initial du repository)
        $filteredCards = array_filter($allCards, function ($card) use ($selectedRarity, $cost) {
            return (!$selectedRarity || $card->getRarity() === $selectedRarity)
                && (!$cost || $card->getCost() === $cost);
        });

        // 5. Compter les cartes possédées par l'utilisateur
        $userCards = $userCardRepository->findBy(['user' => $user]);
        $ownedCardsCount = [];

        foreach ($userCards as $userCard) {
            $cardId = $userCard->getCard()->getId();
            $ownedCardsCount[$cardId] = ($ownedCardsCount[$cardId] ?? 0) + 1;
        }

        return $this->render('collection/collection.html.twig', [
            'allCards' => $filteredCards,
            'ownedCardsCount' => $ownedCardsCount,
            'filterForm' => $form->createView(),
        ]);
    }
    
}