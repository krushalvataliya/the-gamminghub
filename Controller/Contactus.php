<?php 
require_once 'Controller/Core/Action.php';

class Controller_Contactus extends Controller_Core_Action
{

	public function IndexAction()
	{	
		$this->getTemplete('contactus/index.phtml');
	}

	public function SendmessageAction()
	{
		$request = $this->getRequest();
		if ($request->isPost()) {
		    $name = trim($request->getPost('name'));
		    $email = trim($request->getPost('email'));
		    $subject = trim($request->getPost('subject'));
		    $message = trim($request->getPost('message'));
		    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
		        $this->getMessage()->addMessage("All fields are required.",  Model_Core_Message::SUCCESS);
		        exit;
		    }

		    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		        $this->getMessage()->addMessage("Invalid email format.",  Model_Core_Message::SUCCESS);
		        exit;
		    }

		    $formData = [
		        'name' => $name,
		        'email' => $email,
		        'subject' => $subject,
		        'message' => $message,
		        'submitted_at' => date('Y-m-d H:i:s')
		    ];
		    $filePath = 'var/contact_us_data.json';

		    if (file_exists($filePath)) {
		        $fileData = file_get_contents($filePath);
		        $dataArray = json_decode($fileData, true);
		        if (!is_array($dataArray)) {
		            $dataArray = [];
		        }
		    } else {
		        $dataArray = [];
		    }

		    $dataArray[] = $formData;
		    $jsonData = json_encode($dataArray, JSON_PRETTY_PRINT);
		    if (file_put_contents($filePath, $jsonData)) {
		        $this->getMessage()->addMessage("Message has been sent successfully.",  Model_Core_Message::SUCCESS);
		    } else {
		        $this->getMessage()->addMessage("Message could not be sent. Please try again later.",  Model_Core_Message::FAILURE);
		    }
		}
		return $this->redirect('index');
	}

	public function SendmessageAction1()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		    $name = trim(htmlspecialchars($_POST['name']));
		    $email = trim(htmlspecialchars($_POST['email']));
		    $subject = trim(htmlspecialchars($_POST['subject']));
		    $message = trim(htmlspecialchars($_POST['message']));

		    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
		        $this->getMessage()->addMessage("All fields are required.",  Model_Core_Message::FAILURE);
		        exit;
		    }

		    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		        $this->getMessage()->addMessage("Invalid email format.",  Model_Core_Message::FAILURE);
		        exit;
		    }
		    $to = "krushalvataliya24@gmail.com";
		    $email_subject = "Contact Us Form: $subject";
		    $email_body = "You have received a new message from the contact form on your website.\n\n".
		                  "Here are the details:\n\n".
		                  "Name: $name\n\n".
		                  "Email: $email\n\n".
		                  "Subject: $subject\n\n".
		                  "Message:\n$message";
		    
		    $headers = "From: $email\n";
		    $headers .= "Reply-To: $email\n";

		    if (mail($to, $email_subject, $email_body, $headers)) {
		        $this->getMessage()->addMessage("Thank you for contacting us! We will get back to you soon.",  Model_Core_Message::SUCCESS);
		    } else {
		        $this->getMessage()->addMessage("Oops! Something went wrong. Please try again later.",  Model_Core_Message::FAILURE);
		    }
		} else {
		    return $this->redirect('index');
		}

	}
}

?>