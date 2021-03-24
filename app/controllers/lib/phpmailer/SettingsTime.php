<?php
namespace Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SettingsTime{
/**********************************************************************************************/
// REVISAR PARA ELIMINAR
/**********************************************************************************************/
	public function settings(\Silex\Application $app,Request $request){
        $expiration = $app['orm.em']->getRepository('Entity\Options')->findOneBy( array('input'=>'expiration') );
        $maxlicenses = $app['orm.em']->getRepository('Entity\Options')->findOneBy( array('input'=>'maxlicenses') );
        return $app['twig']->render('setting-time.html.twig', array(
            'expiration' => empty( $expiration )? 0 : $expiration->getVal(),
            'maxlicenses' => empty( $maxlicenses )? 0 : $maxlicenses->getVal(),
        ) );
	}
    public function save(\Silex\Application $app,Request $request){
        ///$expiration = $request->get('expiration');
        $maxlicenses = $request->get('maxlicenses');
        $r = 0;

        /*if(!empty($expiration) ){
            $c = $app['orm.em']->getRepository('Entity\Options')->findOneBy( array('input'=>'expiration') );
            if( empty($c) ){
                $o = new \Entity\Options;
                $o->setInput('expiration');
                $o->setVal( $expiration );
                $app['orm.em']->persist($o);
                $app['orm.em']->flush();
                $r = 1;
            }else{
                $q = $app["orm.em"]->createQuery("update Entity\Options o set o.val='".$expiration."' where o.input='expiration'");
			    $rs = $q->execute();
               $r = 1;
            }
        }*/
        
        if(!empty($maxlicenses)){
            $c = $app['orm.em']->getRepository('Entity\Options')->findOneBy( array('input'=>'maxlicenses') );
            if( empty($c) ){
                $o = new \Entity\Options;
                $o->setInput('maxlicenses');
                $o->setVal( $maxlicenses );
                $app['orm.em']->persist($o);
                $app['orm.em']->flush();
                $r = 1; 
            }else{
                $q = $app["orm.em"]->createQuery("update Entity\Options o set o.val='".$maxlicenses."' where o.input='maxlicenses'");
			    $rs = $q->execute();
                $r = 1;
            }
        }
        return json_encode( array('success'=>$r) );
    }
/**************************************************************************************/    
}
?>