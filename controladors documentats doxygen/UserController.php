<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\InfoUsuario;
use BackendBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Session\Session;
use BackendBundle\Entity\InfoCommunity;

/**
     * @author Jorid Herranz Cruz
     *@brief Classe que conté totes les accions del controlador user
     */
class UserController extends Controller
{
    /**
     * @author Jordi Herranz Cruz
     *@brief funció que agafa la informació d'un formulari i verifica si les dades són correctes a la base de dades ,
     *si no retorna missatges d'error, si es correcta crea una sessió i la omple de informació 
      * @return retorna una vista que te com a nom de ruta default_login 
     */
    public function loginverificationAction(Request $request)
    {   /**
     * @param $usersession nom de la sessió que crea 
     */
        $usersession = new Session();
        /**
     * @param $user0  agafa la informació del camp del formulari que té com a nom user 
     */
        $user0 = $request->get("user", null);
        /**
     * @param $user0  agafa la informació del camp del formulari que té com a password 
     */
        $userpassword0 = $request->get("password", null);
        /**
     * @param $em variable que enmagatzema la classe que es comunica amb el doctrine 
     */
        $em = $this->getDoctrine()->getManager();
        /**
     * @param $isset_user variable que enmagatzema els resultats de una comanda a la Bd nom de taula InfoUsuario  que tinguin com a camp user el parametre $user0
     */
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
            /**
     * @param $pwd codifica $userpassword0
     */
            $pwd = hash('sha256', $userpassword0);
            if($isset_user[0]->getPassword()==$pwd){
            $usersession->set('userID', $isset_user[0]->getID());
            /**
     * @param $url genera una ruta
     */
            $url = $this->generateUrl('default_login');
            $usersession->set('usericona',$url.$isset_user[0]->getIcona());
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
    /**
     * @author Jordi Herranz Cruz
     *@brief Classe que agafa la informació del formulari de registre i comprova que el nom d'usuari no existeix 
      * @return fa una redirecció a la vista d'accés 
     */
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

            $data["msg"] = 'New user created !!';
            $get_user = $em->getRepository("BackendBundle:InfoUsuario")->findBy(
                array(
                    "user" => $user0
            ));
            $usersession->set('userID', $get_user[0]->getID());
            $url = $this->generateUrl('default_login');
            $usersession->set('usericona',$url.'uploads/usericona/avatardefault.png');
            return $this->redirect('perfil');

        }
        else{
            $data = array(
                 "msg" => "User not created, duplicated!!"
             );
        }

        $url = $this->generateUrl('default_login',$data);
        return $this->redirect($url);
    
    }
    /**
     * @author Jordi Herranz Cruz
     *@brief funció que agafa un array i l'envia a una vista
      * @return retorna la vista user/login.html.twig
     */
    public function loginAction(Request $request)

    {   /**
     * @param $data conté la informació de la variables msg 
     */
        $data=$request->get('msg',null);

        return $this->render('user/login.html.twig',array('msg' => $data));
    
    }
/**
     * @author Jordi Herranz Cruz
     *@brief funció que elimina els valors de la sessió i redirigeix a una vista 
      * @return retorna la vista que té com a nom de ruta default_login 
     */
    public function logoutAction(Request $request)
    {
        $usersession = new Session();
        $usersession->remove('userID');
        $usersession->remove('usericona');
        $usersession->remove('current_comunitatid');
        $usersession->remove('current_userid');
        $url = $this->generateUrl('default_login',array('msg' => 'log out sucessfully!'));

        return $this->redirect($url);
    }
    /**
     * @author Jordi Herranz Cruz
     *@brief funció que busca a la base de dades registres amb la caden que s'ha escrit a la taula dels usuaris o la de *les comunitats
      * @return retorna la vista resultat.html.twig
     */
    public function searchresultAction(Request $request)
    {   
        $usersession = new Session();
        $em = $this->getDoctrine()->getManager();
        $tipo = $request->get("tipo");
        $buscador = $request->get("buscador");
        if($tipo == 0){
            $users = $em->createQuery("SELECT o FROM BackendBundle:InfoUsuario o WHERE o.user like :param1 or o.user like :param2 or o.user like :param3");
            $users->setParameter('param1', '%'.$buscador.'%');
            $users->setParameter('param2', '%'.$buscador);
            $users->setParameter('param3', $buscador.'%');
            $result = $users->getResult();
        }else{
            $communties = $em->createQuery("SELECT o FROM BackendBundle:InfoCommunity o WHERE o.name like :param1 or o.name like :param2 or o.name like :param3");
            $communties->setParameter('param1', '%'.$buscador.'%');
            $communties->setParameter('param2', '%'.$buscador);
            $communties->setParameter('param3', $buscador.'%');
            $result = $communties->getResult();
        }
        $arraydata = $this->generaresult($result,$tipo);
        $usericona = $usersession->get('usericona');

        $url = $this->generateUrl('default_perfil');
        if ($tipo==0){
             $data= array("data" => $arraydata,"gestio" => $url."gestiouser","comprova"=>true,"usericona" => $usericona,"logout" =>  $url."logout","contacte" => $url."contacte");
        }
        else{$data= array("data" => $arraydata,"gestio" => $url."gestiouser","comprova"=>false,"usericona" => $usericona,"logout" =>  $url."logout","contacte" => $url."contacte");}
        
      
        

        return $this->render('perfil/resultat.html.twig',$data);


    }

    /**
     * @author Jordi Herranz Cruz
     *@brief funció que guarda la informació del cercador  
      * @return $data $arraydata
     */
        public function generaresult($object_array,$tip)
    {
        $data = array();
        foreach($object_array as $object){
            $objectdata = array();
            if($tip == 0){
                $url = $this->generateUrl('default_perfil');
                $user = $object->getUser();
                $usericona = $object->getIcona();
                $usericona = $this->generateUrl('default_login').$usericona;
                $user_id = $object->getId();
                $objectdata = array(
                    "user" => $user,
                    "usericona" => $usericona,
                    "id" => $user_id,
                    "url" => $url
                );
            }
            else{
                $url = $this->generateUrl('default_principal');
                $name = $object->getName();
                $id_admin = $object->getIdAdmin();
                $descrip = $object->getDescription();
                $createdate = $object->getCreateDate()->format('Y-m-d H:i:s');
                $imgavatar = $object->getImgAvatar();
                $imgavatar = $this->generateUrl('default_login').$imgavatar;
                $id_co = $object->getId();
                $objectdata = array(
                    "name" => $name,
                    "admin" => $id_admin,
                    "descrip" => $descrip,
                    "createdate" => $createdate,
                    "imgavatar" => $imgavatar,
                    "id" => $id_co,
                    "url" => $url
                );
            }
            array_push($data,$objectdata);
        }
        if(count($data) == 0){
            return false;
        }
        return $data;

    }
    /**
     * @author Jordi Herranz Cruz
     *@brief funció que fa d'enllaç amb la vista contacte
      * @return retorna la vista contacte.html.twig amb l'array data
     */
    public function contacteAction(Request $request)
    {  
        $usersession = new Session();
        $usericona = $usersession->get('usericona');
        $url = $this->generateUrl('default_perfil');
        $data = array(
            "gestio" => $url."gestiouser",
            "usericona" => $usericona,
            "logout" =>  $url."logout",
            "contacte" => $url."contacte"
        );
        return $this->render('perfil/contacte.html.twig',$data);
    }
}
