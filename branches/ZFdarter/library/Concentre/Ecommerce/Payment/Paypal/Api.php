<?php 

/**
 * Abstract Class for Paypal API Core Methods
 *
 * This is an abstract class that contains 6 important methods that 
 * are used by all the Operations classes.
 * 
 * @abstract 
 * @author Israel Ekpo <perfectvista@users.sourceforge.net>
 * @copyright Copyright 2007, Israel Ekpo
 * @license http://phppaypalpro.sourceforge.net/LICENSE.txt BSD License
 * @package PaypalBase
 */
abstract class PaypalAPI
{
    /**
     * Operation Status Registration
     *
     * This methods sets the lastOperationStatus attribute in the PaypalBase class.
     * If the last operation was a success, this attribute is set to true, otherwise
     * it will be set to false.
     * 
     * @access private
     * @param bool $status
     */
    protected function registerLastOperationStatus($status)
    {
        PayPalBase::setLastOperationStatus($status);
    }
    
    /**
     * API Response Registration
     *
     * This method registers the response recieved from the Paypal Webservice.
     * As long as there were no errors it will be set. If it returns only one value
     * then it may be an integer, float or a string. However it is returning 
     * multiple values then it may be an associative array or an object.
     * 
     * @access private
     * @param mixed $APIResponse
     */
    protected function registerAPIResponse($APIResponse)
    {
        PayPalBase::setApiResponse($APIResponse);
    }
    
    /**
     * API Exception Registration
     * 
     * This method registers any exception that occurs as a result of a soapFault
     * being thrown. If a soapFault object was throw while the Operations object
     * was calling the execute method, then this method will be invoked instead
     * of the registerAPIResponse() method.
     * 
     * @access private
     * @param SoapFault $APIException
     */
    protected function registerAPIException($APIException)
    {
        PayPalBase::setAPISoapFault($APIException);
    }
    
    /**
     * Was the Operation Successful
     * 
     * This method tells us whether or not the last operation was a success
     * 
     * @access public
     * @return bool
     */
    public function success()
    {
        return PaypalBase::getOperationStatus();
    }
    
    /**
     * Returns the API Response
     *
     * The response from the Paypal Webservice can be accessed from this method
     * 
     * @access public
     * @return mixed
     */
    public function getAPIResponse()
    {
    	return PaypalBase::getAPIResponse();
    }
    
    /**
     * Returns any SoapFault thrown
     *
     * Any exception that is thrown can be accessed from this method
     * 
     * @access public
     * @return SoapFault
     */
    public function getAPIException()
    {
    	return PaypalBase::getAPIException();
    }
}

?>