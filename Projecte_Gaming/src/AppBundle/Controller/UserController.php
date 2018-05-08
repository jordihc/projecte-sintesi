<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\InfoUsuario;

class UserController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function loginverificationAction(Request $request)
    {
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
            if($isset_user[0]->getPassword()==$userpassword0){
                $data = array(
                 "status" => "success",
                 "code" => 200,
                 "msg" => "User log in successfully!"
             );
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

}