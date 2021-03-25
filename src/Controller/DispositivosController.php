<?php

namespace App\Controller;

use App\Entity\dispositivos;
use App\Form\DispositivosType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dispositivos")
 */
class DispositivosController extends AbstractController
{
    /**
     * @Route("/", name="dispositivos_index", methods={"GET"})
     */
    public function index(): Response
    {
        $dispositivos = $this->getDoctrine()
            ->getRepository(dispositivos::class)
            ->findAll();

        return $this->render('dispositivos/index.html.twig', [
            'dispositivos' => $dispositivos,
        ]);
    }

    /**
     * @Route("/new", name="dispositivos_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dispositivo = new Dispositivos();
        $form = $this->createForm(DispositivosType::class, $dispositivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dispositivo);
            $entityManager->flush();

            return $this->redirectToRoute('dispositivos_index');
        }

        return $this->render('dispositivos/new.html.twig', [
            'dispositivo' => $dispositivo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idDispositivoHpc}", name="dispositivos_show", methods={"GET"})
     */
    public function show(Dispositivos $dispositivo): Response
    {
        return $this->render('dispositivos/show.html.twig', [
            'dispositivo' => $dispositivo,
        ]);
    }

    /**
     * @Route("/{idDispositivoHpc}/edit", name="dispositivos_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dispositivos $dispositivo): Response
    {
        $form = $this->createForm(DispositivosType::class, $dispositivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dispositivos_index');
        }

        return $this->render('dispositivos/edit.html.twig', [
            'dispositivo' => $dispositivo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idDispositivoHpc}", name="dispositivos_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dispositivos $dispositivo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dispositivo->getIdDispositivoHpc(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dispositivo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dispositivos_index');
    }
}
