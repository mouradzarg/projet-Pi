<?php

namespace App\Controller\Admin;

namespace App\Controller\Admin;
use App\Entity\Evenement;
use App\Form\EventType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminEventController extends AbstractController
{

    /**
     * @var EvenementRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EvenementRepository  $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin",name="admin.event.adminloj")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $events = $this->repository->findAll();
        return $this->render('admin/adminloj.html.twig', compact('events'));
    }


    /**
     * @Route("/admin/create", name="admin.event.new")
     */
    public function new(Request $request,FlashyNotifier $flashy)
    {
        $eventn = new Evenement();
        $form = $this->createForm(EventType::class, $eventn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($eventn);
            $this->em->flush();
            $flashy->success('Evenement Crée !');
            return $this->redirectToRoute('admin.event.adminloj');
        }

        return $this->render('admin/new.html.twig', [
            'event' => $eventn,
            'form'     => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}",name="admin.event.edit")
     * @param Evenement $evenement
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function edit(Evenement $evenement, Request $request,FlashyNotifier $flashy){

        $form =  $this->createForm(EventType::class,$evenement);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $this->em->flush();
            $flashy->success('Evenement Modifié!');
            return $this->redirectToRoute('admin.event.adminloj');


        }
        return $this->render('admin/edit.html.twig', [
            'event' => $evenement ,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/admin1/{id}", name="admin.event.delete", methods="DELETE")
     * @param Evenement $evenement
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Evenement $evenement, Request $request,FlashyNotifier $flashy) {
        if ($this->isCsrfTokenValid('delete' . $evenement->getId(), $request->get('_token'))) {
            $this->em->remove($evenement);
            $this->em->flush();
            $flashy->success('Evenement Supprimé!');

        }
        return $this->redirectToRoute('admin.event.adminloj');
    }

}
