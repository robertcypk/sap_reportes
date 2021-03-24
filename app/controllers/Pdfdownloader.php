<?php
namespace Web;

use Symfony\Component\HttpFoundation\Request;
use setasign\Fpdi\Fpdi;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Pdfdownloader{
    function make(\Silex\Application $app, Request $request){
        $orm = $app['orm.em'];
        
        if ( empty($app['session']->get('user')) ) {
            return $app->redirect('/');
        }
        // params

        // $user = preg_replace("/[^0-9]+/", "", $request->get('user'));
        // $user = preg_replace("/[^@\s]*@[^@\s]*\.[^@\s]*/", " ", $request->get('user'));
        // $cert = preg_replace("/[^a-zA-Z0-9]+/", " ", $request->get('cert'));
        $user = $request->get('user');
        $cert = preg_replace("/[^0-9]+/", "", $request->get('cert'));

        $u =  $orm->getRepository('Entity\Importuser')->findOneBy(array('Email'=>$user, 'Idreport'=>$cert,));
        $r =  $orm->getRepository('Entity\Reports')->findOneBy(array('id'=>$cert));
        
        // make a pdf
        // create handle for new PDF document
        $idioma = ($r->getLang() == '1')? 'esp' : 'ptl';
		$filename= dirname(dirname(__DIR__))."/public/templates/certificado_".$idioma.".pdf";
        // initiate FPDI
        $pdf = new Fpdi();
        $pdf->AddPage('L');
        $pdf->setSourceFile($filename);
        $tplIdx = $pdf->ImportPage(1);
        // $size = $pdf->useTemplate($tplIdx, 10, 10, 190);
        $size = $pdf->useTemplate($tplIdx, 0, 0, 300);
        $pdf->SetDrawColor(216);
        // $pdf->Rect(5, 5, 190, $size['height'], 'D');
        $pdf->Rect(0, 0, 300, $size['height'], 'D');

        $templateId = $pdf->beginTemplate();
        
        // nombre del particiante
        $pdf->setFont('Arial');
        $pdf->setFillColor(240,171,0); 
        $pdf->SetY(98);
        $pdf->SetX(21);
        $pdf->SetFontSize(29);
        $pdf->Cell(0,10,utf8_decode(ucwords($u->getNombre()).' '.ucwords($u->getApellido())),0,300,'L',0);
        // Mension
        // $pdf->setFont('Arial');
        $pdf->setFillColor(255,255,255); 
        
        
        
        $pdf->SetTextColor(240,171,0);
        if(strlen($r->getTitle()) > 55){
            $pdf->SetY(132);
            $pdf->SetX(21);
            $pdf->SetFontSize(21);
            $pdf->MultiCell(0,10,utf8_decode($r->getTitle()),0,150,'L',0);
        }else {
            $pdf->SetY(140);
            $pdf->SetX(21);
            $pdf->SetFontSize(29);
            $pdf->Cell(0,10,utf8_decode($r->getTitle()),0,150,'L',0);
        }
        
        // fecha de emision
        // $pdf->SetFont('Arial');
        $pdf->SetFillColor(255,255,255);
        $pdf->setY(155);
        $pdf->SetX(21);
        $pdf->SetFontSize(12);
        $pdf->SetTextColor(110,110,110);
        $pdf->Cell(0,10, date('M Y', strtotime($r->getDate())),0,150,'L',1);

        // $pdf->text_input_as_HTML = true;
        
        $pdf->endTemplate();
        $pdf->useTemplate($templateId);
        // $pdf->WriteText( 5, 5, "tectíonn de canciopn");

        $filename = $user.'-certificado.pdf';
        $dir = dirname(__DIR__)."/../public/certificados/";
        // $pdf->Output($dir.$filename,'F');
        $pdf->Output($filename,'D');

        // Descargar
        return new BinaryFileResponse($filename);
    }
}