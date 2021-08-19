<?php

namespace App\Controller;

use App\Entity\Parcours;
use App\Form\ParcoursType;
use App\Repository\ParcoursRepository;
use App\Service\ParcoursFileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/parcours")
 */
class ParcoursController extends AbstractController
{
    /**
     * @Route("/", name="parcours_index", methods={"GET"})
     */
    public function index(ParcoursRepository $parcoursRepository): Response
    {
        return $this->render('parcours/index.html.twig', [
            'parcours' => $parcoursRepository->findAll(),
        ]);
    }

    /**
     * @Route("/index", name="parcours_index_admin", methods="GET")
     */
    public function indexAdmin( ParcoursRepository $parcoursRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/parcours/index.html.twig', [
            'parcours' => $parcoursRepository->findBy([],['createdAt'=>'DESC']),
            'controller_name' => 'parcours']);
    }


    /**
     * @Route("/new", name="parcours_new_admin", methods={"GET","POST"})
     */
    public function new(Request $request,ParcoursFileUploader $parcoursFileUploader): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $parcour = new Parcours();
        $form = $this->createForm(ParcoursType::class, $parcour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pdfFile = $form->get('pdf')->getData();
            if ($pdfFile) {
                $pdfFileFileName = $parcoursFileUploader->upload($pdfFile);
                $parcour->setPdf($pdfFileFileName);
            }

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileFileName = $parcoursFileUploader->upload($imageFile);
                $parcour->setimage($imageFileFileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($parcour);
            $entityManager->flush();

            return $this->redirectToRoute('parcours_index_admin');
        }

        return $this->render('admin/parcours/new.html.twig', [
            'parcour' => $parcour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="parcours_show_admin", methods={"GET"})
     */
    public function show(Parcours $parcour): Response
    {
        return $this->render('admin/parcours/show.html.twig', [
            'parcour' => $parcour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="parcours_edit_admin", methods={"GET","POST"})
     */
    public function edit(Request $request, Parcours $parcour,ParcoursFileUploader $parcoursFileUploader): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $imgName = $parcour->getImage();
        $pdfName = $parcour->getPdf();


        $form = $this->createForm(ParcoursType::class, $parcour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $parcour->setTitre($form->get('titre')->getData());


            $pdfFile = $form->get('pdf')->getData();

            if ($pdfFile) {
                $pdfFileFileName = $parcoursFileUploader->upload($pdfFile);
                $parcour->setPdf($pdfFileFileName);
            }else{
                $parcour->setPdf($pdfName);
            }



            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileFileName = $parcoursFileUploader->upload($imageFile);
                $parcour->setimage($imageFileFileName);
            }else{
                $parcour->setImage($imgName);
            }

            $this->getDoctrine()->getManager()->persist($parcour);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('parcours_index_admin');
        }

        return $this->render('admin/parcours/edit.html.twig', [
            'parcour' => $parcour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="parcours_delete_admin", methods={"DELETE"})
     */
    public function delete(Request $request, Parcours $parcour): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$parcour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($parcour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('parcours_index_admin');
    }
}
