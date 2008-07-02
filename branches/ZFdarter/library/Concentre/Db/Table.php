<?php 

class Concentre_Db_Table extends Zend_Db_Table {

function  toForm() {

/*$formConfig = array(
	'action' => '',
	'method' => 'post',
	'elements' => array()
);
*/

$form = new Zend_Form();

// get table metadata

$info = $this->info();
$metadata = $info['metadata'];

// iterate through each column

foreach ($metadata as $columnName => $columnDetails)
{
	// ID columns are hidden -- don't want those being edited!

	if ($columnDetails['PRIMARY'])
	{
		$formElement = new Zend_Form_Element_Hidden( $columnName );
		$form->addElement($formElement);
		continue;
	}

	// boolean columns:
	// i usually TINYINT(1) with an 'is_' column name.
	// you may use ENUM('Y', 'N').
	// either way I like the is_ convention.

	if (preg_match('/^is_/', $columnName))
	{
		$formElement = new Zend_Form_Element_Checkbox($columnName);
		$form->addElement($formElement);
		
	}

	// enum columns:
	// the options are included in the data type so we can't 
	// switch against it. 

	if (preg_match('/^enum/i', $columnDetails['DATA_TYPE']))
	{
		// need to extract options
		
		preg_match_all('/\'(.*?)\'/', $columnDetails['DATA_TYPE'], $matches);

		$options = array();
		
		
		foreach ($matches[1] as $match)
		{
			$options[$match] = $match;
		}
		
		$formElement = new Zend_Form_Element_Select($columnName);
		$formElement->setMultiOptions($options);
		
		$form->addElement($formElement);
		
		continue;
	}

	// now we can look purely at data types to build the rest of our form
	print_r($columnDetails);

	switch ($columnDetails['DATA_TYPE'])
	{
		// simple strings
		// maximum length obviously determined
		// by the column's length
		
		case 'varchar':
		case 'char':
			$length = $columnDetails['LENGTH'];
			
			$formElement = new Zend_Form_Element_Text($columnName);
			$formElement->setLabel($columnName);

			/*
			$formConfig['elements'][$columnName] = array(
				'text'
			
				array(
					'validators' => array(
						'stringLength',
						false,
						array(0, $length)
					)
				)
				
			);*/
			
			break;

		case 'text':
			$formElement = new Zend_Form_Element_Text($columnName);
			$formElement->setLabel($columnName);
	
			break;

		// floats and ints will just be text boxes with int/float
		// validators.  a class can be added to the element to
		// make it a little narrower.

		case 'int':
		case 'bigint':
		case 'mediumint':
		case 'smallint':
		case 'tinyint':
			$formElement = new Zend_Form_Element_Text($columnName);
			$formElement->setLabel($columnName);
			
			
				/*,
				array(
					'validators' => array(
						'int',
						false
					)
				)
			);*/
			
			break;

		case 'float':
		case 'decimal':
		case 'double':
			$formElement = new Zend_Form_Element_Text($columnName);
			$formElement->setLabel($columnName);

	
				/*,
				array(
					'validators' => array(
						'float',
						false
					)
				)
			);*/
			break;

		// ... other column types in here? ... 

		default:
			break;
	}
	
	if (!$columnDetails['NULLABLE']) {
		  $formElement->setRequired(true)
          			  ->addValidator('NotEmpty', true);
	}
	
	$form->addElement($formElement);
			
}


$formElement = new Zend_Form_Element_Submit('submit');
$form->addElement($formElement);

return $form;
}


}

?>
