<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\InfoUsuario;
use BackendBundle\Entity\Post;
use BackendBundle\Entity\Userchat;
use Symfony\Component\HttpFoundation\Session\Session;

class PerfilController extends Controller
{
	public function perfilAction(Request $request)
    {	
    	$usersession = new Session();
        if($usersession->has('userID')==False || $usersession->get('userID')==""){
            $url = $this->generateUrl('default_login',array("msg" => "Please log in first!"));
            return $this->redirect($url);
        }
        $userID=$usersession->get('userID');
        $data = $this->getpostdatas($userID);

        return $this->render('user/perfil.html.twig',array("data" => $data));
    }


    public function getpostdatas($userID)
    {
    	$em = $this->getDoctrine()->getManager();
        $user_post = $em->getRepository("BackendBundle:Post")->findBy(
                array(
                    "idUser" => $userID
           ));
        $data = array();
        foreach($user_post as $postvalues){
        	$userpostdatas=array();
        	$uservideo = $postvalues->getVideoRoute();
        	$userimg = $postvalues->getImgRoute();
        	$userdatetime = $postvalues->getCreateDate()->format('Y-m-d H:i:s');
        	$usermissage = $postvalues->getMissage();
        	$userpostdatas=array(
        		"video" => $uservideo,
                "img" => $userimg,
                "createtime" => $userdatetime,
                "missage" => $usermissage
        	);
        	array_push($data,$userpostdatas);
        }

        return $data;
    }

    public function setpostdatas($userID,$missage,$imgRoute = null,$videoRoute = null)
    {
    	$createtime=date('Y-m-d H:i:s');
    	$user_post = new Post();
        $user_post->setIdUser($userID);
        $user_post->setMissage($missage);
        if ($imgRoute != null){
        $user_post->setImgRoute($imgRoute);
        }
        if ($videoRoute != null){
        $user->setVideoRoute($videoRoute);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($user_post);
        $em->flush();
    }


    public function userchatAction()
    {
    	$usersession = new Session();
        if($usersession->has('userID')==False || $usersession->get('userID')==""){
        	return $this->render('user/login.html.twig',array("msg" => "Please log in first!"));
        }
        $userID=$usersession->get('userID');
        $chatdata = $this->getchat(8,9);
        $setchatdata = $this->setchat(8,9,"hola!");
        die();
        return false;

    }
    public function getchat($user_e,$user_r)
    {
    	$em = $this->getDoctrine()->getManager();
    	$query = $em->createQuery('SELECT u FROM BackendBundle:Userchat u WHERE (u.idUserE = :user_e AND u.idUserR = :user_r) or (u.idUserE = :user_r AND u.idUserR = :user_e) ORDER BY u.createDate DESC');
		$query->setParameters(['user_e'=> $user_e,'user_r'=> $user_r]);
		$query->setMaxResults(5);
		$arrayuserchat = $query->getResult();
		if (count($arrayuserchat) == 0){
			return false;
		}
		else{
		$data = array();
		foreach(array_reverse($arrayuserchat) as $userchat){
        	$userchatdata=array(
        		"user_e" => $userchat->getIdUserE()->getID(),
        		"user_r" => $userchat->getIdUserR()->getID(),
        		"missage" => $userchat->getMissage(),
                "createtime" => $userchat->getCreateDate()->format('Y-m-d H:i:s'),
        	);
        	array_push($data,$userchatdata);
        }
        return $data;
    	}
    }

    public function setchat($user_e,$user_r,$missage)
    {   
        var_dump("ssss");
        $em = $this->getDoctrine()->getManager();

        $usere = $em->getRepository("BackendBundle:InfoUsuario")->findBy(
                array(
                    "id" => 8
            ));
        var_dump($usere);
        die();
        $username=$usere->getName();
           
        die();
        $userr = $em->getRepository("BackendBundle:InfoUsuario")->findBy(
                array(
                    "id" => $user_r
            ));
    	$createtime=date('Y-m-d H:i:s');
    	// $user_chat = new Userchat();
     //    $user_chat->setIdUserE($usere,$user_e);
     //    $user_chat->setIdUserR($userr,$user_r);
     //    $user_chat->setMissage($missage);
     //    $user_chat->setCreateDate($createtime);
     //    $em->persist($user_chat);
     //    $em->flush();
    	
    }
     public function gestioAction(Request $request)
    { 
        return $this->render('user/gestio.html.twig');
    
    }
}