<?php

namespace App\Controller;

use App\Entity\Aide;
use App\Form\AideType;
use App\Repository\AideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/aide")
 */
class AideController extends AbstractController
{
    /**
     * @Route("/", name="aide_index", methods={"GET"})
     */
    public function index(AideRepository $aideRepository): Response
    {
        return $this->render('aide/indexTempo.html.twig', [
            'aides' => $aideRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="
     *
     *
     *
     *
     *     ", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $aide = new Aide();
        $form = $this->createForm(AideType::class, $aide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($aide);
            $entityManager->flush();

            return $this->redirectToRoute('aide_index');
        }

        return $this->render('aide/new.html.twig', [
            'aide' => $aide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="aide_show", methods={"GET"})
     */
    public function show(Aide $aide): Response
    {
        return $this->render('aide/show.html.twig', [
            'aide' => $aide,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="aide_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Aide $aide): Response
    {
        $form = $this->createForm(AideType::class, $aide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('aide_index');
        }

        return $this->render('aide/edit.html.twig', [
            'aide' => $aide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="aide_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Aide $aide): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aide->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($aide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('aide_index');
    }
}
