<?php

/* run this from console*/

require_once('bootstrap.php');
R::setup( 'sqlite:'.ROOT_DIR.'/data/raspi.sqlite' );

// create admin user
$item = R::dispense(USER_BEAN); 
$item->username = 'admin';
$item->password = md5('admin');
$item->name = 'Sergiu';
$item->email = 'oprean@gmail.com';
$item->token = null;
$item->token_expire = date('Y-m-d H:i:s');
R::store($item);
R::close();
?>