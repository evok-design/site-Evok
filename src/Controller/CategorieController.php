<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/prestations")
 */
class CategorieController extends AbstractController
{
//    /**
//     * @Route("/", name="categorie_index", methods="GET")
//     */
//    public function index(CategorieRepository $categorieRepository): Response
//    {
//        return $this->render('categorie/index.html.twig', ['categories' => $categorieRepository->findAll(),'controller_name' => 'Categorie']);
//    }

    /**
     * @Route("/index", name="categorie_index_admin", methods="GET")
     */
    public function indexAdmin(CategorieRepository $categorieRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/categorie/index.html.twig', ['categories' => $categorieRepository->findAll(),'controller_name' => 'Categorie']);
    }

    /**
     * @Route("/new", name="categorie_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('categorie_index_admin');
        }

        return $this->render('admin/categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
            'controller_name' => 'Categorie'
        ]);
    }

//    /**
//     * @Route("/{slug}", name="categorie_show", methods="GET")
//     */
//    public function show(Categorie $categorie): Response
//    {
//        return $this->render('categorie/show.html.twig', ['categorie' => $categorie]);
//    }

    /**
     * @Route("/{slug}/edit", name="categorie_edit", methods="GET|POST")
     */
    public function edit(Request $request, Categorie $categorie): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_index_admin', ['id' => $categorie->getId()]);
        }

        return $this->render('admin/categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
            'controller_name' => 'Categorie',
        ]);
    }

    /**
     * @Route("/{slug}", name="categorie_delete", methods="DELETE")
     */
    public function delete(Request $request, Categorie $categorie): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$categorie->getSlug(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorie);
            $em->flush();
        }

        return $this->redirectToRoute('categorie_index_admin');
    }
}
