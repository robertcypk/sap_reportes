<?php
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

use Silex\Api\BootableProviderInterface;
use Silex\Api\EventListenerProviderInterface;

use Symfony\Component\Yaml\Parser;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\SwitchUserEvent;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestMatcher;
use Symfony\Component\Security\Core\Security;


use Silex\Route;

use Silex\Application\SecurityTrait;
//Silex\Application\SecurityTrait

use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\Routing\RouteCollection;

use Lokhman\Silex\Provider\ConfigServiceProvider;

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;

use WhoopsSilex\WhoopsServiceProvider;
use Symfony\Component\Dotenv\Dotenv;

//$app = new Silex\Application();
$app = new Web\SApp();

$dotenv = new Dotenv();
$dotenv->loadEnv('.env');


// $app['debug'] = false;
$app['debug'] = ($_ENV['DEBUG'] =='true')?:false;

$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app->register(new Silex\Provider\SerializerServiceProvider());
$app->register(new Silex\Provider\VarDumperServiceProvider());

$app->register(new Silex\Provider\HttpFragmentServiceProvider());
/*
$app->register(new Silex\Provider\WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/cache/profiler',
    'profiler.mount_prefix' => '/_profiler', // this is the default
));
*/

$app->register(new Silex\Provider\HttpCacheServiceProvider(), array(
    'http_cache.cache_dir' =>  __DIR__.'/cache',
    'http_cache.esi'       => null,
));

$app->register(new DoctrineServiceProvider(), array(
    'db.options'    => array(
            'driver'    => $_ENV['DB_DRIVER'],
            'host'      => $_ENV['DB_HOST'],
            'dbname'    => $_ENV['DB_DATABASE'],
            'user'      => $_ENV['DB_USERNAME'],
            'password'  => $_ENV['DB_PASSWORD'],
            'charset'   => $_ENV['DB_CHARSET'],
            'driverOptions' => array(1002 => "SET NAMES 'utf8mb4'")
       )
));



$app->register(new DoctrineOrmServiceProvider, array(
    "orm.em.options" => array(
         "mappings" => array(
                array(
                   "type"      => "yml",
                   "namespace" => "Entity",
                   "path"      => __DIR__."/app/doctrine",
                  ),
            ),
            'mysql' => array(
                'connection' => 'mysql',
                'mappings' => array(),
            )
         ),
));

// woops! service provider
if($app['debug']) {
   $app->register(new WhoopsServiceProvider);
}

$app['emailnact'] = '';
$locale = 'es';
if (!empty($_COOKIE['_locale'])) {
    $locale = $_COOKIE['_locale'];
}

$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1',
    'assets.version_format' => '%s?version=%s',
    'base_path' => '/',
    'assets.named_packages' => array(
        'css' => array('version' => 'css2', 'base_path' => '/'),
        'images' => array('base_urls' => array('http://app.project/')),
    ),
));

// 404 - Page not found
$app->error(function (\Exception $e, $code) use ($app) {
    if (404 === $code) {
        return $app->redirect($app->url('home'));
    }
    // Do something else (handle error 500 etc.)
});

$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale' => $locale,
    'locale_fallback' => $locale,
));

$app->extend('translator', function ($translator, $app) {
    $translator->addLoader('yaml', new \Symfony\Component\Translation\Loader\YamlFileLoader());
    $translator->addResource('yaml', __DIR__.'/locales/en.yml', 'en');
    $translator->addResource('yaml', __DIR__.'/locales/es.yml', 'es');
    $translator->addResource('yaml', __DIR__.'/locales/pr.yml', 'pr');
    return $translator;
});

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/app/views',
    'twig.options' => array('cache' => __DIR__.'/cache/twig', 'debug' => $app['debug'])
));

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    $twig->getExtension('Twig_Extension_Core')->setTimezone('America/Lima');
    
    $twig->addFunction(new \Twig_SimpleFunction('local', function () use ($app) {
        if (!empty($_COOKIE['_locale'])) {
            return $_COOKIE['_locale'];
        } else {
            return 'es';
        }
    }));
     $twig->addFunction(new \Twig_SimpleFunction('traduccion', function ($esp,$port) use ($app) {
          return ($app['lang']=='1')? $esp: $port;
    }));
    $twig->addFunction(new \Twig_SimpleFunction('menu_list', function ($cat, $idioma) use ($app) {
        return Web\Report::menu_lis($cat, $idioma, $app);
    }));
    $twig->addFunction(new \Twig_SimpleFunction('participants', function ($v, $idreport) use ($app) {
        return Web\Report::participants($v, $idreport, $app);
    }));
    $twig->addFunction(new \Twig_SimpleFunction('contar_rpts', function ($col, $v,$idreport) use ($app) {
        return Web\Report::contar_rpts($col,$v,$idreport,$app);        
    }));
