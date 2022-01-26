<?php

session_start();
require __DIR__ . '/vendor/autoload.php';

$gClient = new Google\Client();
$gClient->setClientId("xxxxxxxxxxxxxxxxxxxxxxxxxx.apps.googleusercontent.com");
$gClient->setClientSecret("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");

$gClient->setRedirectUri('http://localhost/Autenticacao_google_login/index.php');

$gClient->addScope('email');

if(!isset($_GET['code'])){
    echo '<a href="'.$gClient->createAuthUrl().'">Logar com sua conta google</a>';
}else{
    $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);

    if(!isset($token['error'])){
        $gClient->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google\Service\Oauth2($gClient);

        $data = $google_service->userinfo->get();

        print_r($data);
    }
}

?>