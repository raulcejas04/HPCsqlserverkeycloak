<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\usuarioType;

use App\Repository\UsuarioDispositivoRepository;
//use App\Repository\UsuarioRepository;
//use App\Repository\DispositivoRepository;

use App\Entity\dispositivos;
use App\Entity\usuario;
use App\Entity\usuarioDispositivo;

/**
* @Route("/usuario")
*/
class UsuarioController extends AbstractController
{

     /**
     * @Route("/", name="usuario")
     */
    public function index(): Response
    {
        $usuarios = $this->getDoctrine()
            ->getRepository(usuario::class)
            ->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController', 'usuarios' => $usuarios
        ]);
    }

     /**
     * @Route("/{id}/edit", name="usuario_edit")
     */
    public function edit( usuario $usuario, Request $request ): Response
    {
        //como se llama usuario la ruta general me trae directamente la entidad en el paramentro
        //dd($usuario->getUsuarioDispositivo());
        $entityManager = $this->getDoctrine()->getManager();
        $dispositivos = $entityManager->getRepository(dispositivos::class)->findAll();
        //dd($dispositivos);

        $form = $this->createForm(UsuarioType::class, $usuario );
        //dd($form->getData());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            //$usudisp=$form->getData();
            $em->persist($form->getData());
            $em->flush();
            return $this->redirectToRoute('usuario_index');
        }

        return $this->render('usuario/edit.twig', [
            'usuario' => $usuario,
            'usuarioForm' => $form->createView(),
        ]);
    }

}
