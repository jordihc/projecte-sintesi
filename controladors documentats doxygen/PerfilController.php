<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\InfoUsuario;
use BackendBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Finder;

/**
     * @author Jorid Herranz Cruz
     *@brief Classe que conté totes les accions del controlador perfil
     */
class PerfilController extends Controller
{
    /**
     * @author Jordi Herranz Cruz
     *@brief Agafa la informació de una sessió i compara si l'usuari que entra a la pàgina és el propietari del perfil
     *
      * @return retorna la vista perfil.html.twig i les arrays $data,$url,$usericona,$createpost,$usernoticia
     */
	public function perfilAction(Request $request)
    {	
    	$usersession = new Session();
        if($usersession->has('userID')==False || $usersession->get('userID')==""){
            $url = $this->generateUrl('default_login',array("msg" => "Please log in first!"));
            return $this->redirect($url);
        }
        $usericona = $usersession->get('usericona');
        $userID = $usersession->get('userID');
        $current_userid = $request->get('userid');
        if($current_userid != null){
            $usersession->set('current_userid',$current_userid);
        }else{
            $current_userid = $usersession->get('current_userid');
            if ($current_userid == null){
                $current_userid = $userID;
            }
        }
        if($request->get("myperfil") == 1){
            $current_userid = $userID;
        }
        if($request->get("myperfil") == 1 || $userID == $current_userid){
            $createpost = true;
        }
        else{
            $createpost = false;
        }
        $usernoticia = $this->getusernoticia($current_userid);
        
        $data = $this->getpostdatas($current_userid);
        $url = $this->generateUrl('default_perfil');
        return $this->render('user/perfil.html.twig',array("data" => $data,"gestio" => $url."gestiouser","logout" => $url."logout","usericona" => $usericona,"usernoticia" => $usernoticia ,"createpost" => $createpost,"contacte" => $url."contacte"));
    }
    /**
     * @author Jordi Herranz Cruz
     *@brief funció que agafa la informació dels formularis i la envia a una altra funció perquè els afegeixi a la base *de dades
     *
      * @return retorna una vista que te com a nom de ruta default_login 
     */
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

    public function gestiouserverification1Action(Request $request)
    {
        $usersession = new Session();
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
        $usersession->set('usericona',$this->generateUrl('default_login').$IconaRoute);
        if($email != null){
        $user->setEmail($email);
        }
        $em->persist($user);
        $em->flush();

        $url = $this->generateUrl('default_perfil');
        return $this->redirect($url);
    }

    /**
     * @author Jordi Herranz Cruz
     *@brief funció que agafa la informació d'un formulari de gestió i compara informació amb la base de dades, si tot *es correcte la sobrescriu, si no envia un error
      * @return retorna una vista que te com a nom de ruta default_login 
     */
    public function gestiouserverification2Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $usersession = new Session();
        $userID = $usersession->get('userID');
        $password = $request->get("password");
        $new_password = $request->get("new_password");
        $user = $em->getRepository("BackendBundle:InfoUsuario")->findBy(
                array(
                    "id" => $userID
            ));
        $user=$user[0];
        $userpassword = $user->getPassword();
        $password = hash('sha256',$password);
        $new_password = hash('sha256',$new_password);
        if($userpassword == $password){
            $user->setPassword($new_password);
            $em->persist($user);
            $em->flush();
        }else{
            $info = "password is not correct!";
        }

        $url = $this->generateUrl('default_perfil');
        return $this->redirect($url);
    }
    /**
     * @author Jordi Herranz Cruz
     *@brief funció que agafa  dues consultes de la base de dades i que per a cada registre crea un array amb la *informació d'aquest 
      * @return retorna els arrays $data 
     */
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
    /**
     * @author Jordi Herranz Cruz
     *@brief funció que crea un registre a la base de dades a la taula Post
     */
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

    /**
     * @author Jordi Herranz Cruz
     *@brief funció que el contingut multimedia i el guarda en un directori
      * @return retorna els arrays $data 
     */
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
    /**
     * @author Jordi Herranz Cruz
     *@brief funció que contrasta les dades de l'usuari i si la pàgina actual és el seu perfil, mostra la opció gestió
      * @return retorna  la vista user/gestio.html.twig
     */
    public function gestiouserAction(Request $request)
    {   
        $usersession = new Session();
        $url1 = $this->generateUrl('default_perfil');
        $url2 = $this->generateUrl('default_principal');
        $comunitatid = $usersession->get('current_comunitatid');
        $user = $usersession->get("userID");
        $usericona = $usersession->get('usericona');
        if($comunitatid != null){
            $em = $this->getDoctrine()->getManager();
            $isset_user = $em->getRepository("BackendBundle:InfoCommunity")->findBy(
                    array(
                        "id" => $comunitatid
                ));
            $admin = $isset_user[0]->getIdAdmin();
            if ($user == $admin){
                $data = array("gestio" => $url1."gestiouser","logout" => $url1."logout","gestiocomunitat" => $url2."gestiocomunitat","usericona" => $usericona,"contacte" => $url1."contacte");}
            else{
                $data = array("gestio" => $url1."gestiouser","logout" => $url1."logout","usericona" => $usericona,"contacte" => $url1."contacte");  
            }
        }else{
            $data = array("gestio" => $url1."gestiouser","logout" => $url1."logout","usericona" => $usericona,"contacte" => $url1."contacte");  
        }
        
        
        return $this->render('user/gestio.html.twig',$data);
    }
    /**
     * @author Jordi Herranz Cruz
     *@brief funció que genera una consulta que aconsegueix les ultimes quatre noticies de les comunitats que segueix *l'usuari
      * @return array $results  
     */
    public function getusernoticia($userid)
    {

        $em = $this->getDoctrine()->getManager();
        $sql="SELECT p.idCommunity,p.id,p.createDate,p.title,p.imgRoute,p.imgAlt,p.message FROM BackendBundle:Noticia p inner join BackendBundle:Follow q where q.idUser = :userid and q.idCommunity = p.idCommunity ORDER BY p.createDate DESC";
        $users = $em->createQuery($sql);
        $users->setParameter('userid', $userid);
        $result = $users->getResult();
        $results = array();
        foreach($result as $noticia){
            $noticia['createDate'] = $noticia['createDate']->format('Y-m-d H:i:s');
            array_push($results,$noticia);
        }
        $results = array_slice($results,0,4);
        return $results;  

    }
}   

