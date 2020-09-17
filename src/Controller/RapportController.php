<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Rapport;
use App\Entity\User;
use App\Form\CommentaireType;
use App\Form\CommentType;
use App\Form\RapportType;
use App\Repository\RapportRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/rapport")
 */
class RapportController extends AbstractController
{
    /**
     * @Route("/", name="rapport_index", methods={"GET"})
     */
    public function index(RapportRepository $rapportRepository): Response
    {
        return $this->render('rapport/index.html.twig', [
            'rapports' => $rapportRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rapport_new", methods={"GET","POST"})
     */
    public function new(UserInterface $user, Request $request): Response
    {
        $user = $this->getUser();
        $rapport = new Rapport();
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $rapport->setCreatedAt(new \DateTime())
                    ->setAuteur($user);
                                
            $entityManager->persist($rapport);
            $entityManager->flush();

            return $this->redirectToRoute('rapport_index');
        }

        return $this->render('rapport/new.html.twig', [
            'rapport' => $rapport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rapport_show", methods={"GET","POST"})
     */
    public function show(UserInterface $user, Rapport $rapport, Request $request, UserRepository $userRepository): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $commentaire->setCreatedAt(new \DateTime())
                        ->setRapports($rapport)
                        ->setAuteur($user->getUsername())
;
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('rapport_index');
        
        }
        
        return $this->render('rapport/show.html.twig', [
            'rapport' => $rapport,
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rapport_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rapport $rapport): Response
    {
        
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rapport_index');
        }

        return $this->render('rapport/edit.html.twig', [
            'rapport' => $rapport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rapport_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rapport $rapport): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rapport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rapport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rapport_index');
    }

}

