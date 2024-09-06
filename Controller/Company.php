<?php 
require_once 'Controller/Core/Action.php';

class Controller_Company extends Controller_Core_Action
{

	public function IndexAction()
	{	
		$this->getTemplete('company/index.phtml');
	}

}

?>