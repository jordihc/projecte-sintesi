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


/**
     * @author: Jordi Herranz Cruz
     *@brief: Classe que conté totes les accions del controllador Comunitat i que s'executen quan entren en un aruta especifica 
     *
        *
     */
class ComunitatController extends Controller
{
    /**
     * @author: Jordi Herranz Cruz 
     *@brief: funció que 
     *
     *
     */
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
            $imgtitle = $this->generateUrl('default_login').$isset_user[0]->getImgTitle();
            if ($user == $admin){
                $isadmin = true;
            }else{
                $isadmin = false;
            }
            $datacom = $this->getnoticia($comunitatid);
            $urlfollow = $this->generateUrl('default_follow');
            $urluser = $this->generateUrl('default_perfil');
            $urlcomunitat = $this->generateUrl('default_principal');
            if ($isadmin == true){
                
            $data =  array(
                "imgtitle" => $imgtitle,
                 "data" => $datacom,
                 "gestio" => $urluser."gestiouser",
                 "isadmin" => $isadmin,
                 "comunitatid" => $comunitatid,
                 "usericona" => $usericona,
                 "follow" => $urlfollow,
                 "logout" => $urlcomunitat."logout",
                 "gestiocomunitat" => $urlcomunitat."gestiocomunitat",
                 "contacte" => $url."contacte"
             );
            }else{
            $data =  array(
                "imgtitle" => $imgtitle,
                 "data" => $datacom,
                 "gestio" => $urluser."gestiouser",
                 "isadmin" => $isadmin,
                 "comunitatid" => $comunitatid,
                 "usericona" => $usericona,
                 "follow" => $urlfollow,
                 "logout" => $urlcomunitat."logout",
                 "contacte" => $url."contacte"
             );
            }
        }else{
            $data =  array(
                 "gestio" => $urluser."gestiouser",
                 "comunitatid" => $comunitatid,
                 "usericona" => $usericona,
                 "follow" => true,
                 "logout" => $urlcomunitat."logout"
             );
        }
        $usersession->set('datanoticies',$data);
        return $this->render('comunitat/principal.html.twig',$data);
    }
    /**
     * @author Jordi Herranz Cruz
     *@brief funció que genera un registre a la base de dades a la taula Follow amb la informació de la comunitat i   *l'usuari
      * @return redirecciona a la vista que te com a nom de ruta default principal
     */
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
    /**
     * @author Jordi Herranz Cruz
     *@brief funció que el contingut multimedia i el guarda en un directori
      * @return retorna els arrays $data 
     */
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
        $urluser = $this->generateUrl('default_perfil');
        $urlcomunitat = $this->generateUrl('default_principal');
        $data =  array(
                 "gestio" => $urluser."gestiouser",
                 "isadmin" => "S",
                 "usericona" => $usericona,
                 "logout" => $urlcomunitat."logout",
                 "contacte" => $urluser."contacte"
             );
        $url = $this->generateUrl('default_principal',$data);
        return $this->redirect($url);
    }

     /**
     * @author Jordi Herranz Cruz
     *@brief funció que agafa la informació de les noticies de la base de dades que tinguin l'id actual de la comunitat *i per cada registre crea un array 
      * @return array $data
     */
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
                "id" => $noticiaid,
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
     /**
     * @author Jordi Herranz Cruz
     *@brief funció que crea un registre a la taula Noticia de la base de dades
      * @return null
     */
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


    /**
     * @author Jordi Herranz Cruz
     *@brief funció que carrega la vista comunitat/gestio.html.twig i agafa la informació de la sessió
      * @return retorna la vista comunitat/gestio.html.twig  i l'array $data
     */
    public function gestiocomunitatAction(Request $request)
    {
        $usersession = new Session();
        $usericona = $usersession->get('usericona');
        $urluser = $this->generateUrl('default_perfil');
        $urlcomunitat = $this->generateUrl('default_principal');
        $data =  array(
                 "gestio" => $urluser."gestiouser",
                 "usericona" => $usericona,
                 "logout" => $urlcomunitat."logout",
                 "gestiocomunitat" => $urlcomunitat."gestiocomunitat",
                 "contacte" => $urluser."contacte"
             );
        return $this->render('comunitat/gestio.html.twig',$data);

        
    }

    /**
     * @author Jordi Herranz Cruz
     *@brief funció que agafar la informació d'un formulari i que modifica un registre de la base de dades que te com *id el mateix que la comunitat actual
      * @return retorna una redirecció a la vista que té com a nom de ruta default_principal
     */
    public function comunitatverificationAction(Request $request)
    {
        $name = $request->get('name',null);
        $description = $request->get('description',null);
        $avatar = $request->files->get('avatar',null);
        $imgtitle = $request->files->get('imgtitle',null);
        if ($avatar != null){
        $avatar = $this->savefile2($avatar,"uploads/community");
        }
        if ($imgtitle != null){
        $imgtitle = $this->savefile2($imgtitle,"uploads/community/title");
        }
        $em = $this->getDoctrine()->getManager();
        $usersession = new Session();
        $comunitatid = $usersession->get('current_comunitatid');
        $comunitat = $em->getRepository("BackendBundle:InfoCommunity")->findBy(
                array(
                    "id" => $comunitatid
            ));
        $comunitat = $comunitat[0];
        if($name != null){
            $comunitat->setName($name);
        }
        if($description != null){
            $comunitat->setDescription($description);
        }
        if($avatar != null){
            $comunitat->setImgAvatar($avatar);
        }
        if($imgtitle != null){
            $comunitat->setImgTitle($imgtitle);
        }

        $em->persist($comunitat);
        $em->flush();
        
        $url = $this->generateUrl('default_principal');
        return $this->redirect($url);
    }

    /**
     * @author Jordi Herranz Cruz
     *@brief funció que el contingut multimedia i el guarda en un directori
      * @return retorna els arrays $imgRoute 
     */
    public function savefile2($file,$destino)
    {   

        if(!empty($file) && $file != null){
            $ext = $file->guessExtension();
            if($ext == "jpeg"  ||  $ext == "jpg" ||  $ext == "png"){
                     $file_name = md5(uniqid()).'.'.$ext;
                     $file->move($destino, $file_name);
                     $imgRoute = $destino."/".$file_name;
            }}else{
                $imgRoute = "uploads/community/avatardefault.png";
            }
        return $imgRoute;
    }


}  