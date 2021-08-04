<?php

namespace App\Controller;

use App\Entity\Creation;
use App\Entity\Slider;
use App\Entity\Slide;
use App\Form\CreationType;
use App\Repository\CategorieRepository;
use App\Repository\CreationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/nos-realisations")
 */
class CreationController extends AbstractController
{
    /**
     * @Route("/", name="creation_index", methods="GET")
     */
    public function index(CreationRepository $creationRepository, CategorieRepository $categorieRepository): Response
    {

        $categories = $categorieRepository->findAll();
        $nbCreationsInCategories = [];
        for($i = 0; $i < count($categories); $i++){
            $nbCreationsCategorie = count($categories[$i]->getCreation());
            $nbCreationsInCategories[] = $nbCreationsCategorie;
        }

        return $this->render('creation/index.html.twig', [
            'creations' => $creationRepository->findLastCreated(8),
            'allCreations' => $creationRepository->findAll(),
            'categories' => $categories,
            'nbCreationsInCategories' => $nbCreationsInCategories,
        ]);
    }

    /**
     * @Route("/index", name="creation_index_admin", methods="GET")
     */
    public function indexAdmin( CreationRepository $creationRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/creation/index.html.twig', [
            'creations' => $creationRepository->findAllOrderbyPrio(),
            'controller_name' => 'Creation']);
    }

    /**
     * @Route("/new", name="creation_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $creation = new Creation();
        $CreationRepo = $this->getDoctrine()->getRepository(creation::class);
        $form = $this->createForm(CreationType::class, $creation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //IMAGE HEADER
            if(!is_null($form['image_header']->getData())) {

                $file = $form['image_header']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('creations_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $creation->setImageHeader($filename);
            }


            //SET IMAGE 1
            if(!is_null($form['image1']->getData())) {

                $file = $form['image1']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('creations_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $creation->setImage1($filename);
            }

            //SET IMAGE 2
//            if(!is_null($form['image2']->getData())) {
//
//                $file = $form['image2']->getData();
//                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();
//
//                try {
//                    $file->move(
//                        $this->getParameter('creations_directory'),
//                        $filename
//                    );
//                } catch (FileException $e) {
//
//                }
//
//                $creation->setImage2($filename);
//            }

            //SET IMAGE GRAND NB
            if(!is_null($form['img_big_nb']->getData())) {

                $file = $form['img_big_nb']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('creations_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $creation->setImgBigNb($filename);
            }

            //SET IMAGE SMALL NB
//            if(!is_null($form['img_small_nb']->getData())) {
//
//                $file = $form['img_small_nb']->getData();
//                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();
//
//                try {
//                    $file->move(
//                        $this->getParameter('creations_directory'),
//                        $filename
//                    );
//                } catch (FileException $e) {
//
//                }
//
//                $creation->setImgSmallNb($filename);
//            }

            //SET IMAGE CONTENT
            if(!is_null($form['image_content']->getData())) {

                $file = $form['image_content']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('creations_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }
                $creation->setImageContent($filename);

            }


            //SET IMAGE CORPS 2
            if(!is_null($form['image_corps_2']->getData())){
                $file = $form['image_corps_2']->getData();
                $filename = $this->generateUniqueFileName(). '.'.$file->guessExtension();

                try{
                    $file->move(
                        $this->getParameter('creations_directory'),
                        $filename
                    );
                }catch(FileException $e){

                }

                $creation->setImageCorps2($filename);
            }


            $last = $CreationRepo->findLastOrdre();

            if (isset($last[0])){
                $dernierIndexOrdre = $last[0]['ordre'];
                for($i =0 ; $i <= $dernierIndexOrdre ;$i++){

                    $ordreUp = $i + 1;
                    $element = $CreationRepo->findOneBy(['ordre' => $i]);
                    $element->setOrdre($ordreUp);

                }
            }
            $creation->setOrdre(0);

            $creation->setImgSmallNb('a');
            $creation->setImage2('b');


            $em->persist($creation);
            $em->flush();

            return $this->redirectToRoute('creation_index_admin');
        }

        return $this->render('admin/creation/new.html.twig', [
            'creation' => $creation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="creation_show", methods="GET")
     */
    public function show(Creation $creation, CreationRepository $creationRepository): Response
    {

        $otherCreations = $creationRepository->getRelated($creation->getId());
        $creationsArray = [];
        $usedRand = [];
        if(count($otherCreations) < 4){
            for($k = 0; $k < count($otherCreations)-1; $k++){
                $creationsArray[] = $otherCreations[$k];
            }
        }else{
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
        }
        $otherCreations = $creationsArray;

        $slides = null;

        if ( !is_null($creation->getSlider())){

            $slider =$creation->getSlider();
            $slideRepo = $this->getDoctrine()->getRepository('App:Slide');

            $slides = $slideRepo->findSlideOrder($slider);
        }

        return $this->render('creation/show.html.twig', [
            'creation' => $creation,
            'otherCreations' => $otherCreations,
            'slides' =>  $slides,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="creation_edit", methods="GET|POST")
     */
    public function edit(Request $request, Creation $creation): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');


        $image1 = $creation->getImage1();
        $imgBigNB = $creation->getImgBigNb();
        $image2 = $creation->getImage2();
        $imgSmallNB = $creation->getImgSmallNb();
        $imgHeader  = $creation->getImageHeader();
        $imageContent  = $creation->getImageContent();
        $imageCorps2 = $creation->getImageCorps2();

        $form = $this->createForm(CreationType::class, $creation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $creation->setTitle($form->get('title')->getData());
            $creation->setDescription($form->get('description')->getData());
            $creation->setDescription2($form->get('description2')->getData());
            $creation->setClient($form->get('Client')->getData());

            //IMAGE HEADER
            if(!is_null($form['image_header']->getData())) {

                $file = $form['image_header']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('creations_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $imgHeader = $filename;

            }


            //SET IMAGE 1
            if(!is_null($form['image1']->getData())) {

                $file = $form['image1']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('creations_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $image1 = $filename;
            }

            //SET IMAGE 2
//            if(!is_null($form['image2']->getData())) {
//
//                $file = $form['image2']->getData();
//                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();
//
//                try {
//                    $file->move(
//                        $this->getParameter('creations_directory'),
//                        $filename
//                    );
//                } catch (FileException $e) {
//
//                }
//
//                $image2 = $filename;
//            }

            //SET IMAGE GRAND NB
            if(!is_null($form['img_big_nb']->getData())) {

                $file = $form['img_big_nb']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('creations_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $imgBigNB = $filename;

            }

            //SET IMAGE SMALL NB
//            if(!is_null($form['img_small_nb']->getData())) {
//
//                $file = $form['img_small_nb']->getData();
//                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();
//
//                try {
//                    $file->move(
//                        $this->getParameter('creations_directory'),
//                        $filename
//                    );
//                } catch (FileException $e) {
//
//                }
//
//                $imgSmallNB = $filename;
//
//            }

            //SET IMAGE CONTENT
            if(!is_null($form['image_content']->getData())) {

                $file = $form['image_content']->getData();
                $filename = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('creations_directory'),
                        $filename
                    );
                } catch (FileException $e) {

                }

                $imageContent = $filename;

            }


            //SET IMAGE CORPS 2
            if(!is_null($form['image_corps_2']->getData())){
                $file = $form['image_corps_2']->getData();
                $filename = $this->generateUniqueFileName(). '.'.$file->guessExtension();

                try{
                    $file->move(
                        $this->getParameter('creations_directory'),
                        $filename
                    );
                }catch(FileException $e){

                }

                $imageCorps2 = $filename;

            }

            $creation->setImageHeader($imgHeader);
            $creation->setImage1($image1);
            $creation->setImgBigNb($imgBigNB);
            $creation->setImageContent($imageContent);
            $creation->setImageCorps2($imageCorps2);


            $creation->setImage2('a');
            $creation->setImgSmallNb('b'); 


            $this->getDoctrine()->getManager()->persist($creation);
            $this->getDoctrine()->getManager()->flush();

            $this->redirectToRoute('creation_index_admin');

        }


        return $this->render('admin/creation/edit.html.twig', [
            'creation' => $creation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="creation_delete", methods="DELETE")
     */
    public function delete(Request $request, Creation $creation): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$creation->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();

            $ordre = $creation->getOrdre();
            $CreationRepo = $this->getDoctrine()->getRepository(creation::class);

            $last = $CreationRepo->findLastOrdre();
            $dernierIndexOrdre = $last[0]['ordre'];

            for($ordre; $ordre < $dernierIndexOrdre; $ordre++){
                $ordreUp = $ordre + 1;

                $element = $CreationRepo->findOneBy(['ordre' => $ordreUp]);
                $element->setOrdre($ordre);
            }

            $em->remove($creation);
            $em->flush();
        }

        return $this->redirectToRoute('creation_index_admin');
    }

    /**
     * @Route("/creations/load", name="creations_load")
     */
    public function load(Request $request, CreationRepository $creationRepository, CategorieRepository $categorieRepository){

        $categoryId = $request->get('category');

        if($categoryId != 'all'){

            try{
                if(!is_null($request->get('begin')) && $request->get('begin') >= 2) {
                    $begin = $request->get('begin');
                    $category = $categorieRepository->find($categoryId);
                    $creations = $category->getCreation(); 

                    $reverseCreations = [];
                    for($i = count($creations)-1; $i >= 0; $i--){
                        $reverseCreations[] = $creations[$i];
                    }

                    $resCreations = [];

                    $countCre = count($creations);

                    if($countCre %2 == 1 && $begin == $countCre - 1){

                        $resCreations[]= $reverseCreations[$begin];

                    }else{
                        for($k = 0; $k < 2; $k++){
                            $resCreations[] = $reverseCreations[$begin + $k];
                        }
                    }

                    $i = $request->get('i');
                    $i = $i+1;


                    if($begin < $countCre){
                        $response = [
                            "code" => 200,
                            "begin" => $begin,
                            "countDebug" => $countCre,
                            "count" => count($creations) + $request->get('begin'),
                            "response" => $this->render('elements/creations.html.twig', ['creations' => $resCreations, 'i' => $i])->getContent()
                        ];
                    }
                    else{
                        $response =[
                            "code" => 500,
                            "begin" => $begin,
                            "countDebug" => $countCre,
                        ];
                    }


                    return new JsonResponse($response);

                }

            }catch(Exception $e){}

        }else{

            try{
                $category = $categorieRepository->find($categoryId);
                if(!is_null($request->get('begin')) && $request->get('begin') >= 2){
                    $i = $request->get('i');
                    $i = $i+1;
                    $creations = $creationRepository->loadLastCreated(2,$request->get('begin'));
                    $response = [
                        "code" => 200,
                        "count" => count($creations) + $request->get('begin'),
                        "response" => $this->render('elements/creations.html.twig', ['creations' => $creations, 'i' => $i])->getContent()
                    ];

                    return new JsonResponse($response);
                }
            }catch(Exception $e){}

        }
    }

    /**
     * @Route("/creations/loadByCategory", name="creations_load_by_category")
     */
    public function loadByCategory(Request $request, CategorieRepository $categorieRepository, CreationRepository $creationRepository){
        $categoryId = $request->get('category');

        try{
            if($categoryId != 'all'){

                $category = $categorieRepository->find($categoryId);
                $creations = $category->getCreation();

               $reverseCreations = [];
               for($i = count($creations)-1; $i >= 0; $i--){
                    $reverseCreations[] = $creations[$i];
               }

                $response = [
                    "code" => 200,
                    "response" => $this->render('elements/creationsByCategory.html.twig', [
                        'creations' => $reverseCreations,
                        'categories' => $categorieRepository->findAll(),
                        //'creationsMax' => $creations
                    ])->getContent()
                ];

                return new JsonResponse($response);

            }else{

                $creations = $creationRepository->loadLastCreated(8);
                $response = [
                    "code" => 200,
                    "response" => $this->render('elements/creationsByCategory.html.twig', [
                        'creations' => $creations,
                        'categories' => $categorieRepository->findAll(),
                    ])->getContent()
                ];
                return new JsonResponse($response);


            }
        }catch(Exception $e){}


    }

    /**
     * @Route("/creations/sortUp", name="CreationSortUp")
     */
    public function SortUp(Request $request, CreationRepository $creationRepository){

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $element = $request->get('idElement');
        $html = $request->get('elemHtml');
        $ordre = $request->get('ordre');
        $id =$request->get('idElement');

        if ($ordre == null or $ordre == 0){

            $response = [
                "info" => "erreur",
            ];

        }else {
            $NewOrdre = ($ordre - 1);


            $element = $creationRepository->findOneBy(['id' => $element]);
            $element2 = $creationRepository->findOneBy(['ordre' => $NewOrdre]);

            $element2->setOrdre($ordre);
            $element->setOrdre($NewOrdre);

            $em = $this->getDoctrine()->getManager();

            $em->flush($element);
            $em->flush($element2);

            $html = '<tr data-id="'.$id. '" data-ordre="'.$ordre.'">' . $html . '</tr>';

            $response = [
                "info" => "ok",
                "html" => $html,
            ];
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/creations/sorDown", name="CreationSortDown")
     */
    public function SortDown(Request $request, CreationRepository $creationRepository){

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $element = $request->get('idElement');
        $html = $request->get('elemHtml');
        $ordre = $request->get('ordre');
        $id =$request->get('idElement');

        $lastOrdre = $creationRepository->findLastOrdre();
        $dernierIndexOrdre = $lastOrdre[0]['ordre'];


        if ($ordre == null or $ordre == $dernierIndexOrdre){

            $response = [
                "info" => "erreur",
            ];

        }else {
            $NewOrdre = ($ordre + 1);


            $element = $creationRepository->findOneBy(['id' => $element]);
            $element2 = $creationRepository->findOneBy(['ordre' => $NewOrdre]);

            $element2->setOrdre($ordre);
            $element->setOrdre($NewOrdre);

            $em = $this->getDoctrine()->getManager();

            $em->flush($element);
            $em->flush($element2);

            $html = '<tr data-id="'.$id. '" data-ordre="'.$ordre.'">' . $html . '</tr>';

            $response = [
                "info" => "ok",
                "html" => $html,
            ];
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/{slug}/creations/delImage", name="creation_delete_image", methods="POST")
     */
    public function deleteImg(Request $request, CreationRepository $creationRepository, Creation $creation): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $element = $request->get('id_image');

        $slug = $creation->getSlug();

        if($element = 'image7'){
            $elementModif = $creationRepository->findOneBy(['slug' => $slug]);
            $elementModif->setImageCorps2(null);

            $em = $this->getDoctrine()->getManager();

            $em->flush($elementModif);
        }

        $response = [
            "info" => "ok"];

        return new JsonResponse($response);

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
