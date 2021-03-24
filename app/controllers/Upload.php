<?php 
namespace Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
*
*/
class Upload
{
    public function index(\Silex\Application $app, Request $request)
    {
        return $app['twig']->render('upload.html.twig', array());
    }
}