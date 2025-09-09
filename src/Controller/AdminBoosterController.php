<?php

namespace App\Controller;

use App\Entity\Booster;
use App\Form\BoosterType;
use App\Repository\BoosterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/booster')]
#[IsGranted('ROLE_ADMIN')]
class AdminBoosterController extends AbstractController
{
    #[Route('/', name: 'admin_booster_index')]
    public function index(BoosterRepository $boosterRepository): Response
    {
        return $this->render('admin/booster/index.html.twig', [
            'boosters' => $boosterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_booster_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $booster = new Booster();
        $form = $this->createForm(BoosterType::class, $booster);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($booster);
            $em->flush();
        

            return $this->redirectToRoute('admin_booster_index');
        }

        return $this->render('admin/booster/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_booster_edit')]
    public function edit(Booster $booster, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(BoosterType::class, $booster);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_booster_index');
        }

        return $this->render('admin/booster/edit.html.twig', [
            'form' => $form->createView(),
            'booster' => $booster,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_booster_delete', methods: ['POST'])]
    public function delete(Booster $booster, Request $request, EntityManagerInterface $em): Response
    {
        $em->remove($booster);
        $em->flush();

        return $this->redirectToRoute('admin_booster_index');
    }
    
}