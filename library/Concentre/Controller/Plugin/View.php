<?php
class Concentre_Controller_Plugin_View extends Zend_Controller_Plugin_Abstract 
{ 
    protected $_auth;
 
    protected $_viewRenderer;
 
    public function dispatchLoopStartup( Zend_Controller_Request_Abstract $request)
    {
        $this->_viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $this->_viewRenderer->initView();
        
 	$this->_viewRenderer->view->addHelperPath('../library/Concentre/View/Helper/','Concentre_View_Helper_');
	$this->_viewRenderer->view->setEncoding('utf-8');

        $this->_viewRenderer->view->baseUrl = $request->getBaseUrl();
        $this->_viewRenderer->view->module = $request->getModuleName();
        $this->_viewRenderer->view->controller = $request->getControllerName();
        $this->_viewRenderer->view->action = $request->getActionName();
 
   	$locale = new Zend_Locale(); 

	$langpath = MODULES_DIR.'/'. $request->getModuleName() . '/languages';
        //Zend_Translate::setCache($cache); 

	$translate = Zend_Registry::get('Zend_Translate');       
  	$translate->addTranslation($langpath, 'auto', array('scan' => Zend_Translate::LOCALE_FILENAME)); 
 		 		
 	$lang = $request->getParam('lang', $locale->getLanguage());
 		
        if (!$translate->isAvailable( $lang )) { 
            $locale->setLocale('en'); 
            $lang = 'en';
        } 
              
       	$translate->setLocale($lang); 
        setcookie('lang', $lang, null, '/'); 
         
        Zend_Registry::set('locale', $lang); 
        setlocale(LC_ALL, $locale );
        
        Zend_Form::setDefaultTranslator($translate);
        Zend_Registry::set('Zend_Translate', $translate); 
        Zend_Locale_Format::setOptions(array('locale' =>  $locale ));

	$this->_viewRenderer->view->lang = $lang;
	$this->_viewRenderer->view->langs = array();

        $scriptpath = MODULES_DIR.'/'.$request->getModuleName().'/views/scripts';
	$helperpath = MODULES_DIR.'/'.$request->getModuleName().'/views/helpers';

	$this->_viewRenderer->view->addScriptPath( $scriptpath.'/'.$lang.'/' );
	$this->_viewRenderer->view->addScriptPath( $scriptpath.'/en/'  );
        $this->_viewRenderer->view->addScriptPath( $scriptpath.'/' );


        $this->_viewRenderer->view->addHelperPath( $helperpath, ucfirst($request->getModuleName()) . '_View_Helper_' );
       
        $this->_auth = Zend_Auth::getInstance();
        $this->_viewRenderer->view->hasIdentity = false;
        if ( $this->_auth->hasIdentity() ) {
            $this->_viewRenderer->view->hasIdentity = true;
            $this->_viewRenderer->view->Identity = $this->_auth->getIdentity();
        }

	/*
        $timezone = new DateTimeZone('Europe/Madrid');
        $datetime = new DateTime('now', $timezone);
        $offset = strftime('+%H:%M', $timezone->getOffset($datetime));
  	date_default_timezone_set($timezone);
	*/

       	/*
        $currency = new Zend_Currency($locale);
        Zend_Registry::set('Zend_Currency', $currency);
	*/
		
    } 
}

?>
