<?php
/** Zend_Log_Writer_Abstract */
require_once 'Zend/Log/Writer/Abstract.php';

/** Zend_Log_Formatter_Simple */
require_once 'Zend/Log/Formatter/Simple.php';

class Concentre_Log_Writer_Mail extends Zend_Log_Writer_Abstract
{
  /**
   * Mailer
   * @var Zend_Mail
   */
  private $_mail;
  
  private $_priorities = array(
  						Zend_Log::EMERG,
  						Zend_Log::ALERT,
  						Zend_Log::CRIT,
  						Zend_Log::ERR);
  /**
   * Class constructor
   *
   * @param Zend_Mail $mail   Mail instance
   */
  public function __construct($mail)
  { 
      $this->_mail = $mail;
      $this->_formatter = new Zend_Log_Formatter_Simple();
  
	  foreach ($this->_priorities as $_priority) {
		  $this->addFilter(new Zend_Log_Filter_Priority($_priority));
  	  }
  } 

  /**
   * Write a message to the log.
   *
   * @param  array  $event  event data
   * @return void
   */
  protected function _write($event)
  { 
 	
      $line = $this->_formatter->format($event);
      $this->_mail->setBodyText($line);
      $this->_mail->send();
  } 

}

?>