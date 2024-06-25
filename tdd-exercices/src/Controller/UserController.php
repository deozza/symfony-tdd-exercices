<?php

namespace App\Controller;

use App\Form\User\PostUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    #[Route('/user', name: 'postUser', methods: ['POST'])]
    public function postUser(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);
        $form = $this->createForm(PostUserType::class);
        $form->submit($payload);

        if (!$form->isValid()) {
            return new Response(
                json_encode(['message' => 'Invalid data']),
                400,
                ['Content-Type' => 'application/json']
            );
        }

        if (!is_string($payload['password'])) {
            return new Response(
                json_encode(['message' => 'Invalid data']),
                400,
                ['Content-Type' => 'application/json']
            );
        }

        return new Response(
            json_encode([
                'id' => 1,
                'dateCreation' => 1,
                'dateUpdate' => 1,
                'username' => 1,
                'email' => 1
            ]),
            201,
            ['Content-Type' => 'application/json']
        );
    }

    #[Route('/login', name: 'loginUser', methods: ['POST'])]
    public function loginUser(Request $request): Response
    {
        // Traitement de la requête de connexion ici...

        return new Response(
            json_encode(['message' => 'Logged in']),
            201,
            ['Content-Type' => 'application/json']
        );
    }
}
