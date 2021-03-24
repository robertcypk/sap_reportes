<?php 
namespace Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Silex\Application\SecurityTrait;
use Silex\Route;
use Silex\Api\ControllerProviderInterface;

/**
*
*/
class Report 
{
    public function index(\Silex\Application $app, Request $request)
    {
        $slug = $request->get('titulo','0');
        $idioma = $request->get('idioma','es');        
        $yr = empty( $request->get('yr') ) ? date("Y") : $request->get('yr');
        //set variable global 
        $app['yr'] = $yr;
        $lang = ($idioma =='pr')?2:1;
        $app['lang'] = $lang;
        // $slug = 'default';
        // $titulo = 'Default';
        
        $report = [];

        $sqlmode = $app['orm.em']->getConnection()->prepare('SET sql_mode=0');
        $sqlmode->execute();
        
        if (!empty($slug) and !empty($idioma)) {            
            $report = $app['orm.em']->getRepository("Entity\Reports")->findOneBy(array('slug'=>$slug,'lang'=>$lang));
            /*************************************/
            // print_r($report);           
            // $titulo = $list->getTitulo();
            // $slug = $list->getSlug();            
           /* if ($idioma=='pr' ) {
                // AND Nome != NULL  GROUP BY Nome
                $usuarios = $app['orm.em']->getConnection()->prepare("SELECT DISTINCT * FROM importuserpr  WHERE Slug='".$slug."' AND YEAR(Fecha)='".$yr."'");
                $usuarios->execute();
                $report = $usuarios->fetchAll();
            } else {
                // AND Nombre != NULL GROUP BY Nombre
                $usuarios = $app['orm.em']->getConnection()->prepare("SELECT DISTINCT * FROM importuser  WHERE Slug='".$slug."' AND YEAR(Fecha)='".$yr."'");
                $usuarios->execute();
                $report = $usuarios->fetchAll();
            }*/
            /*************************************/
        }        

        return $app['twig']->render('report.html.twig', array('year'=>$yr,'lang'=>$idioma,'report'=>$report));
    }

    public function datareports(\Silex\Application $app, Request $request)
    {
        $slug = $request->get('slug');
        $idioma = $request->get('idioma','es');
        $lang = ($idioma =='pr')?2:1;
        $app['lang'] = $lang;
        // $slug = 'default';
        // $titulo = 'Default';
        
        $report = [];
        $data = [];
        $sqlmode = $app['orm.em']->getConnection()->prepare('SET sql_mode=0');
        $sqlmode->execute();
        
        if (!empty($slug)) {            
            $report = $app['orm.em']->getRepository("Entity\Reports")->findOneBy(array('slug'=>$slug,'lang'=>$lang));
        } 
        if (!empty($report) ) {            
            $data = $app['orm.em']->getRepository("Entity\Importuser")->findBy(array('Idreport'=>$report->getId()));
        }        

        return $app['twig']->render('report_data.html.twig', array('lang'=>$idioma,'report'=>$report, 'data'=>$data));
    }

    public static function menu_lis($cat, $lang, $app )    {
       
        $sqlmode = $app['orm.em']->getConnection()->prepare('SET sql_mode=0');
        $sqlmode->execute();
        $lang = ($lang =='pr')?2:1;
        if ($cat =='marketing') {
            $cat = 1;
        } else if ($cat =='social') {
            $cat = 2;
        }else{
            $cat = 3;
        }
        $usuarios = $app['orm.em']->getConnection()->prepare("SELECT title,slug FROM reports WHERE category=".$cat." AND lang=".$lang." AND YEAR(date)='".$app['yr']."' ORDER BY date");
        $usuarios->execute();
        $c = $usuarios->fetchAll();
        return $c;
    }
    public static function participants($v, $idreport, $app)
    {
        $sqlmode = $app['orm.em']->getConnection()->prepare('SET sql_mode=0');
        $sqlmode->execute();
        switch ($v) {
            case 'Registered':
                $reporte = $app['orm.em']->getConnection()->prepare("SELECT COUNT(*) as total FROM importuser WHERE Idreport=".$idreport);
                $reporte->execute();                
                $c = $reporte->fetch();
                // print_r($c['total']);
                return $c['total'];
                break;
            case 'Asistants':
                $reporte = $app['orm.em']->getConnection()->prepare("SELECT COUNT(*) as total FROM importuser WHERE Attendedlive='Y' AND Idreport=".$idreport);
                $reporte->execute();
                $c = $reporte->fetch();
                return $c['total'];
                break;
            case 'Partners':
                $reporte = $app['orm.em']->getConnection()->prepare("SELECT COUNT(DISTINCT Empresa) as total FROM importuser WHERE Attendedlive='Y' AND Idreport=".$idreport);
                $reporte->execute();
                $c = $reporte->fetch();
                return $c['total'];
                break;
            case 'Consulting':
                $reporte = $app['orm.em']->getConnection()->prepare("SELECT COUNT(*) as total FROM importuser WHERE Attendedlive='Y' AND Industria='Consulting' AND Idreport=".$idreport);
                $reporte->execute();
                $c = $reporte->fetch();
                return $c['total'];
                break;
            case 'Software':
                $reporte = $app['orm.em']->getConnection()->prepare("SELECT COUNT(*) as total FROM importuser WHERE Attendedlive='Y' AND Industria='Software' AND Idreport=".$idreport);
                $reporte->execute();
                $c = $reporte->fetch();
                return $c['total'];
                break;
            case 'Technology':
                $reporte = $app['orm.em']->getConnection()->prepare("SELECT COUNT(*) as total FROM importuser WHERE Attendedlive='Y' AND Industria='Technology' AND Idreport=".$idreport);
                $reporte->execute();
                $c = $reporte->fetch();
                return $c['total'];
                break;
            case 'Others':
                $reporte = $app['orm.em']->getConnection()->prepare("SELECT COUNT(*) as total FROM importuser WHERE Attendedlive='Y' AND Industria not in ('Tecnology','Software','Consulting')  AND Idreport=".$idreport);
                $reporte->execute();
                $c = $reporte->fetch();
                return $c['total'];
                break;
            default:
                return 0;
                break;
        }
    }
    // USADO PARA CONTEOS CONCIDENCIAS
   public static function contar_rpts($col, $v,$idreport,$app){
    //    echo "SELECT COUNT(*) as total FROM importuser WHERE Attendedlive='Y' AND $col LIKE '%$v%' AND Idreport=".$idreport;
        $reporte = $app['orm.em']->getConnection()->prepare("SELECT COUNT(*) as total FROM importuser WHERE Attendedlive='Y' AND $col LIKE '%$v%' AND Idreport=".$idreport);
        $reporte->execute();
        $c = $reporte->fetch();
        return $c['total'];
   }

