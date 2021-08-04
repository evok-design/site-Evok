<?php

namespace App\Controller;

use App\Entity\NewsletterUsers;
use App\Form\NewsletterUsersType;
use App\Repository\NewsletterUsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/newsletter/users")
 */
class NewsletterUsersController extends AbstractController
{
    /**
     * @Route("/", name="newsletter_users_index", methods={"GET"})
     */
    public function index(NewsletterUsersRepository $newsletterUsersRepository): Response
    {
        return $this->render('newsletter_users/index.html.twig', [
            'newsletter_users' => $newsletterUsersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="newsletter_users_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $newsletterUser = new NewsletterUsers();
        $form = $this->createForm(NewsletterUsersType::class, $newsletterUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletterUser);
            $entityManager->flush();

            //return $this->redirectToRoute('actualites_index');

            return $this->render('newsletter_users/new.html.twig', [
                'newsletter_user' => $newsletterUser,
                'form' => $form->createView(),
                'message' => 'Inscription réussie !',
            ]);
        }

        return $this->render('newsletter_users/new.html.twig', [
            'newsletter_user' => $newsletterUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="newsletter_users_show", methods={"GET"})
     */
    public function show(NewsletterUsers $newsletterUser): Response
    {
        return $this->render('newsletter_users/show.html.twig', [
            'newsletter_user' => $newsletterUser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="newsletter_users_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NewsletterUsers $newsletterUser): Response
    {
        $form = $this->createForm(NewsletterUsersType::class, $newsletterUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('newsletter_users_index');
        }

        return $this->render('newsletter_users/edit.html.twig', [
            'newsletter_user' => $newsletterUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="newsletter_users_delete", methods={"DELETE"})
     */
    public function delete(Request $request, NewsletterUsers $newsletterUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newsletterUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($newsletterUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('newsletter_users_index');
    }
}
