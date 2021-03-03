<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Wishlist;
use App\Repository\WishlistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

class WishlistController extends AbstractController
{
    /**
     * @Route("/wishlist", name="wishlist")
     */
    public function index(): Response
    {
        return $this->render('wishlist/index.html.twig', [
            'controller_name' => 'WishlistController',
        ]);
    }

    /**
     *  @param Request $request
     * @return Response
     * @Route ("/wishlist", name="wishlist")
     */
    public function listWish(Request $request){

        $list =$this->getDoctrine()->getRepository(Wishlist::class)->findAll();
        return $this->render('wishlist/wishlist.html.twig',['list'=>$list,'type'=>'user']);
    }

    /**
     * @param $idUser
     * @param $idEvent
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/wishlist/addEvent/{idUser}/{idEvent}", name="wishlist")
     */
    public function addEvent(Request $request,$idUser,$idEvent){
        $idUser=$request->getSession()->get('id');
        $wishlist = new Wishlist();
        $wishlist->setIdUser($idUser);
        $wishlist->setIdEvent($idEvent);
        $em=$this->getDoctrine()->getManager();
        $em->persist($wishlist);
        $em->flush();
        return $this->redirectToRoute("wishlistevent");
    }

    /**
     * @Route ("wishlist/event/", name="wishlistevent")
     * @param Request $request
     * @return Response
     */
    public function wishlist(Request $request){
        $idUser=$request->getSession()->get('id');
        $e=new Evenement();
        $wishlist=$this->getDoctrine()->getRepository(Wishlist::class)->findOneByuser($idUser);
       // var_dump($wishlist[0]);
        $events=new ArrayCollection();

        foreach ($wishlist as $event ){
            $e=$this->getDoctrine()->getRepository(Evenement::class)->find($event->getIdEvent());
            $events->add($e);
        }
        //var_dump($events);
        return $this->render("user/wishlist.html.twig",['list'=>$events,'type'=>'user']);
    }

    /**
     * @param Request $request
     * @param $idEvent
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("wishlist/remove/{idEvent}", name="removeWish")
     */
    public function DeleteWishlist(Request $request, $idEvent){
       /* $idUser=$request->getSession()->get('id');
        $em=$this->getDoctrine()->getManager();
        $query=$em->createQuery('DELETE wish.id from App\Entity\Wishlist wish where idUSer= :id and idEvent= :idE ')->setParameters(['id'=>$idUser,'idE'=>$idEvent])->execute();

        /*$this->getDoctrine()->getRepository(Wishlist::class)->removeEventFromList($idUser,$idEvent);*/
        return $this->redirectToRoute('wishlistevent');

    }







}
