<?php

class Concentre_Controller_Action_Auth extends Concentre_Controller_Action_Abstract {



    public function indexAction() {
        $this->_forward('login');
    }
    
	public function _login($username,$password) {

        $authAdapter = new Zend_Auth_Adapter_DbTable(
        					Zend_Db_Table::getDefaultAdapter(),'users','username','password',
        					'MD5(?) AND status="ENABLED"');       

        // Set the input credential values to authenticate against
        $authAdapter->setIdentity($username);
        $authAdapter->setCredential($password);
		

        // do the authentication
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);

        $request = $this->getRequest();

        if ($result->isValid()) {
                // success: store database row to auth's storage
                // system. (Not the password though!)
                $data = $authAdapter->getResultRowObject(null,'password');
                $auth->getStorage()->write($data);

               return true;
        } else {
               return false;
        }		
	}
	
	public function loginAction() {
        $r = $this->getRequest();
        if ($r->isPost()) {
        	$f = new Zend_Filter_StripTags();
			$username = $f->filter($this->_request->getPost('username'));
        	$password = $f->filter($this->_request->getPost('password'));
		
        	if (empty($username)) {
				$this->view->message = '"Username is required"';
        	} else {
        		if ($this->_login($username, $password)) {
					$redirectNS = new Zend_Session_Namespace('redirect');
               		$this->_redirect($redirectNS->fromURL);        			
        		} else {
        			$this->view->message = '"Invalid credentials"';
        		}
        	}
        }		
	}

	public function _logout() {
		Zend_Auth::getInstance()->clearIdentity();
		
	}

	public function logoutAction() {
		$this->_logout();
	}

	public function forbiddenAction() {
	}


	public function looseAction() {
		$r = $this->getRequest();	
		if ($r->isPost()) {
		
		}
	}
}

?>