<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\InfoUsuario;

class ComunitatController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function defaultAction(Request $request)
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

}