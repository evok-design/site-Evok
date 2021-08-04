<?php

namespace App\Controller;

use App\Entity\Bloc;
use App\Entity\Creation;
use App\Form\BlocType;
use App\Repository\BlocRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlocController extends AbstractController
{
//    /**
//     * @Route("/", name="bloc_index", methods="GET")
//     */
//    public function index(BlocRepository $blocRepository): Response
//    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
//
//        return $this->render('bloc/index.html.twig', ['blocs' => $blocRepository->findAll()]);
//    }
    /**
     * @Route("/", name="index")
     */
    public function index(BlocRepository $blocRepository)
    {

        $blocs = $blocRepository->findAll();

        return $this->render('pages/index.html.twig', [
            'controller_name' => 'PagesController',
            'blocs' => $blocs
        ]);
    }

    /**
     * @Route("/bloc/index", name="bloc_index_admin", methods="GET")
     */
    public function indexAdmin(BlocRepository $blocRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/bloc/index.html.twig', ['blocs' => $blocRepository->findAll()]);
    }

    /**
     * @Route("/bloc/new", name="bloc_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $bloc = new Bloc();
        $form = $this->createForm(BlocType::class, $bloc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if(!is_null($form['image']->getData())) {

                $file = $form['image']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('blocs_directory'),
                        $filename
                    );
                } catch (FileException $e) {}

                $bloc->setImage($filename);
            }

            if(!is_null($form['imgHeader']->getData())) {

                $file = $form['imgHeader']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('blocs_directory'),
                        $filename
                    );
                } catch (FileException $e) {}

                $bloc->setImgHeader($filename);
            }

            if(!is_null($form['imgContent1']->getData())) {

                $file = $form['imgContent1']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('blocs_directory'),
                        $filename
                    );
                } catch (FileException $e) {}

                $bloc->setImgContent1($filename);
            }

            if(!is_null($form['imgContent2']->getData())) {

                $file = $form['imgContent2']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('blocs_directory'),
                        $filename
                    );
                } catch (FileException $e) {}

                $bloc->setImgContent2($filename);
            }

            $em->persist($bloc);
            $em->flush();

            return $this->redirectToRoute('bloc_index_admin');
        }

        return $this->render('admin/bloc/new.html.twig', [
            'bloc' => $bloc,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nos-prestations/{slug}", name="bloc_show", methods="GET")
     */
    public function show(Bloc $bloc): Response
    {

        $creationRepository = $this->getDoctrine()->getRepository(Creation::class);

        $categories = [];
        foreach ($bloc->getCategorie()->getValues() as $key => $value){
            array_push($categories, $value->getId());
        }

        $slides = null;

        if ( !is_null($bloc->getSlider())){

            $slider =$bloc->getSlider();
            $slideRepo = $this->getDoctrine()->getRepository('App:Slide');

            $slides = $slideRepo->findSlideOrder($slider);
        }

//        $otherCreations = $creationRepository->getRelatedCategories($categories);
        $otherCreations = $creationRepository->findAll();

        $creationsArray = [];
        $usedRand = [];
        $i = 0;
        while($i <= 2){
            $rand = round(mt_rand(0, count($otherCreations)-1));
            if(!in_array($rand, $usedRand)){
                $creationsArray[] = $otherCreations[$rand];
                $usedRand[] = $rand;
            }else{
                $i--;
            }
            $i++;
        }
        $otherCreations = $creationsArray;


        return $this->render('bloc/show.html.twig', [
            'bloc' => $bloc,
            'otherCreations' => $otherCreations,
            'slides' =>  $slides,
        ]);
    }

    /**
     * @Route("/bloc/{id}/edit", name="bloc_edit", methods="GET|POST")
     */
    public function edit(Request $request, Bloc $bloc): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $image = $bloc->getImage();
        $imgHeader = $bloc->getImgHeader();
        $imgContent1 = $bloc->getImgContent1();
        $imgContent2 = $bloc->getImgContent2();

        $form = $this->createForm(BlocType::class, $bloc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if(!is_null($form['image']->getData())) {

                $file = $form['image']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('blocs_directory'),
                        $filename
                    );
                } catch (FileException $e) {}

                $image = $filename;
            }

            if(!is_null($form['imgHeader']->getData())) {

                $file = $form['imgHeader']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('blocs_directory'),
                        $filename
                    );
                } catch (FileException $e) {}

                $imgHeader = $filename;
            }


            if(!is_null($form['imgContent1']->getData())) {

                $file = $form['imgContent1']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('blocs_directory'),
                        $filename
                    );
                } catch (FileException $e) {}

                $imgContent1 = $filename;
            }

            if(!is_null($form['imgContent2']->getData())) {

                $file = $form['imgContent2']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('blocs_directory'),
                        $filename
                    );
                } catch (FileException $e) {}

                $imgContent2 = $filename;
            }

            if(!is_null($image)){
                $bloc->setImage($image);
            }
            if(!is_null($imgContent1)){
                $bloc->setImgContent1($imgContent1);
            }
            var_dump($imgHeader);
            if(!is_null($imgHeader)){
                $bloc->setImgHeader($imgHeader);
            }
            if(!is_null($imgContent2)){
                $bloc->setDescription2($imgContent2);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bloc_index_admin', ['id' => $bloc->getId()]);
        }

        return $this->render('admin/bloc/edit.html.twig', [
            'bloc' => $bloc,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bloc/{id}", name="bloc_delete", methods="DELETE")
     */
    public function delete(Request $request, Bloc $bloc): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$bloc->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bloc);
            $em->flush();
        }

        return $this->redirectToRoute('bloc_index_admin');
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
