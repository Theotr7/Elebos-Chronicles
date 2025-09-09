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
        $allCards = $cardRepository->findAll();

        $maxCardCost = 0;
        foreach ($allCards as $card) {
            $cost = $card->getCost();
            if ($cost > $maxCardCost) {
                $maxCardCost = $cost;
            }
        }

        $form = $this->createForm(CollectionFilterType::class, null, [
            'max_cost_limit' => $maxCardCost,
        ]);
        $form->handleRequest($request);
        $filters = $form->getData();

        $selectedRarity = $filters['rarity'] ?? null;
        $cost = $filters['cost'] ?? null;

        $filteredCards = [];
        $rarityOrder = ['commune', 'rare', 'legendaire', 'mythique']; 

        foreach($rarityOrder as $rarity) {
            foreach ($allCards as $card) {
                if($card->getRarity() === $rarity) {
                    if(
                    ($selectedRarity === null || $card->getRarity() === $selectedRarity) &&
                    ($cost === null || $card->getCost() === $cost)) {
                        $filteredCards[] = $card;
                    }
                }
            }
        }

        $userCards = $userCardRepository->findBy(['user' => $user]);
        $ownedCardsCount = [];

        foreach ($userCards as $userCard) {
            $cardId = $userCard->getCard()->getId();

            if (!isset($ownedCardsCount[$cardId])) {
                $ownedCardsCount[$cardId] = 0;
            }
            $ownedCardsCount[$cardId]++;
        }

        return $this->render('collection/index.html.twig', [
            'allCards' => $filteredCards,
            'ownedCardsCount' => $ownedCardsCount,
            'filterForm' => $form->createView(),
        ]);
    }
    
}