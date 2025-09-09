<?php

namespace App\Controller;

use Twig\Environment;
use DateTimeImmutable;
use App\Entity\Booster;
use App\Entity\UserCard;
use App\Entity\UserBooster;
use App\Service\BoosterOpeningService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserBoosterRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserBoosterController extends AbstractController
{
    #[Route('/booster/{id}/add', name: 'booster_add', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function add(Booster $booster, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $userBooster = new UserBooster();
        $userBooster->setUser($user);
        $userBooster->setBooster($booster);
        $userBooster->setIsOpened(false);
        $userBooster->setObtainedAt(new \DateTimeImmutable());

        $em->persist($userBooster);
        $em->flush();

        $this->addFlash('success', 'Booster ajouté à ta collection !');

        return $this->redirectToRoute('my_boosters');
    }

    #[Route('/my-boosters', name: 'my_boosters')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(UserBoosterRepository $userBoosterRepository): Response
    {
        $user = $this->getUser();

        $userBoosters = $userBoosterRepository->findBy(['user' => $user]);

        $notOpenedBoosters = array_filter($userBoosters, fn($b) => !$b->isOpened());

        return $this->render('user_booster/my_boosters.html.twig', [
            'userBoosters' => $notOpenedBoosters,
        ]);
    }

    #[Route('/api/booster/open/{id}', name: 'api_open_booster', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function apiOpen(UserBooster $userBooster, EntityManagerInterface $em, BoosterOpeningService $opener, Environment $twig): JsonResponse 
    {
        $user = $this->getUser();

        if ($userBooster->getUser() !== $user) {
            return new JsonResponse(['success' => false, 'error' => 'Accès interdit.'], 403);
        }

        if ($userBooster->isOpened()) {
            return new JsonResponse(['success' => false, 'error' => 'Ce booster est déjà ouvert.'], 400);
        }

        $booster = $userBooster->getBooster();
        $cards = $opener->openBooster($booster);

        foreach ($cards as $card) {
            $userCard = new UserCard();
            $userCard->setUser($user);
            $userCard->setCard($card);
            $userCard->setObtainedAt(new \DateTimeImmutable());

            $em->persist($userCard);
        }

        $userBooster->setIsOpened(true);
        $em->flush();

        $html = $twig->render('user_booster/_opened_cards.html.twig', [
            'cards' => $cards,
        ]);

        return new JsonResponse(['success' => true, 'html' => $html]);
    }
    
}