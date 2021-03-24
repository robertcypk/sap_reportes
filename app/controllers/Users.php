<?php
namespace Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Users
{
    /**********************************************************************************************/
    public function index(\Silex\Application $app, Request $request)
    {
        $users = $app['orm.em']->getRepository("Entity\Usuarios")->findBy(array(), array('dateregister'=>'DESC'));
        $array = array();
        if (!empty($users)) {
            foreach ($users as $users) {
                $array[] = [
                    'idusr' => $users->getIdusr(),
                    'name' => $users->getName(),
                    'lastname' => $users->getLastname(),
                    'region' => $users->getIdregion(),
                    'country' => $users->getCountry()
                ];
            }
        }
        return $app['twig']->render('users.html.twig', array('users'=>$array));
    }
    public function pregister(\Silex\Application $app, Request $request)
    {
        return $app['twig']->render('register.html.twig', array());
    }
    public function form(\Silex\Application $app, Request $request)
    {
        return $app['twig']->render('usersform.html.twig', array());
    }
    public function show(\Silex\Application $app, Request $request)
    {
        $id = $request->get('id');
        $check = $app["orm.em"]->getRepository("Entity\Usuarios")->findOneBy(array('idusr'=>$id));
        if (!empty($check)) {
            return $app['twig']->render(
                'user_form_edit.html.twig',
                array(
                'name'=>    $check->getName(),
                'lastname' => $check->getLastname(),
                'idusr' => $check->getIdusr(),
                'region' => $check->getIdregion(),
                'country' => $check->getCountry(),
                'rol' => $check->getRol(),
                'email' => $check->getUsuario()
                )
            );
        } else {
            return $app->redirect($app["url_generator"]->generate("users"));
        }
    }
    public function save(\Silex\Application $app, Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $repeatpassword = $request->get('confirmpassword');
        $rol = empty($request->get('rol'))?'ROLE_COMPETITOR':$request->get('rol');
        //$region = $request->get('region');
        //$name = $request->get('username');
        //$lastname = $request->get('lastname');
        //$country = $request->get('country');
        //registro
        
        $user = new \Entity\Usuarios;
        $user->setName('User');
        $user->setLastname('-');
        $user->setIdregion('');
        $user->setCountry('');
        $user->setRol($rol);
        $user->setUsuario($email);
        $user->setPassword(\Web\EncodePwd::regencodepass($password));
        $user->setDateregister(time());
        $app["orm.em"]->persist($user);
        $app["orm.em"]->flush();
        
        return json_encode(array('success'=>1,
            'type'=>'',
            'msg'=>'<strong> Welcome. </ strong> Your email is now registered'
            ));
/* 
        $type = $request->get('type');
        
        if ($type=='new') { */
            /* $check_im = $app['orm.em']->getRepository('Entity\Importuser')->findOneBy(array('emails' => $email ));
            if (empty($check_im)) {
                return json_encode(array('success'=>4,
                    'type'=>$type,
                    'msg'=>'Your email is not registered, contact'
                    ));
            } */
            /* $check = $app["orm.em"]->getRepository("Entity\Usuarios")->findBy(array('usuario'=>$email));
            if (!empty($check)) {
                return json_encode(array('success'=>3,
                    'type'=>$type,
                    'msg'=>'You are already registered, check your confirmation email'
                    ));
            }
            
            if (empty($email) and empty($password) and empty($rol)) {
                return json_encode(array('success'=>0,
                    'type'=>$type,
                    'msg'=> 'correctly enter requested data'
                    ));
            } else {
                if ($password == $repeatpassword) { */
                    /**/
                    /* $name = $check_im->getFirstname().' '.$check_im->getLastname();
                    $subject = "HEROES DE ARUBA - REGISTRO";
                    $template = $app['twig']->render('confirmation.html.twig', array('name' => $name,'email' => $email,'password' => $password));
                    $app['mail']->addAddress($email, '');
                    //$app['mail']->addReplyTo('', '');
                    $app['mail']->isHTML(true);
                    $app['mail']->Subject = $subject;
                    $app['mail']->Body    = $template;
                    $app['mail']->AltBody = 'Copyright 2017 HEROES DE ARUBA';

                    if (!$app['mail']->send()) {
                        return json_encode(array('success'=>0,
                            'type'=>$type,
                            'msg'=>$app['mail']->ErrorInfo
                            ));
                    } else {
                        
                    } */
                    /**/
                /* } else {
                    return json_encode(array('success'=>2,
                    'type'=>$type,
                    'msg'=>'Your passwords must be the same to register'
                    ));
                }
            }
        } else { */
            /*Update user */
            /* return json_encode(array('success'=>0,
                'type'=>$type,
                'msg'=> 'correctly enter requested data'
                )); */
            /**/
       // }
    }
    public function delete(\Silex\Application $app, Request $request)
    {
        $id = $request->get('id');
        $repo = $app['orm.em']->getRepository("Entity\Usuarios")->findOneBy(array('idusr'=>$id ));
        if (!empty($repo)) {
            $app['orm.em']->remove($repo);
            $app['orm.em']->flush();
            return json_encode(array('success'=>1));
        } else {
            return json_encode(array('success'=>0));
        }
    }
    private function update($app, $request)
    {
        $name = $request->get('name');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        $region = $request->get('region');
        $password = $request->get('password');
        $repeatpassword = $request->get('repeatpassword');
        $country = $request->get('country');
        $rol = $request->get('rol');

        $id = $request->get('id');

        $type = $request->get('type');
        //user update requestasd
        if (empty($password)) {
            $q = $app["orm.em"]->createQuery("update Entity\Usuarios p set p.name='".$name."',p.lastname='".$lastname."',p.usuario='".$email."',p.rol='".$rol."', p.idregion='".$region."',p.country='".$country."' where p.idusr='".$id."'");
            $rs = $q->execute();
            return json_encode(array('success'=>1,'type'=>$type));
        } elseif ($password==$repeatpassword) {
            $password = \Web\EncodePwd::encode($password);
            $q = $app["orm.em"]->createQuery("update Entity\Usuarios p set p.name='".$name."',p.lastname='".$lastname."',p.password='".$password."',p.usuario='".$email."',p.rol='".$rol."',p.idregion='".$region."',p.country='".$country."' where p.idusr='".$id."'");
            $rs = $q->execute();
            return json_encode(array('success'=>1,'type'=>$type));
        } else {
            return json_encode(array('success'=>0,'type'=>$type));
        }
    }
    public function viewusernam($app)
    {
        $id = \Web\Users::utoken($app);
        if (!empty($id)) {
            if ($id->getRol()==='ROLE_ADMIN') {
                return $id->getName();
            } else {
                $check = $app["orm.em"]->getRepository("Entity\Importuser")->findOneBy(array('emails'=>$id->getUsuario()));
                return $check->getFirstname().' '.$check->getLastname();
            }
        } else {
            return '';
        }
    }
    public function getavataru($app)
    {
        $check = \Web\Users::utoken($app);
        $ruta = str_replace('app/controllers', '', __DIR__).'avatar';
        if (!empty($check->getAvatar())) {
            // if (!empty($check->getAvatar())){
            return 'avatar/'.$check->getAvatar();
            // }else {
                 // return '/img/default-avatar.jpg';
                // }
        } else {
            return 'img/default-avatar.jpg';
        }
    }
    public function getcoveru($app)
    {
        $check = \Web\Users::utoken($app);
        $ruta = str_replace('app/controllers', '', __DIR__).'fondo';
        if (!empty($check->getFondo())) {
            return 'fondo/'.$check->getFondo();
        } else {
            return 'img/default-cover.jpg';
        }
    }
    public function utoken($app)
    {
        $token = $app['security.token_storage']->getToken();
        $user = $token->getUser();
        $id = $user->getUsername();
        $check = new \stdClass();
        $check = $app["orm.em"]->getRepository("Entity\Usuarios")->findOneBy(array('usuario'=>$id));
        return $check;
    }
    /**************************************************************************************/
}
