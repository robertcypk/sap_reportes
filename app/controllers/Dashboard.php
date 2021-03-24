<?php
namespace Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Dashboard
{
    
    public function index(\Silex\Application $app, Request $request)
    {
        $reports = $app['orm.em']->getRepository('Entity\Reports')->findBy(array('lang'=>1),array('date' => 'DESC'));
        $s = $app['session']->get('user');
        print_r($s);
        return $app['twig']->render('dashboard.html.twig', array('list'=>$reports, 's'=> $s));
    }

    public function listpr(\Silex\Application $app, Request $request){
        $reports = $app['orm.em']->getRepository('Entity\Reports')->findBy(array('lang'=>2),array('date' => 'DESC'));
        return $app['twig']->render('dashboard.html.twig', array('list'=>$reports));
    }

    public function updateVideo(\Silex\Application $app, Request $request)
    {
        $idreport = $request->get('id');
        $video = $request->get('youtube');
        // echo $idreport . " // " . $title ;
        if(!empty($idreport) and !empty($video)){
            $report = $app['orm.em']->getConnection()->prepare("UPDATE reports SET video='$video' WHERE id =".$idreport);
            $report->execute();            
            return new JsonResponse(array("success" =>true, "msg"=>"El video ha sido actualizado"));
        }else {
            return new JsonResponse(array("success" =>false, "msg"=>"El webinar no se encuentra registrado" ));
        }
       
        // $app->redirect($app["url_generator"]->generate("admin_dashboard"));
    }

    public function updateTitle(\Silex\Application $app, Request $request)
    {
        $idreport = $request->get('id');
        $title = $request->get('title');
        // echo $idreport . " // " . $title ;
        if(!empty($idreport) and !empty($title)){
            $report = $app['orm.em']->getConnection()->prepare("UPDATE reports SET title='$title' WHERE id =".$idreport);
            $report->execute();            
            return new JsonResponse(array("success" =>true, "msg"=>"El título ha sido actualizado"));
        }else {
            return new JsonResponse(array("success" =>false, "msg"=>"El webinar no se encuentra registrado" ));
        }
       
        // $app->redirect($app["url_generator"]->generate("admin_dashboard"));
    }

