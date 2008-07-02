<?php

/**
 * Template for all Operations Objects
 *
 * This is the template for all the classes that are used for each operation.
 * Each and every one of them must have these two methods. The other methods will
 * be inherited from the abstract PaypalAPI class.
 * 
 * @author Israel Ekpo <perfectvista@users.sourceforge.net>
 * @copyright Copyright 2007, Israel Ekpo
 * @license http://phppaypalpro.sourceforge.net/LICENSE.txt BSD License
 * @package PaypalBase
 */
interface Payment_Paypal_Operation_Interface
{   
    /**
     * Calls the Paypal Web Service
     *
     * This method prepares the final message for the operation,
     * puts it in the right format and then invokes the __soapCall method
     * from the static soapClient. The name of the operation, the message, and the 
     * input headers are passed to the __soapCall() method
     */
    public function execute();
    
    /**
     * Tells us if the Operation was Successful
     *
     * If the operation was successful, this method will return true,
     * otherwise it will return false
     * 
     * @return bool
     */
    public function success(); 
}

?>