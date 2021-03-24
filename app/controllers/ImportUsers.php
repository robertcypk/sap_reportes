<?php
namespace Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

libxml_use_internal_errors(true);

class ImportUsers
{
    /**********************************************************************************************/
    public function import(\Silex\Application $app, Request $request)
    {
        return $app['twig']->render('import-users.html.twig', array());
    }
    public function xml(\Silex\Application $app, Request $request)
    {
        $r = array();
        $msg = '';
        $xml = $request->files->get('reporte');
        $path = str_replace('app\controllers', '', __DIR__).'xml';
        // echo $path ;
        // $html = '<table boder="1">';
        // $az = range('A', 'Z');
        $titulo = $request->get('titulo');
        $idioma = $request->get('idioma');
        $categoria = $request->get('categoria');
        $fecha = $request->get('fecha');//time();
        $slug = preg_replace('/[^a-z0-9]/i', '', str_replace(array(' ',"'"), array('-',' '), $titulo));
        if (empty($titulo) or empty($idioma) or empty($categoria) or empty($fecha)){            
            return $app['twig']->render('import-users.html.twig', array("msg"=>"Complete los datos solicitados"));
        }
        $idReport =  $this->newReport($titulo,$categoria, $idioma,$fecha, $slug, $app);
        if (!empty($xml)) {

            $originalFilename = pathinfo($xml->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = "reporteExcel";// transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.time().'.'.$xml->guessExtension();


            // $xml->move($path, $xml->getClientOriginalName());
            $xml->move($path, $newFilename);
            // Convenience method for creating a file streamer with the default parser
            $excel = \PHPExcel_IOFactory::load($path.'/'. $newFilename);
            $sheets = [];
            foreach ($excel->getAllSheets() as $sheet) {
                $sheets[$sheet->getTitle()] = $sheet->toArray();
            }
        // print_r($sheets);
        // echo "NEW ID: ".$idReport .'<br>';
        $e = new \Entity\Importuser;
        $cant = 0;
        foreach ($sheets as $key => $value) {            
            foreach (array_slice($value,1) as $key => $v) {
                if (!empty($v[0]) or !empty($v[2]) or !empty($v[5]) or !empty($v[9]) or !empty($v[10]) ){
                    $e->setNombre($this->capitalizar($v[0]));
                    $e->setApellido($this->titularizar($v[1]));
                    $e->setEmail(strtolower($v[2]));
                    $e->setRelacionconsap($this->titularizar($v[3]));
                    $e->setEmpresa($this->titularizar($v[4]));
                    $e->setIndustria($this->capitalizar($v[5]));
                    $e->setCargo($this->capitalizar($v[6]));
                    $e->setTelefonodelaempresa($v[7]);
                    $e->setCiudad($this->elimina_acentos($v[8]));
                    $e->setPais($this->elimina_acentos($v[9]));
                    $e->setAttendedlive($this->capitalizar($v[10]));
                    $e->setPregunta1($this->capitalizar($v[11]));
                    $e->setPregunta2($this->capitalizar($v[12]));
                    $e->setPregunta3($this->capitalizar($v[13]));
                    $e->setPregunta4($this->capitalizar($v[14]));
                    $e->setPregunta5($this->capitalizar($v[15]));
                    $e->setPregunta6($v[16]);
                    $e->setPregunta7($v[17]);
                    $e->setFecha(date('Y-m-d H.i:s'));
                    $e->setIdreport($idReport);
                    $app["orm.em"]->persist($e);
                    $app["orm.em"]->flush();
                    $app["orm.em"]->clear();
                    $cant++;  
                } 
            }
        }

        $report = $app['orm.em']->getRepository('Entity\Reports')->find(array('id'=>$idReport)); 
        if (!empty($report)) {            
            $report->setCant($cant);
            $app["orm.em"]->persist($report);
            $app["orm.em"]->flush();
            $app["orm.em"]->clear();
        }

           /* foreach ($excel->getWorksheetIterator() as $worksheet) {
                $highestRow =  $worksheet->getHighestRow();
                echo "PAgina: " . $highestRow . '</br>';
                for ($i=0; $i < 18; $i++) {
                    $fcolumn = preg_replace('/[^a-z0-9]/i', '', $this->elimina_acentos($worksheet->getCellByColumnAndRow($i, 1)->getValue()));
                    $fcolumn = strtolower($fcolumn);
                    $fcolumn = ucfirst($fcolumn);
                    echo "Columna: ". $fcolumn.'<br>';
                    for ($row=1; $row<=$highestRow; $row++) {
                        $frow = $worksheet->getCellByColumnAndRow($i, $row)->getValue();
                        $ffrow = ucfirst(preg_replace('/[^a-z0-9]/i', '', $this->elimina_acentos($frow)));
                        if ($fcolumn!=$ffrow and !empty($fcolumn)) {
                            // $r[$row]['Titulo'] = $titulo;
                            // $r[$row]['Idioma'] = $idioma;
                            // $r[$row]['Categoria'] = $categoria;
                            // $r[$row]['Fecha'] = $fecha;
                            // $r[$row]['Slug'] = preg_replace('/[^a-z0-9]/i', '', str_replace(array(' ',"'"), array('-',' '), $titulo));
                            $r[$row][ $fcolumn ] = $ffrow;
                            ---if ($fcolumn!='Nombrecompleto') {
                                if ($fcolumn=='Dateacquired') {
                                    $timestamp = \PHPExcel_Shared_Date::ExcelToPHP($frow);
                                    $timestamp = strtotime("+1 day", $timestamp);
                                    $fecha = date("d/m/Y", $timestamp);
                                    $r[$row][ $fcolumn ] = $fecha;
                                } else {
                                    $r[$row][ $fcolumn ] = $frow;
                                }
                            }--
                        }
                    }
                }
            }*/

            //echo count($this->serachv('Empleado de SAP', 'DD', array_values($r)));
            //echo '<pre>';
           // print_r($r);
            //echo '</pre>';
            //   ---  $echo = $this->save($r, $idioma, $app);
            // echo $echo;

            // unlink($path.'/'.$xml->getClientOriginalName());
             unlink($path.'/'.$newFilename);
            
            return $app['twig']->render('import-users.html.twig', array("msg"=>"Registro completado: ".$titulo));
            //return $app->redirect($app["url_generator"]->generate("admin_dashboard"));
            //return $app['twig']->render('excelimporter.html.twig', array('msg'=>$r,'status'=>$msg));
        } else {
            return $app['twig']->render('import-users.html.twig', array("msg"=>"Reporte no completado : ".$titulo));
            // return 'proceso lo basico';
             //$app['twig']->render('excelimporter.html.twig', array('msg'=>$r,'status'=>$msg)); //$app->redirect( $app["url_generator"]->generate("ImportUsers") );
        }
    }
    private function serachv($v, $k, $a)
    {
        $array = [];
        if (is_array($a)) {
            foreach ($a as $key => $value) {
                if (array_key_exists($k, $a)) {
                    if ($v == $value[$k]) {
                        $array[] = $value[$k];
                    }
                }
            }
        }
        return $array;
    }
    private function elimina_acentos($text)
    {
        $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        $text = strtolower($text);
        $patron = array(
            // Espacios, puntos y comas por guion
            //'/[\., ]+/' => ' ',
 
            // Vocales
            '/\+/' => '',
            '/&agrave;/' => 'a',
            '/&egrave;/' => 'e',
            '/&igrave;/' => 'i',
            '/&ograve;/' => 'o',
            '/&ugrave;/' => 'u',
 
            '/&aacute;/' => 'a',
            '/&eacute;/' => 'e',
            '/&iacute;/' => 'i',
            '/&oacute;/' => 'o',
            '/&uacute;/' => 'u',
 
            '/&acirc;/' => 'a',
            '/&ecirc;/' => 'e',
            '/&icirc;/' => 'i',
            '/&ocirc;/' => 'o',
            '/&ucirc;/' => 'u',
 
            '/&atilde;/' => 'a',
            '/&etilde;/' => 'e',
            '/&itilde;/' => 'i',
            '/&otilde;/' => 'o',
            '/&utilde;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            '/&auml;/' => 'a',
            '/&euml;/' => 'e',
            '/&iuml;/' => 'i',
            '/&ouml;/' => 'o',
            '/&uuml;/' => 'u',
 
            // Otras letras y caracteres especiales
            '/&aring;/' => 'a',
            '/&ntilde;/' => 'n',
 
            // Agregar aqui mas caracteres si es necesario
 
        );
 
        $text = preg_replace(array_keys($patron), array_values($patron), $text);
        return ucfirst($text);
    }

    private function capitalizar($text)
    {
        return ucfirst(mb_strtolower($text, 'UTF-8'));
    }
    private function titularizar($text)
    {
        return ucwords(mb_strtolower($text, 'UTF-8'));
    }
   /* private function save($arr, $idioma, $app)
    {
        if ($idioma=='pr') {
            $e = new \Entity\Importuserpr;
        } else {
            $e = new \Entity\Importuser;
        }


        foreach ($arr as $key => $value) {
            $s = $e;
            foreach ($value as $key => $v) {
                $key = 'set'.$key;
                $s->$key(mb_convert_encoding($v, 'UTF-8'));
            }
            $app["orm.em"]->persist($s);
            $app["orm.em"]->flush();
            $app["orm.em"]->clear();
        }

        if ($idioma=='pr') {
            $clear = $app['orm.em']->getConnection()->prepare("DELETE FROM importuserpr  WHERE Nome = ' ' ");
            $clear->execute();
        } else {
            $clear = $app['orm.em']->getConnection()->prepare("DELETE FROM importuser  WHERE Nombre = ' ' ");
            $clear->execute();
        }
        
        return 1;
    }*/
    /**************************************************************************************/

    private function newReport($title,$category, $lang,$fecha,$slug, $app)
    {
        $e = new \Entity\Reports;     
        $e->setTitle($title);
        $e->setCategory($category);
        $e->setLang($lang);
        $e->setSlug($slug);
        $e->setStatus(1);
        $e->setDate($fecha);
        $e->setCreatedat(date('Y-m-d H.i:s'));
        $e->setUpdatedat(date('Y-m-d H.i:s'));
        $app["orm.em"]->persist($e);
        $app["orm.em"]->flush();
        $app["orm.em"]->clear();
        return $e->getId();
    }
}
