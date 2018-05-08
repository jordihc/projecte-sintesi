<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\InfoUsuario;
use BackendBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    

    public function loginverificationAction(Request $request)
    {   
        $usersession = new Session();
        $user0 = $request->get("user", null);
        $userpassword0 = $request->get("password", null);
        $em = $this->getDoctrine()->getManager();
        $isset_user = $em->getRepository("BackendBundle:InfoUsuario")->findBy(
                array(
                    "user" => $user0
            ));
        if (count($isset_user) == 0) {
            $data = array(
                 "status" => "error",
                 "code" => 400,
                 "msg" => "User does not exist!!"
             );
        }else{
            $pwd = hash('sha256', $userpassword0);
            if($isset_user[0]->getPassword()==$pwd){
                $data = array(
                 "status" => "success",
                 "code" => 200,
                 "msg" => "User log in successfully!"
             );
            $usersession->set('userID', $isset_user[0]->getID());
            return $this->render('user/userpersonal.html.twig',$data);
            }
            else{
                $data = array(
                 "status" => "error",
                 "code" => 400,
                 "msg" => "password is not correct!"
                 );
            }
        }
        return $this->render('user/login.html.twig',$data);
    }

    public function registreverificationAction(Request $request)
    {   
        $usersession = new Session();
        $user0 = $request->get("user", null);
        $userpassword0 = $request->get("password", null);
        $userrepassword0 = $request->get("repassword", null);
        $username0 = $request->get("name", null);
        $useremail0 = $request->get("email", null);
        $useractive0 = $request->get("active", 0);
        $user = new InfoUsuario();
        $user->setUser($user0);
        if ($username0 != null){
        $user->setName($username0);
        }
        $user->setEmail($useremail0);
        $user->setActive($useractive0);

        $pwd = hash('sha256', $userpassword0);
        $user->setPassword($pwd);

        $em = $this->getDoctrine()->getManager();
        $isset_user = $em->getRepository("BackendBundle:InfoUsuario")->findBy(
                array(
                    "user" => $user0
            ));
        if (count($isset_user) == 0) {

            $em->persist($user);
            $em->flush();

            $data["status"] = 'success';
            $data["code"] = 200;
            $data["msg"] = 'New user created !!';
            $get_user = $em->getRepository("BackendBundle:InfoUsuario")->findBy(
                array(
                    "user" => $user0
            ));
            $usersession->set('userID', $get_user[0]->getID());
            return $this->render('user/userpersonal.html.twig',$data);

        }
        else{
            $data = array(
                 "status" => "error",
                 "code" => 400,
                 "msg" => "User not created, duplicated!!"
             );
        }

        return $this->render('user/login.html.twig',$data);
    
    }

    public function loginAction(Request $request)
    {
        return $this->render('user/login.html.twig');
    
    }

    public function registreAction(Request $request)
    {
        return $this->render('user/login.html.twig');
    }

    public function userpostAction(Request $request)
    {
        $user0 = $request->get("user", null);
        $userpassword0 = $request->get("password", null);

    }

    public function testsessAction(Request $request)
    {   
        $usersession = new Session();
        $user=$usersession->get('userID');
        return $this->render('user/testsess.html.twig',array("msg" => $user));

    }
}