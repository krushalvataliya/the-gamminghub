<?php 
require_once 'Controller/Core/Action.php';

class Controller_Termsofuse extends Controller_Core_Action
{

	public function IndexAction()
	{	
		$this->getTemplete('termsofuse/index.phtml');
	}

}

?>