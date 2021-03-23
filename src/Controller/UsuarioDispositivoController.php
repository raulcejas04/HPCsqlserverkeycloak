<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UsuarioDispositivoRepository;
//use App\Repository\UsuarioRepository;
//use App\Repository\DispositivoRepository;

use App\Entity\dispositivos;
use App\Entity\usuario;
use App\Entity\usuarioDispositivo;

/**
* @Route("/usudisp")
*/
class UsuarioDispositivoController extends AbstractController
{
    /**
     * @Route("/", name="usuario_dispositivo")
     */
    public function index( UsuarioDispositivoRepository $usuarioDispositivoRepository ): Response
    {
        //dd($usuarioDispositivoRepository);

        return $this->render('usuario_dispositivo/index.html.twig', [
            'usudisps' => $usuarioDispositivoRepository->findAll(),
        ]);

    }





}
