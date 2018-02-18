<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractActionController
{
	protected $privateKey = "6LfBmfkSAAAAAAYOgSCKjgdR53e3SMV1a0SOZakd";
    protected $publicKey = "6LfBmfkSAAAAAAJFccDB4uZ70dE1eCDbjj_62kUs";
	
    public function indexAction()
    {
		$viewModel = new ViewModel();
		
		if ($this->getRequest()->isPost()) {
			$data = $this->params()->fromPost();
			if (isset($data['email']) && isset($data['message'])) {
				require_once('vendor/Recaptcha/recaptchalib.php');
				$result = recaptcha_check_answer ($this->privateKey,
					$_SERVER["REMOTE_ADDR"],
					$_POST["recaptcha_challenge_field"],
					$_POST["recaptcha_response_field"]);
					
				if ($result->is_valid) {
					$subject = "";
					if (isset($data['subject']) && $data['subject'] != "") {
						$subject = $data['subject'];
					} else {
						$subject = "New message from DMVGS.co.uk contact form";
					}
					$name = "";
					if (isset($data['first_name']) && $data['first_name'] != ""){
						$name = $data['first_name'];
					}
					if (isset($data['last_name']) && $data['last_name'] != ""){
						$name = $name . $data['last_name'];
					}
					$headers = 'From: contact@dmvgs.co.uk' . "\r\n" .
						'Reply-To:' . $name . " " . $data['email'] . "\r\n" .
						'X-Mailer: PHP/' . phpversion();
					$success = mail('dmvgsoc@gmail.com', $subject, $data['message'], $headers);
					$viewModel->setVariable('success', $success);
				} else {
					$viewModel->setVariable('authenticated', false);
				}
			}			
		}
		$viewModel->setVariable('rpublickey', $this->publicKey );
        return $viewModel;
    }
}