    public function deletereport(\Silex\Application $app, Request $request)
    {
        $idreport = $request->get('id');
         
        if(!empty($idreport)){
            $report = $app['orm.em']->getConnection()->prepare("DELETE FROM importuser WHERE Idreport=".$idreport);
            $report->execute();
            $report = $app['orm.em']->getConnection()->prepare("DELETE FROM reports WHERE id=".$idreport);
            $report->execute();
            return new JsonResponse(array("success" =>true, "msg"=>"El reporte ha sido eliminado"));
        }else {
            return new JsonResponse(array("success" =>false, "msg"=>"El reporte no se encuentra registrado"));
        }
       
        // $app->redirect($app["url_generator"]->generate("admin_dashboard"));
    }
    public function login(\Silex\Application $app, Request $request)
    {
        
        $s = $app['session']->get('user');

        if($s['rol']=='ROLE_PUBLIC'){
            echo "LOGEADO COMO PUBLICO";
            $app['session']->invalidate();
            // return $app->redirect($app['url_generator']->generate('publicroute'));
             return $app->redirect($app['url_generator']->generate('login'));
            // return $app->redirect('/');
        }
        $token = $app['security.token_storage']->getToken();  
        
        // if($s['rol']=='ROLE_ADMIN' || $s['rol']=='ROLE_SUPPORT'){ 
        //     echo "LOGEADO COMO ADMIN";
        //     return $app->redirect('/dashboard/admin');
        // }
        if ($token->getUser() != 'anon.') {
            if($token->getUser()->getRoles()[0]=='ROLE_ADMIN' or $token->getUser()->getRoles()[0]=='ROLE_SUPPORT'){ 
                echo "LOGEADO COMO ADMIN";
                // return $app->redirect('/dashboard/admin');
                return $app->redirect($app['url_generator']->generate('admin_dashboard'));
            }
        }
           
        $locale = $request->get('_locale');
        setcookie('_locale', $locale, time() + (86400 * 2), '/'); // 86400 = 1 day
        // echo "<pre>";
        //  print_r($token);
        //  print_r($token->getUser());
        //  print_r($token->getUser()->getUsername());
        //  print_r($token->getUser()->getRoles()[0]);
        // echo "</pre>";
        if (null !== $token) {
            $user = $token->getUser();
          
            // login
            if ($user !== 'anon.') {
                   print_r($user);
                // die();
                //desborda el app cuando verifica con token de usuario iniciado
               // return $this->verficicartoken($app,$request);
                
                
            } else {
                // print_r($app['session']);
                return $app['twig']->render('login.html.twig', array(
                    'error' => $app['security.last_error']($request),
                    'last_username' => $app['session']->get('_security.last_username'),
                 ));
            }
        } else {
            return $app['twig']->render('login.html.twig', array(
                'error' => $app['security.last_error']($request),
                'last_username' => $app['session']->get('_security.last_username'),
             ));
        }
    }
    private function verficicartoken($app,$request)
    {
        $rol =$app['security.role_hierarchy'];

        //users
        $v = array_merge($rol['ROLE_USER'],$rol['ROLE_SUPPORT'],$rol['ROLE_ADMIN']);
        // print($v);
        foreach($v as $v){
            if($app['security.authorization_checker']->isGranted($v) == 1){
                $app['session']->set('user', array('username' => $app['session']->get('_security.last_username') ));
            break;
            }else{
                $this->verficicartoken($app,$request);
            }   
        }
    }
    /**********************************************************************************************/
   /* public function list($app)
    {
        $arr = [];
        //
        $sqlmode = $app['orm.em']->getConnection()->prepare('SET sql_mode=0');
        $sqlmode->execute();

        $usuarios_es = $app['orm.em']->getConnection()->prepare("select a1.Titulo, a1.Idioma, a1.Categoria, a1.Fecha, a1.Slug from importuser a1 GROUP BY a1.Slug ORDER BY a1.Fecha DESC");
        $usuarios_es->execute();
        $es = $usuarios_es->fetchAll();
        if (!empty($es)) {
            foreach ($es as $key => $value) {
                $arr[] = [
                     'Titulo'   =>  $value['Titulo'],
                     'Idioma'   =>  $value['Idioma'],
                     'Categoria'=>  $value['Categoria'],
                     'Cant'     =>  $this->countrreg($value['Slug'],'es',$app),
                     'Fecha'    =>  $value['Fecha'],
                     'Slug'     =>  $value['Slug']
                ];
            }
        }
        
        return $arr;
    }*/

    
    /*public function countrreg($slug,$idioma,$app){
        if ($idioma=='pr') {
           $usuarios_pr = $app['orm.em']->getConnection()->prepare("SELECT * FROM importuserpr WHERE Slug='".$slug."'");
            $usuarios_pr->execute();
            $pr = $usuarios_pr->fetchAll();
        }else{
            $usuarios_pr = $app['orm.em']->getConnection()->prepare("SELECT * FROM importuser WHERE Slug='".$slug."'");
            $usuarios_pr->execute();
            $pr = $usuarios_pr->fetchAll();
        }
        return !empty($pr)? count($pr) : 0;
    }*/
    
    /*public function uprofile($v, $n, $app)
    {
        $su = $app['orm.em']->getRepository("Entity\Usuarios")->findOneBy(array('idusr'=>$v));
        $upf = $app['orm.em']->getRepository("Entity\Importuser")->findOneBy(array('emails'=>$su->getUsuario()));
        if (!empty($upf)) {
            $set = 'get'.$n;
            return $upf->$set();
        } else {
            return '';
        }
    }
    public function uaavtar($v, $app)
    {
        $su = $app['orm.em']->getRepository("Entity\Usuarios")->findOneBy(array('idusr'=>$v));
        //return '/avatar/'.$su->getAvatar();
        if (!empty($su->getAvatar())) {
            return '/avatar/'.$su->getAvatar();
        } else {
            return '/img/default-avatar.jpg';
        }
    }
    public function gtipo($v)
    {
        switch ($v) {
            case 'victoria':
                return 'Victories';
                break;
            case 'batalla':
            default:
                return 'Battle';
                break;
        }
    }
    public function gstatus($v)
    {
        switch ($v) {
            case 'pendiente':
                return 'Revisión';
                break;
            case 'rechazado':
                return 'Reject';
                break;
            case 'aprobado':
            default:
                return 'Aproved';
                break;
        }
    }*/
    /**************************************************************************************/
}
