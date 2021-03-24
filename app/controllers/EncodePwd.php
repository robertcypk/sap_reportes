<?php
namespace Web;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\HttpFoundation\Request;
class EncodePwd{
    //password generator
    public function encode(\Silex\Application $app, Request $request,$pwd){
        $encoder = new BCryptPasswordEncoder(13);
        $hash = $encoder->encodePassword($pwd, '');
        
        //print_r();

        return $hash;
    }
    public function regencodepass($pwd){
        $encoder = new BCryptPasswordEncoder(13);
        $hash = $encoder->encodePassword($pwd, '');
        return $hash;
    }
}
?>