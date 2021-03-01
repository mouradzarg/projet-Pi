<?php

namespace App\Controller;

use App\Entity\User;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("user/index", name="index")
     */
    public function index(): Response
    {
        return $this->render('index/index.html.twig');
    }

    /**
     * @return Response
     * @Route ("/user/list", name="listUser")
     */
    public function listUsers(){
        $list =[]; //$this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/list.html.twig',['list'=>$list]);
    }

    /**
     * @param $id
     * @return Response
     * @Route ("/user/info",name="infoUser")
     */
    public  function userData($id){
        $user=$this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render('user/info.html.twig',['data'=>$user]);
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     * @Route("/user/inscrit", name="inscrit")
     */
    public function addUser(Request $request){
        $user = new User();
        //$form=$this->createForm(UserType::class,$user)->add("inscrit",['label'=>'Inscription']);
       // $form->handleRequest($request);
        //if ($form->isSubmitted()){
          //  $em=$this->getDoctrine()->getManager();
           // $em->persist($user);
            //$em->flush();

            //return $this->redirectToRoute("/user/inscrit");
      //  }
        return $this->render("user/inscription.html.twig");
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     * @Route ("user/updateuser/{id}", name="updateUser")
     */
    public function updateUser(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class,$user);
        $form->add('Modifier',UserType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('user');
        }
        return  $this->render('/user/list.html.twig',["f"=>$form->createView()]);
    }


    /**
     * @param $id
     * @return RedirectResponse
     * @Route ("/user/changeStatus/{id}/{action}", name="changeStatus")
     */
    public function changeStatus($id,$action){
        $user = new User();
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($id);
        $user->setStatus($action);
        $em->flush();
        return $this->redirectToRoute('user/list.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("user/login", name="login")
     */
    public function Login(Request $request){
        return $this->render('user/login.html.twig');
    }




}
