<?php

define('USER_BEAN', 'user');

class User {
	private $_bean;
	
	function __construct($id = null) {
		if (is_numeric($id)) {
			$this->_bean = R::load(USER_BEAN, $id);
		} else {
			$this->_bean = R::dispense(USER_BEAN);
		}
	}

	public static function login($username, $password) {
		$user = self::validateUser($username, $password); 
		if (!empty($user)) {
			$return['uid'] = $user->id;
			$return['token'] = bin2hex(openssl_random_pseudo_bytes(16));
			$tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
			User::updateToken($user->username, $return['token'], $tokenExpiration);
			
			return $return;
		}
		return false;
	}
	
	static function updateToken($username, $token, $tokenExpiration) {
		$user = R::findOne(USER_BEAN , ' username = ? ', array($username));
		if (!empty($user)) {
			$user->token = $token;
			$user->token_expire = $tokenExpiration;
			R::store($user);
			return true;			
		} else {
			return false;
		} 
	}
	
	static function tokenRemove($token) {
		$user = R::findOne(USER_BEAN , ' token = ? ', array($token));
		if (!empty($user)) {
			$user->token = null;
			R::store($user);
		}
	}
	
	static function keepTokenAlive($token) {
		$user = R::findOne(USER_BEAN , ' token = ? ', array($token));
		if (!empty($user)) {
			$user->token_expire = date('Y-m-d H:i:s', strtotime('+1 hour'));
			R::store($user);
		}
	}
	
	static function validateToken($token) {
		$user = R::findOne(USER_BEAN , ' token = ? ', array($token));
		return !empty($user);
	}
	
	static function validateUser($username, $password) {
		$user = R::findOne(USER_BEAN , ' username = ? OR email = ? ', array($username, $username));
		return (!empty($user) && md5($password) == $user->password)?$user:false;
	}
}

?>