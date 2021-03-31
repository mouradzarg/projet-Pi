<?php
namespace App\Controller;


use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {


    /**
     * @Route("/",name="home")
     * @param EvenementRepository $repository
     * @return Response
     */

    public function index(EvenementRepository $repository):Response
    {
        $events = $repository->findLatest();
        return $this->render('pages/home.html.twig',[ 'events' => $events]
        );


    }
}