<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\KeyCloakApiController;

class UserKeyController extends AbstractController
{
    #[Route('/user/key/{firstname}/{lastname}/{username}/{email}', name: 'user_key')]
    public function index( KeyCloakApiController $keycloak_api, string $firstname, string $lastname, string $username, string $email ): Response
    {
        $keycloak_api->postUsuario( $username, $email, $firstname, $lastname );
        return $this->render('user_key/index.html.twig', [
            'controller_name' => 'UserKeyController',
        ]);
    }
}
