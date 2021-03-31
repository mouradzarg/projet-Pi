<?php
namespace App\Controller;
use App\Entity\Reserver;
use App\Form\ReserverType;
use App\Repository\ReserverRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class ClientReservation extends AbstractController {

    /**
     * @var ReserverRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ReserverRepository $repository,EntityManagerInterface $em )
    {
        $this->repository = $repository;
        $this->em=$em;

    }

    /**
     * @Route("/client",name="client.res.clientreserv")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $reservations= $this->repository->findAll();
        return $this->render('client/clientreserv.html.twig', compact('reservations'));
    }

    /**
     * @Route("/client/create", name="client.res.new")
     */
    public function new(Request $request)
    {
        $reservn = new Reserver();
        $form = $this->createForm(ReserverType::class, $reservn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($reservn);
            $this->em->flush();
            $this->addFlash('success', 'Evenement Créé Avec Succés !');
            return $this->redirectToRoute('client.res.clientreserv');
        }

        return $this->render('client/newclient.html.twig', [
            'reservation' => $reservn,
            'form'     => $form->createView()
        ]);
    }


    /**
     * @Route("/client/{id}",name="client.res.edit")
     * @param Reserver $reservation
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function edit(Reserver $reservation, Request $request){

        $form =  $this->createForm(ReserverType::class,$reservation);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $this->em->flush();
            $this->addFlash('success', 'Evenement Modifié Avec Succés !');
            return $this->redirectToRoute('client.res.clientreserv');

        }
        return $this->render('client/editclient.html.twig', [
            'reservation' => $reservation,
            'form'     => $form->createView()
        ]);
    }

    /**
     * @Route("/client/{id}", name="client.res.delete", methods="DELETE")
     * @param Reserver $reservation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Reserver $reservation, Request $request) {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->get('_token'))) {
            $this->em->remove($reservation);
            $this->em->flush();
            $this->addFlash('success', 'Evenement Supprimé Avec Succés !');
        }
        return $this->redirectToRoute('client.res.clientreserv');
    }

}