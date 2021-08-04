<?php

namespace App\Controller;

use App\Entity\Actualites;
use App\Form\ActualitesType;
use App\Repository\ActualitesRepository;
use App\Controller\Events;


use App\Entity\NewsletterUsers;
use App\Form\NewsletterUsersType;
use App\Repository\NewsletterUsersRepository;
use Twig\Environment;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


/**
 * @Route("/actualites")
 */
class ActualitesController extends AbstractController
{
//    /**
// * @Route("/", name="actualites_index", methods={"GET"})
// */
//    public function index(ActualitesRepository $actualitesRepository): Response
//    {
//        return $this->redirectToRoute('actualites_index_page', array("page" => 1));
//    }

    /**
     * @Route("/indexAdmin", name="actualite_index_admin", methods={"GET"})
     */
    public function indexAdmin(ActualitesRepository $actualitesRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/actualites/index.html.twig',
            ['actualites' => $actualitesRepository->findBy(array(), array('date' => 'DESC')),
                'controller_name' => 'Actualites']);
    }


    /**
     * @Route("/new", name="actualites_new", methods={"GET","POST"})
     */
    public function new(Request $request, EventDispatcherInterface $eventDispatcher): Response
    {



        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $actualite = new Actualites();
        $form = $this->createForm(ActualitesType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();




            //SET Image Header
            if(!is_null($form['img_header']->getData())) {

                $file = $form['img_header']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('actualites_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $actualite->setImgHeader($filename);
            }


            //SET PREVISU
            if(!is_null($form['img_prev']->getData())) {

                $file = $form['img_prev']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();




                try {
                    $file->move(
                        $this->getParameter('actualites_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $actualite->setImgPrev($filename);
            }

            //SET CONTENT
            if(!is_null($form['img_content']->getData())) {

                $file = $form['img_content']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('actualites_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $actualite->setImgContent($filename);
            }

            $entityManager->persist($actualite);
            $entityManager->flush();


            return $this->redirectToRoute('actualites_edit', array('id' => $actualite->getId()));
        }

        return $this->render('admin/actualites/new.html.twig', [
            'actualite' => $actualite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{page}", name="actualites_index_page", methods={"GET"})
     */
    public function indexPage(Request $request, ActualitesRepository $actualitesRepository): Response
    {




        $actualitHeader = $actualitesRepository->findOneBy(['id'=>99]);
        //dd($actualitHeader);
        $page = $request->get('page');
        $allActualites = $actualitesRepository->findAll();
        $nbActualites = count($allActualites);
        $actualites = $actualitesRepository->loadByPage($page-1);
        $nbPages = ceil($nbActualites/12);

        return $this->render('actualites/index.html.twig', [
            'actualites' => $actualites,
            'nbPages' => $nbPages,
            'page' => $page,
            'header'=> $actualitHeader
        ]);
    }

    /**
     * @Route("/show/{slug}", name="actualites_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Actualites $actualite): Response
    {

        $page = $request->get('page');
        $slides = null;

        if ( !is_null($actualite->getSlider())){

            $slider =$actualite->getSlider();

            $slideRepo = $this->getDoctrine()->getRepository('App:Slide');

            $slides = $slideRepo->findSlideOrder($slider);
        }
        return $this->render('actualites/show.html.twig', [
            'actualite' => $actualite,
            'slides' => $slides,
            'page' => $page
        ]);
    }

    /**
     * @Route("/", name="actualites_date_index", methods={"GET", "POST"})
     */
    public function indexDate(Request $request, ActualitesRepository $actualitesRepository): Response
    {

        if ($request->isXMLHttprequest()) {
            $actualites = $actualitesRepository->LoadByCalendar($request->get('date'));
        }

        $response = [
            "code" => 200,
            "actu" => $actualites,
            "response" => $this->render('actualites/index_date.html.twig', [
                'actualites' => $actualites,])->getContent()
        ];

        return new JsonResponse($response);
    }

    /**
     * @Route("/search", name="actualites_search", methods={"GET", "POST"})
     */
    public function indexSearch(Request $request, ActualitesRepository $actualitesRepository): Response
    {
            $actualites = $actualitesRepository->LoadBySearch($request->get('search'));

        $response = [
            "code" => 200,
            "actu" => $actualites,
            "response" => $this->render('actualites/index_date.html.twig', [
                'actualites' => $actualites,])->getContent()
        ];

        return new JsonResponse($response);
    }




    /**
     * @Route("/{id}/edit", name="actualites_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Actualites $actualite): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $imgPrev =$actualite->getImgPrev();
        $imgHeader  = $actualite->getImgHeader();
        $imgContent  = $actualite->getImgContent();

        $form = $this->createForm(ActualitesType::class, $actualite);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            $actualite->setTitre($form->get('titre')->getData());
            $actualite->setDate($form->get('date')->getData());
            $actualite->setContenu($form->get('contenu')->getData());

            //Image Header
            if(!is_null($form['img_header']->getData())) {

                $file = $form['img_header']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('actualites_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $imgHeader = $filename;

            }

            //Image content
            if(!is_null($form['img_content']->getData())) {

                $file = $form['img_content']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('actualites_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $imgContent = $filename;

            }

            //Image previsu
            if(!is_null($form['img_prev']->getData())) {

                $file = $form['img_prev']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('actualites_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $imgPrev = $filename;

            }

            $actualite->setImgHeader($imgHeader);
            $actualite->setImgContent($imgContent);
            $actualite->setImgPrev($imgPrev);

            $this->getDoctrine()->getManager()->persist($actualite);
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('actualite_index_admin');

        }

        return $this->render('admin/actualites/edit.html.twig', [
            'actualite' => $actualite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="actualites_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Actualites $actualite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actualite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actualite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actualite_index_admin');
    }


//    /**
//     * @Route("/actualites/load", name="actualites_load")
//     */
//    public function load(Request $request, ActualitesRepository $actualitesRepository){
//
//        $index = 0;
//
//        if(!is_null($request->get('begin')) && $request->get('begin') >= 4){
//
//            $index = $request->get('index');
//            $actualites = $actualitesRepository->loadLastCreated(4,$request->get('begin'));
//
//            $response = [
//                "code" => 200,
//                "count" => count($actualites) + $request->get('begin'),
//                "response" => $this->render('elements/actualites.html.twig', ['actualites' => $actualites, 'id' => $index])->getContent()
//            ];
//
//            return new JsonResponse($response);
//
//        }
//    }

//    /**
//     * @Route("/actualites/load_responsive", name="actualites_load_responsive")
//     */
//    public function load_responsive(Request $request, ActualitesRepository $actualitesRepository){
//
//        $index = 0;
//
//        if(!is_null($request->get('begin')) && $request->get('begin') >= 4){
//
//            $index = $request->get('index');
//            $actualites = $actualitesRepository->loadLastCreated(4,$request->get('begin'));
//
//            $response = [
//                "code" => 200,
//                "count" => count($actualites) + $request->get('begin'),
//                "response" => $this->render('elements/actualites_responsive.html.twig', ['actualites' => $actualites, 'id' => $index])->getContent()
//            ];
//
//            return new JsonResponse($response);
//
//        }
//    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
