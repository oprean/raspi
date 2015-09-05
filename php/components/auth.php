<?php

require_once (ROOT_DIR.'/php/Slim/Middleware.php');
class TokenAuth extends \Slim\Middleware {
	
	private $_public_uri = array(
		'/',
		'/login'
	);
	
    public function __construct() {}

    /**
     * Deny Access
     */
    public function deny_access() {
        $res = $this->app->response();
        $res->status(401);
    }

    /**
     * Check against the DB if the token is valid
     * 
     * @param string $token
     * @return bool
     */
    public function authenticate($token) {
        return User::validateToken($token);
    }

    /**
     * Call
     */
    public function call() {	
		if (!in_array($this->app->request->getResourceUri(),$this->_public_uri)) {
	        $authToken = $this->app->request->headers->get('Authorization');
	        if (!empty($authToken) && $this->authenticate($authToken)) {
	            User::keepTokenAlive($authToken);
	            $this->next->call();
	        } else {
				$this->deny_access();
	        }
		} else {
            $this->next->call();
		}
    }
}