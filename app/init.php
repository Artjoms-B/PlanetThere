<?php
session_start();

$config= require_once __DIR__ . '/../config/config.php';
if(!defined('BASE_URL')){
    define('BASE_URL', $config['app']['base_url']);
}

require_once __DIR__ . '/../config/database.php';

spl_autoload_register(function($class) {
    $paths=[
        __DIR__ . '/controllers/' . $class ,
        __DIR__ . '/models/' . $class ,
        __DIR__ . '/core/' . $class ,

    ];
    foreach($paths as $path){
        if(file_exists($path)){
            require_once $path;
            return;
        }
    }
});

if (isset($_SESSION['user']['UserID'])) {
    $uid = (int)$_SESSION['user']['UserID'];

    if (
        !isset($_SESSION['settings_user_id']) ||
        (int)$_SESSION['settings_user_id'] !== $uid
    ) {
        $userModel = new User();
        $settings = $userModel->getSettingsByUser($uid);

        $_SESSION['settings'] = $settings ?: [];
        $_SESSION['settings_user_id'] = $uid;
    }
}

?>