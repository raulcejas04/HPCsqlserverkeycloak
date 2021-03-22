<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UsuarioDispositivoRepository;
//use App\Repository\UsuarioRepository;
//use App\Repository\DispositivoRepository;

use App\Entity\Dispositivos;
use App\Entity\Usuario;
use App\Entity\UsuarioDispositivo;

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


    /**
    * @Route("/usuario/{idusuario}/disp/{iddispositivo}", name="admin_post_show")
    */
    public function edit( Request $request, $idusuario, $iddispositivo ) : Response
    {
        echo "idusu $idusuario iddisp $iddispositivo<br>";
        die();
        //$usudisp = $repository->findOneBy(['idusuario' => 'idusuario','iddispositivo'=>$iddispositivo]);
        /*$usudisp = $this->getDoctrine()
            ->getRepository(UsuarioDispositivo::class)
            ->find($idusuario,$iddispositivo);*/

    }
}
