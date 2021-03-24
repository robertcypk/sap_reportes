<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible"  content="IE=edge">
        <meta name="viewport"               content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
        <meta name="description"            content="SAP Marketing Academy">
        <meta name="keywords"               content="SAP Marketing Academy">
        <meta name="robots"                 content="Index,Follow">
        <meta name="date"                   content="Febrero 15, 2018"/>
        <meta name="language"               content="es">
        <meta name="theme-color"            content="#000000">
        <title>SAP Marketing Academy</title>
        <link rel="shortcut icon" href="<?php echo base_url('public/img/')?>logo/logo_favicon.ico">
        <link rel="stylesheet"    href="<?php echo base_url('public/plugins/')?>toaster/toastr.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo base_url('public/plugins/')?>bootstrap-select/css/bootstrap-select.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo base_url('public/plugins/')?>bootstrap/css/bootstrap.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo base_url('public/plugins/')?>mdl/material.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo base_url('public/fonts/')?>font-awesome.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo base_url('public/fonts/')?>material-icons.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo base_url('public/fonts/')?>benton.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo base_url('public/css/')?>m-p.min.css?v=<?php echo time();?>">
        <link rel="stylesheet"    href="<?php echo base_url('public/css/')?>style.css?v=<?php echo time();?>">
    </head>
    <body>
        <div class="js-header">
            <div class="js-header--container">
                <div class="js-header--left">
                    <img class="logo-one" src="<?php echo base_url('public/img/')?>logo/logo_favicon.png">
                    <p>SAP Marketing Academy</p>
                </div>
            </div>
        </div>
        <section id="principal">
            <div class="js-fondo js-fondo--login"></div>
            <div class="js-container">
                <div class="js-home js-height js-flex">
                    <div class="js-contenido">
                        <p>Bienvenido al Portal de Certificados</p>
                        <h2>SAP Marketing Academy</h2>
                        <p>Gracias por su participaci&oacute;n. Recuerde que nuestros certificados son reconocidos globalmente y le dar&aacute;n una gran ventaja competitiva.</p>
                        <h3>Obtener certificado</h3>
                        <p>Ingrese su e-mail para acceder a su certificado:</p>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingrese su email" onkeyup="verificarDatos(event);">
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="ingresar()">Ingresar</button>
                    </div>
                </div>
            </div>
        </section>
        <script src="<?php echo base_url('public/js/')?>jquery-3.2.1.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('public/js/')?>jquery-1.11.2.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('public/js/')?>bootstrap/js/bootstrap.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('public/plugins/')?>bootstrap-select/js/bootstrap-select.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('public/plugins/')?>bootstrap-select/js/i18n/defaults-es_ES.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('public/plugins/')?>mdl/material.min.js?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('public/plugins/')?>toaster/toastr.js?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('public/js/')?>Utils.js?v=<?php echo time();?>"></script>
        <script src="<?php echo base_url('public/js/')?>login.js?v=<?php echo time();?>"></script>
        <script type="text/javascript">
            var URLactual = window.location;
            /*if(URLactual['href'] != 'http://www.sap-latam.com/SAP_Marketing_Academy_2018/es/'){
                location.href = 'http://www.sap-latam.com/SAP_Marketing_Academy_2018/es/';
            }*/
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
                $('select').selectpicker('mobile');
            } else {
                $('select').selectpicker();
            }
        </script>
    </body>
</html>