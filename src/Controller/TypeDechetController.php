<?php

namespace App\Controller;

use App\Entity\TypeDechet;
use App\Form\TypeDechetType;
use App\Repository\TypeDechetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/type-dechet')]
class TypeDechetController extends AbstractController
{
    #[Route('/', name: 'app_typedechet_index', methods: ['GET'])]
    public function index(TypeDechetRepository $repository): Response
    {
        return $this->render('type_dechet/index.html.twig', [
            'type_dechets' => $repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_typedechet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $typeDechet = new TypeDechet();
        $form = $this->createForm(TypeDechetType::class, $typeDechet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($typeDechet);
            $em->flush();

            $this->addFlash('success', '✅ Type de déchet ajouté avec succès.');

            return $this->redirectToRoute('app_typedechet_index');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', '❌ Erreur : veuillez corriger les champs.');
        }

        return $this->render('type_dechet/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_typedechet_show', methods: ['GET'])]
    public function show(TypeDechet $typeDechet): Response
    {
        return $this->render('type_dechet/show.html.twig', [
            'type_dechet' => $typeDechet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_typedechet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeDechet $typeDechet, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TypeDechetType::class, $typeDechet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            $this->addFlash('success', '✏ Type de déchet modifié avec succès.');

            return $this->redirectToRoute('app_typedechet_index');
        }

        return $this->render('type_dechet/edit.html.twig', [
            'form' => $form->createView(),
            'type_dechet' => $typeDechet,
        ]);
    }

    #[Route('/{id}', name: 'app_typedechet_delete', methods: ['POST'])]
    public function delete(Request $request, TypeDechet $typeDechet, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeDechet->getId(), $request->request->get('_token'))) {

            $em->remove($typeDechet);
            $em->flush();

            $this->addFlash('success', '🗑 Type de déchet supprimé avec succès !');
        } else {
            $this->addFlash('danger', '❌ Suppression refusée (token invalide).');
        }

        return $this->redirectToRoute('app_typedechet_index');
    }
}
