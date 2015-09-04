<?php
require_once('bootstrap.php');
R::setup( 'sqlite:'.ROOT_DIR.'/data/raspi.sqlite' );

// create admin user
$item = R::dispense(USER_BEAN); 
$item->username = 'admin';
$item->password = hash('admin',  PASSWORD_DEFAULT);
$item->name = 'Sergiu';
$item->email = 'oprean@gmail.com';
$item->token = 'admin';
$item->token_expire = date('Y-m-d H:i:s', strtotime('+1 hour'));
R::store($item);
R::close();
?>