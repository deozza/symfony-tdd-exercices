<?php

namespace App\Controller;

use App\Form\User\PostUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'postLogin')]
    public function postUser(Request $request): Response
    {
        return new Response(
            status: 201);
    }
}