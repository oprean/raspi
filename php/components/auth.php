<?php

require_once (ROOT_DIR.'/php/Slim/Middleware.php');
class TokenAuth extends \Slim\Middleware {
	
	private $_public_uri = array(
		//'/',
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
	        //Get the token sent from jquery
	        $tokenAuth = $this->app->request->headers->get('Authorization');
	 	        //Check if our token is valid
	        if ($this->authenticate($tokenAuth)) {
	            //Get the user and make it available for the controller
	            $usrObj = new User();
	            $usrObj->getByToken($tokenAuth);
	            $this->app->auth_user = $usrObj;
	            //Update token's expiration
	            User::keepTokenAlive($tokenAuth);
	            //Continue with execution
	            $this->next->call();
	        } else {
	        	$this->app->redirect('login');
	            //$this->deny_access();
	        }			
		} else {
            //Continue with execution
            $this->next->call();
		}
    }
}