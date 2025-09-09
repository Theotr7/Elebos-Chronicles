<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/card')]
#[IsGranted('ROLE_ADMIN')]
class AdminCardController extends AbstractController
{
    #[Route('/', name: 'admin_card_index')]
    public function index(CardRepository $cardRepository): Response
    {
        $cards = $cardRepository->findAllOrderedByRarity();
        
        return $this->render('admin/card/index.html.twig', [
            'cards' => $cards,
        ]);
    }

    #[Route('/new', name: 'admin_card_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($card);
            $em->flush();
        

            return $this->redirectToRoute('admin_card_index');
        }

        return $this->render('admin/card/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_card_edit')]
    public function edit(Card $card, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_card_index');
        }

        return $this->render('admin/card/edit.html.twig', [
            'form' => $form->createView(),
            'card' => $card,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_card_delete', methods: ['POST'])]
    public function delete(Card $card, Request $request, EntityManagerInterface $em): Response
    {
        $em->remove($card);
        $em->flush();

        return $this->redirectToRoute('admin_card_index');
    }
    
}