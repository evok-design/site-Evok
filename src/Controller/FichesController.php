<?php

namespace App\Controller;

use App\Entity\Fiches;
use App\Form\FichesType;
use App\Repository\FichesRepository;
use App\Service\FichesFileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fiches")
 */
class FichesController extends AbstractController
{
    /**
     * @Route("/", name="fiches_index", methods={"GET"})
     */
    public function index(FichesRepository $fichesRepository): Response
    {
        return $this->render('fiches/index.html.twig', [
            'fiches' => $fichesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/index", name="fiches_index_admin", methods="GET")
     */
    public function indexAdmin( FichesRepository $fichesRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/fiches/index.html.twig', [
            'fiches' => $fichesRepository->findBy([],['createdAt'=>'DESC']),
            'controller_name' => 'fiches']);
    }


    /**
     * @Route("/new", name="fiches_new_admin", methods={"GET","POST"})
     */
    public function new(Request $request, FichesFileUploader $fichesFileUploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');


        $fich = new Fiches();
        $form = $this->createForm(FichesType::class, $fich);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pdfFile = $form->get('pdf')->getData();
            if ($pdfFile) {
                $pdfFileFileName = $fichesFileUploader->upload($pdfFile);
                $fich->setPdf($pdfFileFileName);
            }

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileFileName = $fichesFileUploader->upload($imageFile);
                $fich->setimage($imageFileFileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fich);
            $entityManager->flush();

            return $this->redirectToRoute('fiches_index_admin');
        }

        return $this->render('admin/fiches/new.html.twig', [
            'fich' => $fich,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fiches_show_admin", methods={"GET"})
     */
    public function show(Fiches $fich): Response
    {
        return $this->render('admin/fiches/show.html.twig', [
            'fich' => $fich,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fiches_edit_admin", methods={"GET","POST"})
     */
    public function edit(Request $request, Fiches $fich, FichesFileUploader $fichesFileUploader): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $pdf = $fich->getPdf();
        $imgFile = $fich->getImage();


        $form = $this->createForm(FichesType::class, $fich);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fich->setTitre($form->get('titre')->getData());
            $fich->setSousTitre($form->get('sous_titre')->getData());

            $pdfFile = $form->get('pdf')->getData();
            if ($pdfFile) {
                $pdfFileFileName = $fichesFileUploader->upload($pdfFile);
                $fich->setPdf($pdfFileFileName);
            }else{
                $fich->setPdf($pdf);
            }

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileFileName = $fichesFileUploader->upload($imageFile);
                $fich->setimage($imageFileFileName);
            }else{
                $fich->setImage($imgFile);
            }


            $this->getDoctrine()->getManager()->persist($fich);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fiches_index_admin');
        }

        return $this->render('admin/fiches/edit.html.twig', [
            'fich' => $fich,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fiches_delete_admin", methods={"DELETE"})
     */
    public function delete(Request $request, Fiches $fich): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$fich->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fich);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fiches_index_admin');
    }
}
