<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\InfoUsuario;
use BackendBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Session\Session;
use BackendBundle\Entity\InfoCommunity;


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
            $usersession->set('userID', $isset_user[0]->getID());
            return $this->redirect('perfil');
            }
            else{
                $data = array(
                 "status" =>     "error",
                 "code" => 400,
                 "msg" => "password is not correct!"
                 );
            }
        }
        $url = $this->generateUrl('default_login',$data);
        return $this->redirect($url);
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
            return $this->redirect('perfil');

        }
        else{
            $data = array(
                 "status" => "error",
                 "code" => 400,
                 "msg" => "User not created, duplicated!!"
             );
        }

        $url = $this->generateUrl('default_login',$data);
        return $this->redirect($url);
    
    }
    
    public function loginAction(Request $request)

    {   
        $data=$request->get('msg',null);

        return $this->render('user/login.html.twig',array('msg' => $data));
    
    }

    public function searchresultAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $tipo = $request->get("tipo");
        $buscador = $request->get("buscador");
        if($tipo == 0){
            $users = $query = $em->createQuery("SELECT o FROM BackendBundle:InfoUsuario o WHERE o.user =  like :param1 or o.user like :param2 or o.user like :param3");
            $users->setParameter('param1', '%'.$buscador.'%');
            $users->setParameter('param2', '%'.$buscador);
            $users->setParameter('param3', $buscador.'%');
            $result = $users->getResult();
        }else{
            $communties = $query = $em->createQuery("SELECT o FROM BackendBundle:InfoCommunity o WHERE o.name =  like :param1 or o.name like :param2 or o.name like :param3");
            $users->setParameter('param1', '%'.$buscador.'%');
            $users->setParameter('param2', '%'.$buscador);
            $users->setParameter('param3', $buscador.'%');
            $result = $communties->getResult();
        }

        var_dump(count($result));
        die();

        return $this->render('user/login.html.twig');
    }
}