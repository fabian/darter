<?php

class Project_View_Helper_Tree
{
    private $_view;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function Tree($classes)
    {
	$str='';
	foreach($classes->getChildren() as $child) {
		$str.='<li>';
		if($child->getData()->isUserDefined()) {
			$str.='<a href="class/'.$child.'">'.$child.'</a>';
		} else {
			$str.=$child;
		}	

		if(count($child->getChildren()) > 0) {
			$str.='<ul>'; 
			$str.= $this->Tree($child);
			$str.='</ul>';
		}

		$str.='</li>';
	
	}

	return $str;
    }

}
