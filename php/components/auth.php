<?php

require_once (ROOT_DIR.'/php/Slim/Middleware.php');
class TokenAuth extends \Slim\Middleware {
	
	private $_public_uri = array(
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
    	if (strpos(IP_WHITE_LIST, $_SERVER['REMOTE_ADDR']) !== false) {
            $this->next->call();    		
    	} else if (!in_array($this->app->request->getResourceUri(),$this->_public_uri)) {
	        $tokenAuth = $this->app->request->headers->get('Authorization');
	        if ($this->authenticate($tokenAuth)) {
	            $usrObj = new User();
	            $usrObj->getByToken($tokenAuth);
	            $this->app->auth_user = $usrObj;
	            User::keepTokenAlive($tokenAuth);
	            $this->next->call();
	        } else {
	        	$this->app->redirect('login');
	        }			
		} else {
            $this->next->call();
		}
    }
}