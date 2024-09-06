<?php 
require_once 'Controller/Core/Action.php';

class Controller_Privacy extends Controller_Core_Action
{

	public function IndexAction()
	{	
		$this->getTemplete('privacy/index.phtml');
	}

}

?>