<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CommitteeController extends AbstractActionController
{
    public function indexAction()
    {
	$viewModel = new ViewModel();

	$viewModel->setTemplate("application/committee/index");
	
        return $viewModel;
    }
}
