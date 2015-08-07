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
	

	public function login($username, $password) {
	
		if (self::validateUser($username, $password)) { //implement your own validation method against your db
			$arrRtn['user'] = 'Chuck Norris'; //Just return the user name for reference
			$arrRtn['token'] = bin2hex(openssl_random_pseudo_bytes(16)); //generate a random token
		
			$tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour'));//the expiration date will be in one hour from the current moment
		
			CUser::updateToken($username, $arr['token'], $tokenExpiration); //This function can update the token on the database and set the expiration date-time, implement your own
			return json_encode($arrRtn);
		}
		
		return false;
	}
	
	static function updateToken($token) {
		$user = R::find(USER_BEAN , ' token = ? ');
		return !empty($user);
	}
	
	static function validateToken($token) {
		$user = R::find(USER_BEAN , ' token = ? ');
		return !empty($user);
	}
	
	static function validateUser($username, $password) {
		$user = R::find(USER_BEAN , ' ( username = ? OR email = ? ) AND password = ? ', [$username, $username, $password]);
		return !empty($user);
	}
}

?>