<?php

namespace App\Controller;

use App\Entity\PresseV;
use App\Form\PresseVType;
use App\Repository\PresseVRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/presse/v")
 */
class PresseVController extends AbstractController
{

    /**
     * @Route("/", name="presse_v_index_admin", methods={"GET"})
     */
    public function indexAdmin(PresseVRepository $presseVRepository): Response
    {
        return $this->render('admin/presseV/index.html.twig', [
            'presse_vs' => $presseVRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="presse_v_new_admin", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $presseV = new PresseV();
        $form = $this->createForm(PresseVType::class, $presseV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($presseV);
            $entityManager->flush();

            return $this->redirectToRoute('presse_v_index_admin');
        }

        return $this->render('admin/presseA/new.html.twig', [
            'presse_v' => $presseV,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="presse_v_show", methods={"GET"})
     */
    public function show(PresseV $presseV): Response
    {
        return $this->render('presse_v/show.html.twig', [
            'presse_v' => $presseV,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="presse_v_edit_admin", methods={"GET","POST"})
     */
    public function edit(Request $request, PresseV $presseV): Response
    {
        $form = $this->createForm(PresseVType::class, $presseV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('presse_v_index_admin');
        }

        return $this->render('admin/presseV/edit.html.twig', [
            'presse_v' => $presseV,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="presse_v_delete_admin", methods={"DELETE"})
     */
    public function delete(Request $request, PresseV $presseV): Response
    {
        if ($this->isCsrfTokenValid('delete'.$presseV->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($presseV);
            $entityManager->flush();
        }

        return $this->redirectToRoute('presse_v_index_admin');
    }
}
