<?php

namespace App\Controller;

use App\Form\User\PostUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    #[Route('/user', name: 'postUser', methods:['POST'])]
    public function postUser(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);
        $form = $this->createForm(PostUserType::class);
        $form->submit($payload);

        if(!$form->isValid()) {
            return new Response(
                status: 400,
                headers: ['Content-Type' => 'application/json'],
                content: json_encode([
                    'message' => 'Invalid data'
                ])
            );
        }

        if(is_string($payload['password']) === false){
            return new Response(
                status: 400,
                headers: ['Content-Type' => 'application/json'],
                content: json_encode([
                    'message' => 'Invalid data'
                ])
            );
        }

        return new Response(
            status: 201,
            headers: ['Content-Type' => 'application/json'],
            content: json_encode([
                'id' => 1,
                'dateCreation'=> 1,
                'dateUpdate'=> 1,
                'username'=> 1,
                'email'=> 1
            ])
        );
    }
}
