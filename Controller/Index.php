<?php 
require_once 'Controller/Core/Action.php';

class Controller_Index extends Controller_Core_Action
{
	protected $gamesPerPage = 20;
	protected $totalGames;
	protected $totalPages;
	protected $currentPage;

	public function IndexAction()
	{	
		$this->getTemplete('index.phtml');
	}

	public function getAllGames()
	{
	    try {
	        $jsonFilePath = Kv::getApiFile();
	        if (!file_exists($jsonFilePath)) {
	            throw new Exception('JSON file not found.');
	        }
	        $jsonData = file_get_contents($jsonFilePath);

	        $data = json_decode($jsonData, true);
	        if (json_last_error() !== JSON_ERROR_NONE) {
	            throw new Exception('Failed to decode JSON: ' . json_last_error_msg());
	        }
	        $games = $data['pageProps']['data']['ALLGamesList'];
	        if (isset($_GET['cid']) && !empty($_GET['cid'])) {
		        $categoryId = $_GET['cid'];
		        $games = array_filter($games, function($game) use ($categoryId) {
		            return $game['categoryId'] == $categoryId;
		        });
		    }

		    if (isset($_GET['searchKeyword']) && !empty($_GET['searchKeyword'])) {
			    $searchKeyword = strtolower(trim($_GET['searchKeyword']));
			    $games = array_filter($games, function($game) use ($searchKeyword) {
			        return (stripos($game['title'], $searchKeyword) !== false) || 
			               (stripos($game['description'], $searchKeyword) !== false);
			    });
			}
	        $this->totalGames = count($games);
	        $this->totalPages = ceil($this->totalGames / $this->getGamesPerPage());
	        $this->setCurrentPage(isset($_GET['p']) ? (int)$_GET['p'] : 1);

	        $startIndex = ($this->getCurrentPage() - 1) * $this->getGamesPerPage();
	        return array_slice($games, $startIndex, $this->getGamesPerPage());

	    } catch (Exception $e) {
	        echo 'Error: ' . $e->getMessage();
	        die;
	    }
	}

	public function getAllGamesApi()
	{
	    try {
	        $api = $this->getApi();
	        $api->setUrl("http://localhost/gameslist/");
	        $data = $api->get();
	        $games = $data['pageProps']['data']['ALLGamesList'];
	        $this->totalGames = count($games);
	        $this->totalPages = ceil($this->totalGames / $this->getGamesPerPage());
	        $this->setCurrentPage(isset($_GET['p']) ? (int)$_GET['p'] : 1);
	        $startIndex = ($this->getCurrentPage() - 1) * $this->getGamesPerPage();
	        return array_slice($games, $startIndex, $this->getGamesPerPage());

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

	public function getGamesPerPage()
	{
	    return $this->gamesPerPage;
	}

	public function setGamesPerPage($gamesPerPage)
	{
	    $this->gamesPerPage = $gamesPerPage;
	}

	public function getTotalGames()
	{
	    return $this->totalGames;
	}

	public function getTotalPages()
	{
	    return $this->totalPages;
	}

	public function getCurrentPage()
	{
	    return $this->currentPage;
	}

	public function setCurrentPage($currentPage)
	{
	    $this->currentPage = max(1, min($this->totalPages, (int)$currentPage));
	}
}

?>