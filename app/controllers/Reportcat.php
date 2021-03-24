<?php 
namespace Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
*
*/
class Reportcat
{
   
//    REVISAR SI SE VA USAR 
   
    public function index(\Silex\Application $app, Request $request)
    {
        $cat = $request->get('cat');
        $idioma = $request->get('idioma');
        $start = $request->get('start');
        $end = $request->get('end');
		$reportname = $request->get('reportname');

        $yr = empty( $request->get('yr') ) ? date("Y") : $request->get('yr');

        $app['yr'] = $yr;

        $sqlmode = $app['orm.em']->getConnection()->prepare('SET sql_mode=0');
        $sqlmode->execute();

        $report = array();
        /*************************************/
        if ($start != 'default' and $end != 'default') {
            if ($idioma=='pr') {
                $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM importuserpr  WHERE Categoria='".$cat."' AND Fecha BETWEEN '".$start."' AND '".$end."' GROUP BY Nome");
                $usuarios->execute();
                $report = $usuarios->fetchAll();
            } else {
                $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM importuser  WHERE Categoria='".$cat."' AND Fecha BETWEEN '".$start."' AND '".$end."' GROUP BY Nombre ");
                $usuarios->execute();
                $report = $usuarios->fetchAll();
            }
        }
        /*************************************/
        return $app['twig']->render('reportcat.html.twig', array(
            'cat'=>$cat,
            'idioma'=>$idioma,
            'start'=>$start,
            'end'=>$end,
            'report' => $report, 
			 'reportname' => $reportname
            ));
    }
    public function participants($v, $titulo, $idioma, $start, $end, $app)
    {
        $sqlmode = $app['orm.em']->getConnection()->prepare('SET sql_mode=0');
        $sqlmode->execute();
        if ($idioma=='es') {
            $idioma = 'importuser';
        } else {
            $idioma = 'importuserpr';
        }
        $where = '';
        if ($titulo=='default') {
            $where = " ";
        } else {
            if ($v=='Registered') {
                $where = " WHERE Categoria='".$titulo."'";
            } else {
                $where = " AND Categoria='".$titulo."'";
            }
        }

        if ($start != 'default' and $end != 'default' and $titulo != 'default') {
            $where .= " AND Fecha BETWEEN '".$start."' AND '".$end."'";
        }


        switch ($v) {
            case 'Registered':
                $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$idioma."  ".$where." ");
                $usuarios->execute();
                $c = $usuarios->fetchAll();
                return !empty($c)? count($c) : 0;
                break;
            case 'Asistants':
                $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$idioma." WHERE Attendedlive='Y' ".$where." ");
                $usuarios->execute();
                $c = $usuarios->fetchAll();
                return !empty($c)? count($c) : 0;
                break;
            case 'Partners':
                $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$idioma." WHERE Attendedlive='Y' ".$where." GROUP BY `Empresa`");
                $usuarios->execute();
                $c = $usuarios->fetchAll();
                return !empty($c)? count($c) : 0;
                break;
            case 'Consulting':
                $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$idioma." WHERE Attendedlive='Y' AND Industria='Consulting'  ".$where." ");
                $usuarios->execute();
                $c = $usuarios->fetchAll();
                return !empty($c)? count($c) : 0;
                break;
            case 'Software':
               $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$idioma." WHERE Attendedlive='Y' AND Industria='Software'  ".$where." ");
                $usuarios->execute();
                $c = $usuarios->fetchAll();
                return !empty($c)? count($c) : 0;
                break;
            case 'Technology':
               $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$idioma." WHERE Attendedlive='Y' AND Industria='Technology'  ".$where." ");
                $usuarios->execute();
                $c = $usuarios->fetchAll();
                return !empty($c)? count($c) : 0;
                break;
            case 'Others':
                 $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$idioma." WHERE Attendedlive='Y' AND Industria not in ('Tecnology','Software','Consulting')  ".$where." ");
                $usuarios->execute();
                $c = $usuarios->fetchAll();
                return !empty($c)? count($c) : 0;
                break;
            default:
                return 0;
                break;
        }
    }
    public function reportexregion($region, $titulo, $idioma, $start, $end, $app)
    {
        if ($idioma=='es') {
            $db = 'importuser';
        } else {
            $db = 'importuserpr';
        }
        
        $where = '';
        if ($titulo=='default') {
            $where = " ";
        } else {
            $where = " AND Categoria='".$titulo."'";
        }

        if ($start != 'default' and $end != 'default' and $titulo != 'default') {
            $where .= " AND Fecha BETWEEN '".$start."' AND '".$end."'";
        }

        switch ($idioma) {
           case 'es':
               switch ($region) {
                   case 'Norte':
                        $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$db." WHERE Attendedlive='Y' AND Pais in ('Colombia','Costa Rica','Ecuador','El Salvador','Guatemala','Panama','Honduras','Guyana','Venezuela','United States','Dominican Republic')  ".$where." ");
                        $usuarios->execute();
                        $c = $usuarios->fetchAll();
                        return !empty($c)? count($c) : 0;
                       break;
                   case 'Sur':
                       $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$db." WHERE Attendedlive='Y' AND Pais in ('Argentina','Chile','Peru','Bolivia','Paraguay','Uruguay')  ".$where." ");
                        $usuarios->execute();
                        $c = $usuarios->fetchAll();
                        return !empty($c)? count($c) : 0;
                       break;
                    case 'Mexico':
                        $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$db." WHERE Attendedlive='Y' AND Pais in ('Mexico')  ".$where." ");
                        $usuarios->execute();
                        $c = $usuarios->fetchAll();
                        return !empty($c)? count($c) : 0;
                        break;
                    case 'Others':
                        $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$db." WHERE Attendedlive='Y' AND Pais in ('Guernsey','Vietnam', 'Zimbabwe','Brazil')  ".$where." ");
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
    public function reportexpais($pais, $titulo, $idioma, $start, $end, $app)
    {
        if ($idioma=='es') {
            $db = 'importuser';
        } else {
            $db = 'importuserpr';
        }

        $where ='';
        
        if ($titulo=='default') {
            $titulo = " ";
        } else {
            $titulo = " AND Categoria='".$titulo."'";
        }
        
        if ($start != 'default' and $end != 'default' and $titulo != 'default') {
            $where .= " AND Fecha BETWEEN '".$start."' AND '".$end."'";
        }

        switch ($idioma) {
           case 'es':
                    $usuarios = $app['orm.em']->getConnection()->prepare("SELECT * FROM ".$db." 
                        WHERE Attendedlive='Y' AND Pais in ('".$pais."')  ".$where." ");
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
}
