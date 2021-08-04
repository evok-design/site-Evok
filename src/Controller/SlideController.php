<?php

namespace App\Controller;

use App\Entity\Slide;
use App\Entity\Slider;
use App\Form\SlideType;
use App\Repository\SlideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/slide")
 */
class SlideController extends AbstractController
{
    /**
     * @Route("/", name="slide_index", methods={"GET"})
     */
    public function index(SlideRepository $slideRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $slides = $slideRepository->findBy(array(), array('slider' => 'desc'));

        return $this->render('admin/slide/index.html.twig', [
            'slides' => $slides,
        ]);
    }


    /**
     * @Route("/new", name="slider_add_picture", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');


        $sliderId = $request->get('slider');

        $slide = new Slide();

        if( !is_null($request->get('slider'))){
            $slider = $this->getDoctrine()->getRepository(Slider::class)->find($request->get('slider'));
            $slide->setSlider($slider);
        }

        $form = $this->createForm(SlideType::class, $slide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $slide->setDescription($form->get('description')->getData());
            $slide->setSlider($form->get('slider')->getData());


            if(!is_null($form['url_image']->getData())) {

                $file = $form['url_image']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('slider_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $slide->setUrlImage($filename);
            }

            $entityManager->persist($slide);
            $entityManager->flush();

            return $this->redirectToRoute('slider_edit', array('id' => $sliderId));
        }

        return $this->render('admin/slide/new.html.twig', [
            'slide' => $slide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="slide_show", methods={"GET"})
     */
    public function show(Slide $slide): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('slide/show.html.twig', [
            'slide' => $slide,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="slide_edit", methods="GET|POST")
     */
    public function edit(Request $request, Slide $slide): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $image = $slide->getUrlImage();


        $form = $this->createForm(SlideType::class, $slide);
        $form->handleRequest($request);




        if ($form->isSubmitted() && $form->isValid()) {
            $slide->setDescription($form->get('description')->getData());
            $slide->setSlider($form->get('slider')->getData());

            if(!is_null($form['url_image']->getData())) {


                $file = $form['url_image']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('slider_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }
                $image = $filename;
            }

            $slide->setUrlImage($image);

            $this->getDoctrine()->getManager()->persist($slide);
            $this->getDoctrine()->getManager()->flush();

            $this->redirectToRoute('slide_index');
        }

        return $this->render('admin/slide/edit.html.twig', [
            'slide' => $slide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="slide_delete", methods={"POST", "GET", "DELETE"})
     */
    public function delete(Request $request, Slide $slide): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $sliderId = $slide->getSlider()->getId();

        if ($this->isCsrfTokenValid('delete'.$slide->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($slide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('slider_edit', array('id' => $sliderId));
    }


    /**
     * @Route("/{id}/rank", name="slide_tabindex")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tabindexSlide(Request $request){

        $this->denyAccessUnlessGranted('ROLE_ADMIN');


        if($request->isXmlHttpRequest()) {


            $tabindex = $request->get('tabindex');

            $entityManager = $this->getDoctrine()->getManager();
            $slideRepo = $this->getDoctrine()->getRepository(Slide::class);

            foreach ($tabindex as $key=>$value){
                $slide = $slideRepo->find($value);
                $slide->setTabindex($key);

            $entityManager->flush($slide);
            }



            return new \Symfony\Component\HttpFoundation\Response();

        }

    }



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
