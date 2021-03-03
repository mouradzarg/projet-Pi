<?php

namespace App\Controller;

use App\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     */
    public function index(): Response
    {
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }


    /**
     *  @param Request $request
     * @return Response
     * @Route ("/event/list", name="listEvent")
     */
    public function listEvent(Request $request){

        $list =$this->getDoctrine()->getRepository(Evenement::class)->findAll();
        return $this->render('evenement/evenement.html.twig',['list'=>$list,'type'=>'user']);
    }


}
