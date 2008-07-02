<?php

/**
 * Website Payments Pro Operations Factory
 *
 * The purpose of this class is to provide a way of selecting any operation object
 * from just a single source. It also intializes the soapClient and soapHeaders that 
 * are going to be used for any of the operations.
 * 
 * @author Israel Ekpo <perfectvista@users.sourceforge.net>
 * @copyright Copyright 2007, Israel Ekpo
 * @license http://phppaypalpro.sourceforge.net/LICENSE.txt BSD License
 * @package PaypalBase
 */
final class WebsitePaymentsPro
{   
    /**
     * Prepares the System for an Operation call
     *
     * This is when the SoapClient and SoapHeader static objects are actually created.
     * 
     * @param string $Username The API user name
     * @param string $Password The password for the API call. Different from account password
     * @param string $Signature The signature for the 3-token authentication
     * @param string $Subject The person on whose behalf the operation is made
     * @uses PaypalRegistrar::registerSoapClient()
     * @uses PaypalRegistrar::registerSoapHeader()
     * @access public
     */
    public function prepare($Username, $Password, $Signature, $Subject='')
    {
       PayPalRegistrar::registerSoapClient();

       PayPalRegistrar::registerSoapHeader($Username, $Password, $Signature, $Subject);      
    }   
    
    /**
     * WebSite Payments Pro Operations Factory
     *
     * The name of the operation is passed to this method so that
     * it will return the right object to do the job. It is not case sensitive,
     * so you do not have to worry about the case of the letters when passing the 
     * operation name to the method.
     *  
     * @access public
     * @param string $operation This is case insensitive
     * @return mixed The Operation you wish to call
     */
    public function selectOperation($operation)
    {
        switch (strtolower(trim($operation)))
        {
            case 'dodirectpayment':
            {
                require_once('dodirectpayment.php');
                return new DoDirectPayment();
            }
                
            case 'setexpresscheckout':
            {
                require_once('setexpresscheckout.php');
                return new SetExpressCheckout();
            }
            
            case 'getexpresscheckoutdetails':
            {
                require_once('getexpresscheckoutdetails.php');
                return new GetExpressCheckoutDetails();
            }
            
            case 'doexpresscheckoutpayment':
            {
                require_once('doexpresscheckoutpayment.php');
                return new DoExpressCheckoutPayment();
            }
            
            case 'transactionsearch':
        	{
        		require_once('transactionsearch.php');
        		return new TransactionSearch();
        	}
        	
            case 'gettransactiondetails':
        	{
        		require_once('gettransactiondetails.php');
        		return new GetTransactionDetails();
        	}
        }
    }
}

?>