<?php

        define('LIB_DIR','../library');
        define('APP_DIR','../application');
        define('MODULES_DIR',APP_DIR.'/modules');
        define('MODELS_DIR',APP_DIR.'/models');
        define('LAYOUTS_DIR',APP_DIR.'/layouts');
        define('LANGUAGES_DIR',APP_DIR.'/languages');
        define('WWW_DIR',APP_DIR.'/www');

        //--- autpload
        set_include_path(
                ".".PATH_SEPARATOR.
                "..".PATH_SEPARATOR.
                MODELS_DIR.PATH_SEPARATOR.
                LIB_DIR.PATH_SEPARATOR.
                get_include_path()
                );

        require_once 'Zend/Loader.php';
        spl_autoload_register(array('Zend_Loader', 'autoload'));

		
        try {

				//-- translate --        
        		$translate = new Zend_Translate('array', LANGUAGES_DIR, 'auto',  array('scan' => Zend_Translate::LOCALE_FILENAME)); 
	 	 		Zend_Registry::set('Zend_Translate', $translate); 

        		$config = new Zend_Config_Xml("../application/config.xml", 'production');
				Zend_Registry::set('config', $config);
				
        		//--- force ssl redirect --- 
        		if ($config->global->ssl=='true' && $_SERVER['SERVER_PORT'] != 443 && $_SERVER['HTTPS'] != 'on' ) {
					define('SITE_URL','https://' . $_SERVER['HTTP_HOST']);
					header('location: '. SITE_URL . $_SERVER['REQUEST_URI']);
        		}

        		//--- authentification ---
        		$auth = Zend_Auth::getInstance();

        		//---
        		$request = new Zend_Controller_Request_Http();
       			$response = new Zend_Controller_Response_Http();
        		$response->setHeader('Content-type','text/html; charset=utf-8');

        		//--- cache  ---
        		$cache = Zend_Cache::factory('Core', 'File', $config->cache->frontend->toArray(), $config->cache->backend->toArray());
        		Zend_Registry::set('cache', $cache);
				Zend_Translate::setCache($cache);

        		//--- logger ---
        		$logger = new Zend_Log();
 				Zend_Registry::set('logger', $logger);

 				$logger->addWriter(new Zend_Log_Writer_Stream($config->logger->stream->filename));	


                //--- mail ---
                if ($config->mail)
                {
                	$transport = new Zend_Mail_Transport_Smtp($config->mail->host, $config->mail->params->toArray());
                	Zend_Mail::setDefaultTransport($transport);
				}


           		//--- db ---
           		if ($config->database) 
				{
      	        	$db = Zend_Db::factory($config->database->adapter, $config->database->params->toArray() );
        	    	$db->getConnection();

             		//--- zend_db_table ---
                	Zend_Db_Table::setDefaultAdapter($db);
                               
       				$logger->addWriter(new Zend_Log_Writer_Db($db, $config->logger->database->table,  $config->logger->database->params->toArray()) );
	          
	          		$db->query("SET NAMES 'utf8'");

                	$acl = Concentre_Acl::getInstance($db);
	                //--- timezone offset handling ---

    	            $db->query("SET @@session.time_zone = '+01:00'");
				}


                //--- view layout adapters ---
                Zend_Layout::startMvc(array('layoutPath' => APP_DIR.'/layouts'));

                //--- front controller initialization ---
                $controller = Zend_Controller_Front::getInstance();
                
                //--- register modules ---
                $dirs = new DirectoryIterator( MODULES_DIR );
                foreach ($dirs as $dir) {
                        if ($dir->isDir() && !in_array($dir,  array('.','..')) ) {
                                $controller->addControllerDirectory(MODULES_DIR. '/' . $dir->getFilename() .'/controllers', $dir->getFilename());
                        }
                }

                //--- routes ----
                $router = $controller->getRouter();
                $routes = new Zend_Config_Xml("../application/routes.xml", 'routes');
                
                foreach ($routes->route as $route) {
					$router->addRoute($route->name,  new Zend_Controller_Router_Route($route->url, $route->params->toArray() ));
                }

                $controller->registerPlugin(new Concentre_Controller_Plugin_View());
                //$controller->registerPlugin(new Concentre_Controller_Plugin_Auth($auth,$acl));
                                
                
                $controller->dispatch($request,$response);



        } catch (Exception  $exception) {

				 $view = new Zend_View();
                 $view->setScriptPath( MODULES_DIR .'/default/views/scripts/error/');
			
				 $view->exception = $exception;
            
				 switch (get_class($exception)) {
        			case Zend_Config_Exception:
        				$view->title = "configuration_error";
        				break;
        			default:
        		  		$view->title = "general_error";
        				break;
        		}
        	
				/*
                $logger->log($exception->getMessage(), Zend_Log::EMERG);
			    
                /*
                $mail = new Zend_Mail('UTF-8');
                $mail->setBodyHtml( $view->render('error.phtml') );
                $mail->setFrom($config->mail->from);
                $mail->addTo($config->mail->to);
                $mail->setSubject($view->title);
            	
            	try { @$mail->send(); } catch (Exception $exception) {}
   				*/         	
   
	           	
	           	
			    $layout = new Zend_Layout();
			    $layout->setLayoutPath(APP_DIR.'/layouts');
				$layout->content = $view->render('error.phtml');
      
          		echo $layout->render();
          		
        }
?>
