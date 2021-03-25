<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

use App\Form\usuarioType;

use App\Repository\UsuarioDispositivoRepository;
//use App\Repository\UsuarioRepository;
//use App\Repository\DispositivoRepository;

use App\Entity\dispositivos;
use App\Entity\usuario;
use App\Entity\usuarioDispositivo;

use Knp\Component\Pager\PaginatorInterface;

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
//        HOLA
        $usuarios = $this->getDoctrine()
            ->getRepository(usuario::class)
            ->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController', 'usuarios' => $usuarios
        ]);
    }

    /**
     * @Route("/list", name="usuario_list")
     */
    public function list( Request $request, PaginatorInterface $paginator)
    {
            // Retrieve the entity manager of Doctrine
            $em = $this->getDoctrine()->getManager();
            
            // Get some repository of data, in our case we have an Appointments entity
            $usuariosRepository = $em->getRepository(usuario::class);
                    
            // Find all the data on the Appointments table, filter your query as you need
            //->where('p.activo != :activo')
            //->setParameter('activo', '1')

            $allUsuariosQuery = $usuariosRepository->createQueryBuilder('p')
                ->getQuery();
            
            // Paginate the results of the query
            $pagination = $paginator->paginate(
                // Doctrine Query, not results
                $allUsuariosQuery,
                // Define the page parameter
                $request->query->getInt('page', 1),
                // Items per page
                15
            );
            
            // Render the twig view
            return $this->render('usuario/index.twig', 
                ['pagination' => $pagination]
            );
    }


     /**
     * @Route("/{id}/edit", name="usuario_edit")
     */
    public function edit( usuario $usuario, Request $request, EntityManagerInterface $em ): Response
    {
        //dd($usuario);
        if (null === $usuario ) {
//            throw $this->createNotFoundException('No existe el Usuario para el id '.$id);
            throw $this->createNotFoundException('No existe el Usuario para el id '.$request->get('id'));
        }

        $originalDisp = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($usuario->getUsuarioDispositivo() as $usuarioDispositivo) {
            $originalDisp->add($usuarioDispositivo->getDispositivos());
        }


        $form = $this->createForm(UsuarioType::class, $usuario );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($form->getData());
            $em->flush();
            // redirect back to some edit page
            return $this->redirectToRoute('usuario_edit', ['id' => $usuario->getIdUserHpc()]);

        }

        return $this->render('usuario/edit.twig', [
            'usuario' => $usuario,
            'usuarioForm' => $form->createView(),
        ]);
    }

}
