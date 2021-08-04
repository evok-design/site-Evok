<?php

namespace App\Controller;

use App\Entity\Slide;
use App\Entity\Slider;
use App\Form\SliderType;
use App\Entity\Creation;
use App\Entity\Actualites;
use App\Entity\Bloc;
use App\Repository\SlideRepository;
use App\Repository\SliderRepository;
use App\Repository\CreationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/slider")
 */
class SliderController extends AbstractController
{
    /**
     * @Route("/", name="slider_index", methods={"GET"})
     */
    public function index(SliderRepository $sliderRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');



        return $this->render('admin/slider/index.html.twig', [
            'sliders' => $sliderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="slider_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $slider = new Slider();
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();


            $entityManager->persist($slider);
            $entityManager->flush();

            return $this->redirectToRoute('slider_index');
        }

        return $this->render('admin/slider/new.html.twig', [
            'slider' => $slider,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="slider_show", methods={"GET"})
     */
    public function show(Slider $slider): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/slider/show.html.twig', [
            'slider' => $slider,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="slider_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Slider $slider): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $slideRepo = $this->getDoctrine()->getRepository('App:Slide');

        $slides = $slideRepo->findSlideOrder($slider);

        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('slider_index', [
                'id' => $slider->getId(),
            ]);
        }

        //On récupère l'id du slider
        $idSlider = $slider->getId();

        //On recherche les Création qui utilise ce slider
        $creationRepo = $this->getDoctrine()->getRepository("App:Creation");
        $creation = $creationRepo->findBy(['Slider'=>$idSlider]);

        //On recherche les bloc qui utilise ce slider
        $blocRepo = $this->getDoctrine()->getRepository("App:Bloc");
        $bloc = $blocRepo->findBy(['Slider'=>$idSlider]);

        //On recherche les actualités qui utilise ce slider
        $actuRepo = $this->getDoctrine()->getRepository("App:Actualites");
        $actu = $actuRepo->findBy(['Slider'=>$idSlider]);


        return $this->render('admin/slider/edit.html.twig', [
            'slider' => $slider,
            'slides' => $slides,
            'form' => $form->createView(),
            'creation' => $creation,
            'actu' => $actu,
            'bloc' => $bloc,
        ]);
    }

    /**
     * @Route("/{id}", name="slider_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Slider $slider): Response
    {
        if ($this->isCsrfTokenValid('delete'.$slider->getId(), $request->request->get('_token'))) {

            $idSlider = $slider->getId();

            //Il faut desassocier les sliders aux pages

            //On recherche les Création qui utilise ce slider
            $creationRepo = $this->getDoctrine()->getRepository("App:Creation");
            $creations = $creationRepo->findBy(['Slider'=>$idSlider]);

            //On recherche les bloc qui utilise ce slider
            $blocRepo = $this->getDoctrine()->getRepository("App:Bloc");
            $blocs = $blocRepo->findBy(['Slider'=>$idSlider]);

            //On recherche les actualités qui utilise ce slider
            $actuRepo = $this->getDoctrine()->getRepository("App:Actualites");
            $actus = $actuRepo->findBy(['Slider'=>$idSlider]);

            $entityManager = $this->getDoctrine()->getManager();

            foreach($creations as &$creation){
                $crea->setSlider(null);
                $entityManager->persist($creation);
            }

            unset($creation);

            foreach($blocs as &$bloc){
                $bloc->setSlider(null);
                $entityManager->persist($bloc);
            }

            unset($bloc);

            foreach($actus as &$actu){
                $actu->setSlider(null);
                $entityManager->persist($actu);
            }

            unset($actu);


            $entityManager->remove($slider);
            $entityManager->flush();
        }

        return $this->redirectToRoute('slider_index');
    }

    /**
     * @Route("/{id}/{page}/deleteSliderPage/", name="slider_delete_associationPage", methods={"GET","POST"})
     */
    public function sliderDelAssociationPage(Request $request, Slider $slider): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $idSlider = $request->attributes->get('id');
        $page = $request->attributes->get('page');

        $entityManager = $this->getDoctrine()->getManager();


        if($page == 'creation'){
            $repo = $this->getDoctrine()->getRepository(creation::class);
        }
        if($page == 'actualites'){
            $repo = $this->getDoctrine()->getRepository(Actualites::class);
        }
        if($page == 'bloc'){
            $repo = $this->getDoctrine()->getRepository(Bloc::class);
        }
        $modif = $repo->findOneBy(['Slider'=>$idSlider]);
        $modif->setSlider(null);
        $entityManager->persist($modif);
        $entityManager->flush();

        return $this->redirectToRoute('slider_index');
    }

}
