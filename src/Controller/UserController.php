<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(UserInterface $user)
    {
        return $this->render('rapport/profil.html.twig', [
            'user' => $user
        ]);
    }
}
