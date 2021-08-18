<?php

namespace App\Controller;

use App\Entity\PresseA;
use App\Form\PresseAType;
use App\Repository\PresseARepository;
use App\Service\ParcoursFileUploader;
use App\Service\PresseAFileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/presse/a")
 */
class PresseAController extends AbstractController
{
    /**
     * @Route("/", name="presse_a_index", methods={"GET"})
     */
    public function index(PresseARepository $presseARepository): Response
    {
        return $this->render('presse_a/index.html.twig', [
            'presse_as' => $presseARepository->findAll(),
        ]);
    }

    /**
     * @Route("/index", name="presse_a_index_admin", methods={"GET"})
     */
    public function indexAdmin(PresseARepository $presseARepository): Response
    {
        return $this->render('admin/presseA/index.html.twig', [
            'presse_as' => $presseARepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="presse_a_new_admin", methods={"GET","POST"})
     */
    public function new(Request $request, PresseAFileUploader $presseAFileUploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $presseA = new PresseA();

        $form = $this->createForm(PresseAType::class, $presseA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileFileName = $presseAFileUploader->upload($imageFile);
                $presseA->setimage($imageFileFileName);
            }
            $this->getDoctrine()->getManager()->persist($presseA);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('presse_a_index_admin');
        }

        return $this->render('admin/presseA/new.html.twig', [
            'presse_a' => $presseA,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="presse_a_show", methods={"GET"})
     */
    public function show(PresseA $presseA): Response
    {
        return $this->render('presse_a/show.html.twig', [
            'presse_a' => $presseA,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="presse_a_edit_admin", methods={"GET","POST"})
     */
    public function edit(Request $request, PresseA $presseA, PresseAFileUploader $presseAFileUploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $imgName = $presseA->getImage();


        $form = $this->createForm(PresseAType::class, $presseA);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


                $imageFile = $form->get('image')->getData();

                if ($imageFile) {
                    $imageFileFileName = $presseAFileUploader->upload($imageFile);
                    $presseA->setimage($imageFileFileName);
                }else{
                    $presseA->setImage($imgName);
                }



            $this->getDoctrine()->getManager()->persist($presseA);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('presse_a_index_admin');
        }

        return $this->render('admin/presseA/edit.html.twig', [
            'presse_a' => $presseA,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="presse_a_delete_admin", methods={"DELETE"})
     */
    public function delete(Request $request, PresseA $presseA): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$presseA->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($presseA);
            $entityManager->flush();
        }

        return $this->redirectToRoute('presse_a_index_admin');
    }
}
