<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginFormType;
use App\Form\UserType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserController extends AbstractController
{


    /**
     * @param Request $request
     * @Route("/index", name="index")
     * @return Response
     */
    public function indexUser(Request $request): Response
    {
        $session=$request->getSession();

        if($session->get('id')!=null) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($session->get('id'));
            if ($user->getCompteType() == 'admin')
                return $this->redirectToRoute('listUser');
            else
                return $this->redirectToRoute('inscrit');
        }

        return $this->render('user/index.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/inscrit", name="inscrit")
     */
    public function addUser(Request $request){
        $session=$request->getSession();

        if($session->get('id')!=null) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($session->get('id'));
            if ($user->getCompteType() == 'admin')
                return $this->redirectToRoute('listUser');
            else
                return $this->redirectToRoute('inscrit');
        }else
            $user = new User();
        $user->setStatus(0);
        $user->setCompteType('user');
        $form=$this->createForm(UserType::class,$user);
        $form->add("Inscription",SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("login");
        }
        return $this->render("user/inscription.html.twig",['form'=>$form->createView()]);
    }

    /**
     *  @param Request $request
     * @return Response
     * @Route ("/user/list", name="listUser")
     */
    public function listUsers(Request $request,PaginatorInterface $paginator){
        //  var_dump($request->getSession()->get('id'));

        $user =$this->getDoctrine()->getRepository(User::class)->find($request->getSession()->get('id'));
        //var_dump($user);
        $list =$this->getDoctrine()->getRepository(User::class)->findAllusers();

        $list = $paginator->paginate(
        // Doctrine Query, not results
            $list,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
        // $jsonContent= $normalizer->normalize($list,'json',['groups'=>'post:read']);
        return $this->render('user/list.html.twig',['list'=>$list,'type'=>$user->getCompteType()]);
    }


    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route ("user/updateuser", name="updateUser")
     */
    public function updateUser(Request $request){

        $session2=$request->getSession();
        // var_dump($session2->get('id'));
        $id=$session2->get('id');
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class,$user);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('updateUser');
        }
        return  $this->render('/user/userinfo.html.twig',["form"=>$form->createView(),'type'=>$user->getCompteType()]);
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
        return $this->redirectToRoute('listUser');
    }


    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route ("user/login", name="login")
     */
    public function connexion(Request $request){
        $session=$request->getSession();
        if($session->get('id')!=null) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($session->get('id'));
            if ($user->getCompteType() == 'admin')
                return $this->redirectToRoute('listUser');
            else
                return $this->redirectToRoute('inscrit');
        }else{
            $form = $this->createForm(LoginFormType::class);
            $form->add('Connexion',SubmitType::class);
            $form->handleRequest($request);
        }

        if($form->isSubmitted()){

            $user = new User();
            $em = $this->getDoctrine()->getManager();
            $data=($form->getData());
            $user = $em->getRepository(User::class)->findOneByEmail($data['email']);

            // var_dump($$session->get('id'));
            $em = $this->getDoctrine()->getManager();

            if ($user == null){

                return $this->redirectToRoute('login');
            }
            elseif ($user->getPassword() == ($user->getPassword())) {
                $session->set('id',$user->getId());


                if ($user->getCompteType() == 'admin')
                    return $this->redirectToRoute('listUser');
                else
                    return $this->redirectToRoute('updateUser');
            }

        }

        return $this->render('user/login.html.twig',['form'=>$form->createView()]);
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     * @Route ("user/diconnect", name="diconnect")
     */

    public function deconnexion(Request $request){
        $request->getSession()->clear();
        return $this->redirectToRoute('index');
    }

    /**
     * @param Request $request
     * @param $idEvent
     * @Route ("user/addtolist/{idEvent}", name="addtolist")
     */
    public function addToWishlist(Request $request,$idEvent){
        $id=$request->getSession()->get('id');
        $em = $this->getDoctrine()->getManager();
        // $user = $em->getRepository(User::class)->find($id);
        return $this->redirectToRoute('wishlist',['idUser'=>$id,'idEvent'=>$idEvent]);

    }

    /**
     * @Route("/searchuser ", name="searchusers")
     */
    public function searchUser(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $requestString=$request->get('searchValue');
        $users = $repository->findUserBycin($requestString);
        $jsonContent = $Normalizer->normalize($users, 'json',['groups'=>'users']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }

    /**
     * @Route ("/ActiveUser/{crit}",name="active")
     * @param NormalizerInterface $Normalizer
     * @param $crit
     */
    public function filtreuser(NormalizerInterface $Normalizer,$crit)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findUserActive($crit);
        $jsonContent = $Normalizer->normalize($users, 'json',['groups'=>'users']);
        //var_dump($users);
        return new Response(json_encode($jsonContent));

    }

}
