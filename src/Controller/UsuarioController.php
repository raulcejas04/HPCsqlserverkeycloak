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

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Controller\KeyCloakApiController;

/**
* @Route("/usuario")
*/
class UsuarioController extends AbstractController
{

    /**
     * @Route("/", name="usuario_list")
     */
    public function index( Request $request, PaginatorInterface $paginator, SessionInterface $session )
    {
        $pagination = $this->pagination( $paginator, $request, $session, 0 );
            
        // Render the twig view
        /*return $this->render('usuario/index.twig', 
                ['pagination' => $pagination]
            );*/
        return $this->render('usuario/index.twig', 
            ['pagination' => $pagination, 'page'=>$pagination->getCurrentPageNumber() ]
        );


    }

    /**
     * @Route("/list/{filtro<[A-z]*>}", defaults={"filtro"=null}, name="usuario_list_page")
     */
    public function list_page( Request $request, PaginatorInterface $paginator, SessionInterface $session, 
        string $filtro='' )
    {
        $page = $request->query->get('page');
        $filter = $request->query->get('user-filter');
        if( !isset($page) OR strlen($filter)>0 ) $page=0;


        $pagination = $this->pagination( $paginator, $request, $session, $page, $filter );
            
        return $this->render('usuario/index.twig', 
            ['pagination' => $pagination, 'page'=>$page ]
        );


    }




    /**
     * @Route("/{id}/show", name="usuario_show")
     */
    public function show( usuario $usuario, Request $request, EntityManagerInterface $em, 
        PaginatorInterface $paginator, SessionInterface $session, int $page  ): Response
    {
        $page = $request->query->get('page');
        //dd($usuario);
        if (null === $usuario ) {
//            throw $this->createNotFoundException('No existe el Usuario para el id '.$id);
            throw $this->createNotFoundException('No existe el Usuario para el id '.$request->get('id'));
        }

        $form = $this->createForm( UsuarioType::class, $usuario, array( 'disabled'=>true ) );
        $form->handleRequest($request);

        $pagination = $this->pagination( $paginator, $request, $session, $page );

        return $this->render('usuario/index.twig', [
            'usuarioForm' => $form->createView(),
            'usuario' => $usuario,
            'pagination' => $pagination,
            'page' => $page,
            'edit' => 'N'
        ]);
    }


     /**
     * @Route("/{id}/edit", name="usuario_edit")
     */
    public function edit( usuario $usuario, Request $request, EntityManagerInterface $em, 
        PaginatorInterface $paginator, SessionInterface $session  ): Response
    {
        //dd($usuario);
        $page = $request->query->get('page');
        if (null === $usuario ) {
//            throw $this->createNotFoundException('No existe el Usuario para el id '.$id);
            throw $this->createNotFoundException('No existe el Usuario para el id '.$request->get('id'));
        }

        $originalDisp = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($usuario->getUsuarioDispositivo() as $usuarioDispositivo) {
            $originalDisp->add($usuarioDispositivo->getDispositivos());
        }


        $form = $this->createForm( UsuarioType::class, $usuario, array( 'disabled'=>false ) );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($form->getData());
            $em->flush();
            // redirect back to some edit page
            return $this->redirectToRoute('usuario_edit', ['id' => $usuario->getIdUserHpc()]);

        }

        $pagination = $this->pagination( $paginator, $request, $session, $page );

        return $this->render('usuario/index.twig', [
            'usuarioForm' => $form->createView(),
            'usuario' => $usuario,
            'pagination' => $pagination,
            'page' => $page,
            'edit' =>'S'
        ]);

    }

     /**
     * @Route("/{id}/borrartodos", name="borrar_todos")
     */
    public function borrar_todos( usuario $usuario, Request $request, EntityManagerInterface $em, 
        PaginatorInterface $paginator, SessionInterface $session  ): Response
    {
        //dd($usuario);
        $page = $request->query->get('page');
        if (null === $usuario ) {
//            throw $this->createNotFoundException('No existe el Usuario para el id '.$id);
            throw $this->createNotFoundException('No existe el Usuario para el id '.$request->get('id'));
        }

        $originalDisp = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($usuario->getUsuarioDispositivo() as $usuarioDispositivo) {
            $originalDisp->add($usuarioDispositivo->getDispositivos());
        }


        $form = $this->createForm( UsuarioType::class, $usuario, array( 'disabled'=>false ) );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($form->getData());
            $em->flush();
            // redirect back to some edit page
            return $this->redirectToRoute('usuario_edit', ['id' => $usuario->getIdUserHpc()]);

        }

        $pagination = $this->pagination( $paginator, $request, $session, $page );

        return $this->render('usuario/index.twig', [
            'usuarioForm' => $form->createView(),
            'usuario' => $usuario,
            'pagination' => $pagination,
            'page' => $page,
            'edit' =>'S'
        ]);

    }

    /**
     * @Route("/keycloak", name="usuario_keycloak")
     */
    public function all_users( KeyCloakApiController $keycloak_api ): Response
    {
        $Users=$keycloak_api->getUsers();
        return new Response(json_encode($Users));
    }

    /**
     * @Route("/keycloak/{username}", name="usuario_keycloak_username")
     */
    public function one_user( KeyCloakApiController $keycloak_api, string $username ): Response
    {
        $User=$keycloak_api->getUserByUsername( $username );
        return new Response(json_encode($User));
    }



    function pagination( PaginatorInterface $paginator, Request $request, SessionInterface $session, 
        int $page, $filter=null )
    {
            //$session = new Session();
            //$session->start();

            //$page=$paginator->getCurrentPageNumber();
            //echo "page ".$page."<br>";
            
            // Retrieve the entity manager of Doctrine
            $em = $this->getDoctrine()->getManager();
            
            // Get some repository of data, in our case we have an Appointments entity
            $usuariosRepository = $em->getRepository(usuario::class);
                    
            // Find all the data on the Appointments table, filter your query as you need
            //->where('p.activo != :activo')
            //->setParameter('activo', '1')

            $allUsuariosQuery = $usuariosRepository->createQueryBuilder('p');

            if( $filter )
            {
                $allUsuariosQuery->where("TRIM(UPPER(p.nombre)) LIKE TRIM(UPPER('%".$filter."%'))");
                $allUsuariosQuery->orWhere("TRIM(UPPER(p.apellido)) LIKE TRIM(UPPER('%".$filter."%'))");
                $allUsuariosQuery->orWhere("TRIM(UPPER(p.idUserAd)) LIKE TRIM(UPPER('%".$filter."%'))");
            }

            $allUsuariosQuery->orderBy('p.nombre')->getQuery();
            //echo $allUsuariosQuery->getQuery()->getSQL()."<br>";

            //echo "request ".$request->query->getInt('page', 1)."<br>";
            if( $page >0 )
                $indice=$page;
            else
                $indice=$request->query->getInt('page', 1);

            // Paginate the results of the query
            $pagination = $paginator->paginate(
                // Doctrine Query, not results
                $allUsuariosQuery,
                // Define the page parameter
                $indice,
                // Items per page
                10
            );

            $pagination->setTemplate('usuario/my_pagination.html.twig');

        return $pagination;

    }

}
