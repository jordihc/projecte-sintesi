<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\InfoUsuario;
use BackendBundle\Entity\InfoCommunity;
use BackendBundle\Entity\Noticia;
use BackendBundle\Entity\Follow;
use Symfony\Component\HttpFoundation\Session\Session;


class ComunitatController extends Controller
{

    public function principalAction(Request $request)
    {   
        $usersession = new Session();
        $usericona = $usersession->get('usericona');
        $user=$usersession->get('userID',-1);
        $comunitatid = $request->get("comunitatid",null);
        if($comunitatid != null){
            $usersession->set('current_comunitatid',$comunitatid);
        }else{
            $comunitatid = $usersession->get('current_comunitatid');
        }
        $em = $this->getDoctrine()->getManager();
        $isfollowed = $em->getRepository("BackendBundle:Follow")->findBy(array( "idUser" => $user , "idCommunity" =>  $comunitatid));
        if(count($isfollowed) == 1){
            $isfollowed = true;
        }else{
            $isfollowed = false;
        }
        if($comunitatid != null ){
            $isset_user = $em->getRepository("BackendBundle:InfoCommunity")->findBy(
                    array(
                        "id" => $comunitatid
                ));
            $admin = $isset_user[0]->getIdAdmin();
            if ($user == $admin){
                $isadmin = "S";
            }else{
                $isadmin = "N";
            }
            $datacom = $this->getnoticia($comunitatid);
            $urlfollow = $this->generateUrl('default_follow');
            $data =  array(
                 "data" => $datacom,
                 "gestio" => "/comunitat/gestio",
                 "isadmin" => $isadmin,
                 "comunitatid" => $comunitatid,
                 "usericona" => $usericona,
                 "follow" => $urlfollow
             );
        }else{
            $data =  array(
                 "gestio" => "/comunitat/gestio",
                 "comunitatid" => $comunitatid,
                 "usericona" => $usericona,
                 "follow" => true
             );
        }
        $usersession->set('datanoticies',$data);
        return $this->render('comunitat/principal.html.twig',$data);
    }
    
    public function followAction(Request $request)
    {   

        $usersession = new Session();
        $userID = $usersession->get('userID');
        $data = $usersession->get('datanoticies');
        $comunitatid = $data['comunitatid'];
        $follow = new Follow();
        $em = $this->getDoctrine()->getManager();
        $follow->setIdUser($userID);
        $follow->setIdCommunity($comunitatid);
        $createtime=new \DateTime(date('Y-m-d H:i:s'));
        $follow->setFollowdate($createtime);
        $em->persist($follow);
        $em->flush();
        $data['follow'] = true;

        $url = $this->generateUrl('default_principal',$data);
        return $this->redirect($url);

    }

    public function noticiaverificationAction(Request $request)
  {     

        $usersession = new Session();
        $usericona = $usersession->get('usericona');
        $comunitatID = $request->get("id_comunitat");
        $messages = $request->get("message_noticia");
        $title = $request->get("titulo_noticia");
        $file = $request->files->get("img_noticia");
        $imgruta = $this->savefile2($file,"uploads/noticiaimg");
        $this->setnoticia($comunitatID,$messages,$title,$imgruta);

        $data =  array(
                 "gestio" => "/comunitat/gestio",
                 "isadmin" => "S",
                 "usericona" => $usericona
             );
        $url = $this->generateUrl('default_principal',$data);
        return $this->redirect($url);
    }


    public function getnoticia($communityID)
    {
        $em = $this->getDoctrine()->getManager();
        $noticia = $em->getRepository("BackendBundle:Noticia")->findBy(
                array(
                    "idCommunity" => $communityID
           ));
        $co = $em->getRepository("BackendBundle:InfoCommunity")->findBy(
                array(
 
                    "id" => $communityID
           ));
        $co_name = $co[0]->getName();
        $data = array();
        foreach($noticia as $noticia_values){
            $noticiadata=array();
            $noticiaid = $noticia_values->getId();
            $noticiatitle = $noticia_values->getTitle();
            $noticiaimg = $noticia_values->getImgRoute();
            $noticiadate = $noticia_values->getCreateDate()->format('Y-m-d H:i:s');
            $noticiamessage = $noticia_values->getMessage();
            $noticiaruta = "/".$noticiaimg;
            $noticiadata=array(
                "id" =>  $noticiaid,
                "title" =>  $noticiatitle,
                "img" => $noticiaruta,
                "date" => $noticiadate,
                "message" => $noticiamessage,
                "coname"    => $co_name
            );
            array_push($data,$noticiadata);
        }

        return $data;
    }

    public function setnoticia($comunitatID,$messages,$title,$imgRoute=null,$imgalt=null)
    { 
        $createtime=new \DateTime(date('Y-m-d H:i:s'));
        $userpost = new Noticia();
        $userpost->setCreateDate($createtime);
        $userpost->setIdCommunity($comunitatID);
        $userpost->setTitle($title);
        $userpost->setMessage($messages);
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



    public function gestioAction(Request $request)
    {
        
        return $this->render('comunitat/gestio.html.twig');

        
    }


    public function comunitatverification(Request $request)
    {
        $name = $request->get('name');
        $description = $request->get('description');
        $avatar = $request->files->get('avatar');
        $imgtitle = $request->get('imgtitle');
        $avatar = $this->savefile2($avatar,"uploads/community");
        $em = $this->getDoctrine()->getManager();
        $usersession = new Session();
        $userID = $usersession->get('current_comunitatID');
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
    }


    public function savefile2($file,$destino)
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


}  