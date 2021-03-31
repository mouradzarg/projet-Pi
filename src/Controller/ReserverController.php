<?php
 namespace App\Controller;

 use App\Entity\Reserver;
 use App\Repository\ReserverRepository;
 use Doctrine\ORM\EntityManagerInterface;
 use Doctrine\Persistence\ObjectManager;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\Routing\Annotation\Route;

 class ReserverController extends AbstractController {
     /**
      * @var ReserverRepository
      */
     private $repository;

     /**
      * @var ObjectManager
      */
     private $em;

public function __construct(ReserverRepository $repository, EntityManagerInterface $em)
{
  $this->repository=$repository;
}


     /**
 * @Route("Reservationsev",name="Reserver.index")
 * @return Response
 */
public function index():Response
{
  $reservation = $this->repository->findAllVisible_ev();
  return $this->render('Reservationsev/indexReserv.html.twig',[
        'current_menu'=>'reservations',
        'reservations'=>$reservation
    ]);

}




 }