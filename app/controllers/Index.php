<?php
namespace Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Silex\Application\SecurityTrait;
use Silex\Route;

class Index implements ControllerProviderInterface
{
    /**********************************************************************************************/
    public function connect(\Silex\Application $app)
    {
        $f=$app['controllers_factory'];
        
        $f->get('/login', 'Web\Dashboard::login')->bind('login')->method('GET|POST');
        
        $f->get('/', 'Web\Index::home')->bind('index');
        
        $f->get('/user', 'Web\RoutePublic::publicuser')
          ->bind('publicroute');

        $f->get('/video/{id}', 'Web\RoutePublic::publicvideo')
          ->value('id', '0')
          ->bind('publicvideo');

        $f->get('/public_logout', 'Web\RoutePublic::publiclogout')
          ->bind('publiclogout');

        $f->match('/access_validation','Web\RoutePublic::accessvalidation')
          ->bind('accessvalidation')
          ->method('POST');

        $f->match('/makepdf','Web\Pdfdownloader::make')
          ->bind('makepdf')
          ->method('POST');

        $f->get('/dashboard/admin', 'Web\Dashboard::index')->bind('admin_dashboard');        
        $f->match('/dashboard/admin/listpr', 'Web\Dashboard::listpr')->bind('listpr')->method('GET|POST');
        $f->match('/dashboard/import', 'Web\ImportUsers::import')->bind('import')->method('GET|POST')->secure('ROLE_ADMIN');
        $f->match('/dashboard/xml-import', 'Web\ImportUsers::xml')->bind('xml_import')->method('GET|POST')->secure('ROLE_ADMIN'); 

        $f->get('/dashboard/edit-title/{id}', 'Web\Dashboard::updateTitle')
          ->value('id', '0')
          ->bind('update_title')
          ->method('GET|POST');
          // ->secure('ROLE_ADMIN'); 

        $f->get('/dashboard/edit-video/{id}', 'Web\Dashboard::updateVideo')
          ->value('id', '0')
          ->bind('update_video')
          ->method('GET|POST');
          // ->secure('ROLE_ADMIN'); 

        $f->get('/dashboard/admin-delete/{id}', 'Web\Dashboard::deletereport')
          ->value('id', '0')
          ->bind('admin_del')
          ->method('GET|POST')
          ->secure('ROLE_ADMIN');        
        
        $f->get('/sap/report/{yr}/{idioma}/{titulo}', 'Web\Report::index')
          ->value('yr', date("Y") )
          ->value('idioma', 'es')
          ->value('titulo', '0')
          ->bind('report');

        $f->get('/sap/report-data/{idioma}/{slug}', 'Web\Report::datareports')          
          ->value('idioma', 'es')
          ->value('slug', '0')
          ->bind('datareports');

        $f->get('/sap/report-cat-date/{yr}/{idioma}/{cat}/{start}/{end}/{reportname}', 'Web\Reportcat::index')
          ->value('idioma', 'es')
          ->value('cat', 'default')
          ->value('start', 'default')
          ->value('end', 'default')
          ->value('reportname','default')
          ->value('yr', date("Y") )
          ->bind('report-cat-date');

        $f->match('/registro','Web\Users::save')->bind('registro')->method('POST');

        $f->get('/encode/{pwd}', 'Web\EncodePwd::encode')->value('pwd','0')->bind('encode')->method('GET|POST');
       
        //$f->match('/repair', 'Web\Index::repair')->bind('repair')->method('GET|POST');
        
        return $f;
    }
    
    public function home(\Silex\Application $app, Request $request)
    {
        
      if ( !empty($app['session']->get('user')) ) {
        return $app->redirect('/user');
      }
      $idioma = $request->get('lang','es');  
      // print_r($idioma);
      $lang = ($idioma =='pr')?2:1;
      $app['lang'] = $lang;
      // echo  $app['lang'];
      return $app['twig']->render('user/login.html.twig', array(
            'error' => $app['security.last_error']($request),
            'lang'=>$lang
         ));
    }
    /**************************************************************************************/
}
