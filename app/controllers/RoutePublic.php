<?php
namespace Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\HttpFoundation\Session\Session;
use Silex\Application\SecurityTrait;
use Silex\Route;

class RoutePublic{
    private $Session;

    public function publicuser(\Silex\Application $app, Request $request)
    {
        $orm = $app['orm.em'];

        if ( empty($app['session']->get('user')) ) {
            // return $app->redirect('/');
            return $app->redirect($app['url_generator']->generate('index'));
        }

        $s = $app['session']->get('user');

        if($s['rol']!='ROLE_PUBLIC'){
            // return $app->redirect('/');
            return $app->redirect($app['url_generator']->generate('index'));
        }

        $u =  $orm->getRepository('Entity\Importuser')->findOneBy(array('Email'=>$s['username']));

        if(empty($u)){
            $app['session']->invalidate();
            return $app->redirect($app['url_generator']->generate('index'));
            // return $app->redirect('/');
        }     

        $q = sprintf("SELECT i.Email, i.Nombre, r.id, r.title, r.category, r.lang, r.date FROM importuser i JOIN reports r ON r.id = i.IdReport WHERE Email = '%s' and Attendedlive ='Y' AND YEAR(r.date) >= YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) ORDER BY r.date desc",$u->getEmail());
        $c=$orm->getConnection()->prepare($q);
        $c->execute();
        $c=$c->fetchAll();

        // poner el idioma inicial a la session
        if(empty($app['session']->get('lang'))){   
            if(empty($c)){
                $lang =1;
            }else{
                $lang = ($c[0]['lang'] =='2')?2:1;
            }       
            // $lang = ($c[0]['lang'] =='2')?2:1;
            $app['session']->set('lang',$lang );
        }
        
        $langParams = $request->get('lang','es'); 
        if (!empty($langParams)){
            $lang = ($langParams =='pr')?2:1;
            $app['session']->set('lang',$lang );
        }
        $app['lang'] = $app['session']->get('lang'); 
         
        $q="SELECT * from reports r WHERE r.video <> '' AND r.video is NOT NULL AND YEAR(r.date) >= YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) ORDER BY r.date desc LIMIT 8";
        $v=$orm->getConnection()->prepare($q);
        $v->execute();
        $v=$v->fetchAll();



        return $app['twig']->render('user/home.html.twig', array(
            'u' => $u,
            'c' => $c,
            'v' => $v,
            's' => $s
         ));
    }

public function publicvideo(\Silex\Application $app, Request $request)
    {
        $orm = $app['orm.em'];

        if ( empty($app['session']->get('user')) ) {
            return $app->redirect($app['url_generator']->generate('index'));
            // return $app->redirect('/');
        }
        $s = $app['session']->get('user');
        
        if($s['rol']!='ROLE_PUBLIC'){
            // return $app->redirect('/');
            return $app->redirect($app['url_generator']->generate('index'));
        }
        
        $app['lang'] = $app['session']->get('lang');  
        // echo " /// " . $app['session']->get('lang'); 
        
        $id = preg_replace("/[^0-9]+/", "", $request->get('id'));
        $r =  $orm->getRepository('Entity\Reports')->findOneBy(array('id'=>$id));               
        // print_r($r);
        return $app['twig']->render('user/video.html.twig', array(
            'r' => $r,
            's' => $s
         ));
    }

    
    
    public function accessvalidation(\Silex\Application $app, Request $request){
        $email =  $request->get('email');
        $orm = $app['orm.em'];
        // $app['session.storage.handler'] = null;
        $data = $orm->getRepository('Entity\Importuser')->findOneBy(array('Email'=>$email));
        if(!empty($data)){
            // Authenticating user
            $app['session']->set('user', array('username' => $data->getEmail(),'rol'=>'ROLE_PUBLIC'));
            return $app->redirect($app["url_generator"]->generate("publicroute"));
        }else{
            return $app->redirect($app["url_generator"]->generate("index"));
        }
    }
    public function publiclogout(\Silex\Application $app, Request $request){
        $app['session']->invalidate();
        // $this->Session->clear();
        // return $app->redirect('/');
        return $app->redirect($app['url_generator']->generate('index'));
    }
}