$twig->addFunction(new \Twig_SimpleFunction('contar_rpts_varias', function ($col, $v,$idreport) use ($app) {
        return Web\Report::contar_rpts_varias($col,$v,$idreport,$app);        
    }));
    
    /* ----------------------------------------------------------------------------- */
    /* ----------------------------------------------------------------------------- */
    $twig->addFunction(new \Twig_SimpleFunction('reportexregion', function ($region, $titulo, $idioma) use ($app) {
        return ''; //Web\Report::reportexregion($region, $titulo, $idioma, $app);
    }));
    $twig->addFunction(new \Twig_SimpleFunction('reportexpais', function ($pais, $titulo, $idioma) use ($app) {
        return ''; //Web\Report::reportexpais($pais, $titulo, $idioma, $app);
    }));

    $twig->addFunction(new \Twig_SimpleFunction('participantscat', function ($v, $cat, $idioma, $start, $end) use ($app) {
        return Web\Reportcat::participants($v, $cat, $idioma, $start, $end, $app);
    }));
    $twig->addFunction(new \Twig_SimpleFunction('reportexregioncat', function ($region, $cat, $idioma, $start, $end) use ($app) {
        return Web\Reportcat::reportexregion($region, $cat, $idioma, $start, $end, $app);
    }));
    $twig->addFunction(new \Twig_SimpleFunction('reportexpaiscat', function ($pais, $cat, $idioma, $start, $end) use ($app) {
        return Web\Reportcat::reportexpais($pais, $cat, $idioma, $start, $end, $app);
    }));

    $twig->addFunction(new \Twig_SimpleFunction('reportepreguntas', function ($u, $v, $r, $cat, $idioma, $start, $end) use ($app) {
        if($u =='default'){
            return Web\Preguntas::portitulo($v, $r, $cat, $idioma, $app);
        }else{
            return Web\Preguntas::porcategoria($v, $r, $cat, $idioma, $start, $end, $app);    
        }
    }));
    return $twig;
});

//Configuracion de depuracion
// $app['debug'] = false;
//firma
$app['copyright'] = '© 2020. All rights reserved.';

$admins = array('ROLE_ADMIN','ROLE_ALLOWED_TO_SWITCH','ROLE_SUPER_ADMIN');
$ventas = array('ROLE_VENTAS');
$soporte = array('ROLE_SUPPORT','ROLE_IMAGENTI');
$usuarios = array('ROLE_USER','ROLE_PLANNER','ROLE_CLIENT','ROLE_COMPRAS','ROLE_PUBLIC');

$app['security.default_encoder'] = function ($app) {
    return $app['security.encoder.pbkdf2'];
};

$app->register(new Silex\Provider\SecurityServiceProvider());
$app['security.firewalls']= array(
    'secured' => array(
        'pattern' => '^.*$',
        'anonymous' => true,
        'http' => true,
        'form' => array(
            'login_path' => '/login',
            'check_path' => '/login_check',
            'default_target_path' => '/dashboard/admin'
        ),
        'logout' => array(
                'logout_path' => '/logout',
                'invalidate_session' => false
        ),
        'remember_me' => array(
            'key'                => uniqid(),
            'always_remember_me' => true,
        ),
        'users' => function () use ($app) {
         return new Web\UserProvider($app['db']);
        }
        // 'users' => array(
        //     'devadmin' => array('ROLE_ADMIN','$2y$13$sqpkwjeFJPBRaoUPttCaHO3s3lHi78zvOuXVyJsLTHwlyMJvUdxKe'),
        //     'sapadmin' => array('ROLE_ADMIN', '$2y$13$go/3/RKZXAXZOluB9Sq.WOEfcj2z8PJZEZpJOUx9pv.3I9bhFdTiK'),
        // ), 
    )
);

$app['security.encoders']  = array(
    'Entity\Usuarios'=> array(
     'algorithm' => 'sha1',
     'iterations' => 4,
     'encode_as_base64' => false
   )
    );
$app['security.role_hierarchy'] = array(
   'ROLE_USER' => $usuarios,
   'ROLE_SUPPORT' => $soporte,
   'ROLE_ADMIN' => $admins
);
// load rols
$rol =$app['security.role_hierarchy'];
$v = array_merge($rol['ROLE_USER'],$rol['ROLE_SUPPORT'],$rol['ROLE_ADMIN']);
$c = array_merge($rol['ROLE_SUPPORT'],$rol['ROLE_ADMIN']);

$app['security.access_rules'] = array(
     array('^/$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
     //array('^/public','ROLE_PUBLIC'),
     array('^/logout$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
     array('^/dashboard/.+$',$v ),
     array('^/sap/.+$',$c)
    //  array('^/sap/.+$',$admins)
);

$app->register(new Silex\Provider\RememberMeServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Web\PhpMailerServiceProvider());

$app['route_class'] = 'Web\SRoute';
$app->boot();