    // USADO PARA CONTEOS PAISES
   public static function contar_rpts_varias($col, $v,$idreport,$app){
        $reporte = $app['orm.em']->getConnection()->prepare("SELECT COUNT(*) as total FROM importuser WHERE Attendedlive='Y' AND $col IN ($v) AND Idreport=".$idreport);
        $reporte->execute();
        $c = $reporte->fetch();
        return $c['total'];
   }
    /*
    public static function reportexregion($region, $titulo, $idioma, $app)
    {
        if ($idioma=='es') {
            $db = 'importuser';
        } else {
            $db = 'importuserpr';
        }
        if ($titulo=='default') {
            $titulo = " ";
        } else {
            $titulo = " AND Slug='".$titulo."' ";
        }
        switch ($idioma) {
           case 'es':
               switch ($region) {
                   case 'Norte':
                        
                        $titulo .= "AND YEAR(Fecha)='".$app['yr']."'";
                        
                        
                        $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$db." WHERE Attendedlive='Y' AND Pais in ('Colombia','Costa Rica','Ecuador','El Salvador','Guatemala','Panama','Honduras','Guyana','Venezuela','United States','Dominican Republic')  ".$titulo." ");
                        $usuarios->execute();
                        $c = $usuarios->fetchAll();
                        return !empty($c)? count($c) : 0;
                       break;
                   case 'Sur':
                       
                       $titulo .= "AND YEAR(Fecha)='".$app['yr']."'";

                       $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$db." WHERE Attendedlive='Y' AND Pais in ('Argentina','Chile','Peru','Bolivia','Paraguay','Uruguay')  ".$titulo." ");
                        $usuarios->execute();
                        $c = $usuarios->fetchAll();
                        return !empty($c)? count($c) : 0;
                       break;
                    case 'Mexico':
                        
                        $titulo .= "AND YEAR(Fecha)='".$app['yr']."'";
                        
                        $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$db." WHERE Attendedlive='Y' AND Pais in ('Mexico')  ".$titulo." ");
                        $usuarios->execute();
                        $c = $usuarios->fetchAll();
                        return !empty($c)? count($c) : 0;
                        break;
                    case 'Others':
                        
                        $titulo .= "AND YEAR(Fecha)='".$app['yr']."'";
                        
                        $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$db." WHERE Attendedlive='Y' AND Pais in ('Guernsey','Vietnam', 'Zimbabwe','Brazil')  ".$titulo." ");
                        $usuarios->execute();
                        $c = $usuarios->fetchAll();
                        return !empty($c)? count($c) : 0;
                        break;
                   default:
                       return 0;
                       break;
               }
               break;
           case 'pr':
               # code...
               break;
           default:
               return 0;
               break;
       }
    }
    public static function reportexpais($pais, $titulo, $idioma, $app)
    {
        if ($idioma=='es') {
            $db = 'importuser';
        } else {
            $db = 'importuserpr';
        }
        if ($titulo=='default') {
            $titulo = " ";
        } else {
            $titulo = " AND Slug='".$titulo."' ";
        }
        switch ($idioma) {
           case 'es':

                    $titulo .= " AND YEAR(Fecha)='".$app['yr']."'";

                    $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$db." 
                        WHERE Attendedlive='Y' AND Pais in ('".$pais."')  ".$titulo." ");
                        $usuarios->execute();
                        $c = $usuarios->fetchAll();
                        return !empty($c)? count($c) : 0;
                       break;
               break;
           case 'pr':
               # code...
               break;
           default:
               return 0;
               break;
       }
    }
     
    public static function menu_lang($category, $lang,$year,$app )
    {
        return $app['orm.em']->getRepository('Entity\Reports')->findBy(array('lang'=>$lang,'cat'=>$category,'date'=>$year),array('date' => 'ASC'));
    }
    */
}
