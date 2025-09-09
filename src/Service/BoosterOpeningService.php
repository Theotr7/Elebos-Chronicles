<?php

namespace App\Service;

use App\Entity\Booster;
use App\Repository\CardRepository;

class BoosterOpeningService
{
    private CardRepository $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    //Ouvre un booster et retourne les cartes tirées.
    public function openBooster(Booster $booster): array
    {
        $cardCount = $booster->getCardCount();
        $categories = $this->getCategoriesFromBooster($booster);

        $rarityChances = [
            'commune' => 70,
            'rare' => 20,
            'légendaire' => 8,
            'mythique' => 2,
        ];

        $drawnCards = [];

        while (count($drawnCards) < $cardCount) {
            $rarity = $this->getRandomRarity($rarityChances);

            $pool = $this->cardRepository->findByRarityAndCategories($rarity, $categories);

            if (empty($pool)) {
                continue;
            }

            $randomCard = $pool[array_rand($pool)];
            $drawnCards[] = $randomCard;
        }

        return $drawnCards;
    }

    private function getCategoriesFromBooster(Booster $booster): ?array
    {
        $name = $booster->getBoosterName();

        return match($name) {
            'Reign Of Dragons' => ['dragon'],
            'Forces du Mal' => ['démon', 'mort-vivant'],
            'Fragment du Savoir' => ['mage'],
            default => null,
        };
    }

    private function getRandomRarity(array $rarityChances): string
    {
        $rand = mt_rand(1, 100);
        $cumulative = 0;

        foreach ($rarityChances as $rarity => $chance) {
            $cumulative += $chance;
            if ($rand <= $cumulative) {
                return $rarity;
            }
        }
        
        return 'commune';
    }

}