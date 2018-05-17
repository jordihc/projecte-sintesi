<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\InfoUsuario;
use BackendBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Finder;


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
        
        return $this->render('user/perfil.html.twig',array("data" => $data,"gestio" => "/perfil/gestiouser"));
    }

    public function postverificationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $usersession = new Session();
        $userID=$usersession->get('userID');
        $message=$request->get('message');
        $file = $request->files->get("image");
        $imgRoute = $this->savefile($file,"uploads/userpostimg");
        $this->setpostdatas($userID,$message,$imgRoute);

        $url = $this->generateUrl('default_perfil');
        return $this->redirect($url);

    }

    public function gestiouserverificationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $usersession = new Session();
        $userID = $usersession->get('userID');
        $file = $request->files->get("icona");
        $email = $request->get("email",null);
        $user = $em->getRepository("BackendBundle:InfoUsuario")->findBy(
                array(
                    "id" => $userID
            ));
        $user=$user[0];
        $IconaRoute = $this->savefile($file,"uploads/usericona");
        $user->setIcona($IconaRoute);
        if($email != null){
        $user->setEmail($email);
        }
        $em->persist($user);
        $em->flush();

        $url = $this->generateUrl('default_perfil');
        return $this->redirect($url);
    }

    public function getpostdatas($userID)
    {
    	$em = $this->getDoctrine()->getManager();
        $userpost = $em->getRepository("BackendBundle:Post")->findBy(
                array(
                    "idUser" => $userID
           ));
        $user = $em->getRepository("BackendBundle:InfoUsuario")->findBy(
                array(
                    "id" => $userID
           ));
        $username = $user[0]->getUser();
        $data = array();
        foreach($userpost as $postvalues){
        	$userpostdatas=array();
        	$userimg = $postvalues->getImgRoute();
            $userimgalt = $postvalues->getImgAlt();
        	$userdatetime = $postvalues->getCreateDate()->format('Y-m-d H:i:s');
        	$usermessages = $postvalues->getmessages();
            $imgrt = "/".$userimg;
        	$userpostdatas=array(
                "img" => $imgrt,
                "createtime" => $userdatetime,
                "messages" => $usermessages,
                "imgalt" => $userimgalt,
                "user" => $username
        	);
        	array_push($data,$userpostdatas);
        }

        return $data;
    }

    public function setpostdatas($userID,$messages,$imgRoute,$imgalt=null)
    { 
    	$createtime=new \DateTime(date('Y-m-d H:i:s'));
    	$userpost = new Post();
        $userpost->setCreateDate($createtime);
        $userpost->setIdUser($userID);
        $userpost->setMessages($messages);
        if ($imgRoute != null){
        $userpost->setImgRoute($imgRoute);
        }
        if ($imgalt != null){
        $userpost->setImgAlt($imgalt);
        }
        $em = $this->getDoctrine()->getManager();

        $em->persist($userpost);
        $em->flush();
    }


    public function savefile($file,$destino)
    {   

        if(!empty($file) && $file != null){
            $ext = $file->guessExtension();
            if($ext == "jpeg"  ||  $ext == "jpg" ||  $ext == "png"){
                     $file_name = md5(uniqid()).'.'.$ext;
                     $file->move($destino, $file_name);
                     $imgRoute = $destino."/".$file_name;
            }}else{
                $imgRoute = "uploads/usericona/avatardefault.png";
            }
        return $imgRoute;
    }

    public function gestiouserAction(Request $request)
    {   
        return $this->render('user/gestio.html.twig');
    }
}

