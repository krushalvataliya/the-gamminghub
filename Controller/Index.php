<?php 
require_once 'Controller/Core/Action.php';

class Controller_Index extends Controller_Core_Action
{
	public function IndexAction()
	{	
		$this->getTemplete('index.phtml');
	}
	
	public function getAllGames()
	{
		try {
			$api = $this->getApi();
            $api->setUrl("http://localhost/gameslist/");
            $data = $api->get();
	        return $data['pageProps']['data']['ALLGamesList'];
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            die;
        }
	}

	public function getAllGames1()
	{
        $url = "http://localhost/gameslist/";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $jsonData = curl_exec($ch);
        if ($jsonData === false) {
            die('cURL Error: ' . curl_error($ch));
        }
        curl_close($ch);
        $data = json_decode($jsonData, true);
        return $data['pageProps']['data']['ALLGamesList'];
	}
}

?>