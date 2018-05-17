<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\InfoUsuario;
use Symfony\Component\HttpFoundation\Session\Session;

class ComunitatController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('comunitat/index.html.twig');

        
    }
 public function principalAction(Request $request)
    {
        
        return $this->render('comunitat/principal.html.twig',array( "gestio" => "/comunitat/gestio"));

        
    }
    public function postverificationAction(Request $request)
  {     

        $usersession = new Session();
        $user=$usersession->get('userID');
        $titol_post_comunitat = $request->get("titol_post_comunitat", null);
        var_dump($titol_post_comunitat);
        die();
        $userpassword0 = $request->get("img_post_comunitat", null);
        $userrepassword0 = $request->get("titol_post_comunitat", null);
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

        return $this->render('comunitat/principal.html.twig',$data);
    
    }
    public function gestioAction(Request $request)
    {
        
        return $this->render('comunitat/gestio.html.twig');

        
    }
     public function gestioNoticiesAction(Request $request)
    {

        
        return $this->render('comunitat/gestioNotcies.html.twig');

        
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

}  