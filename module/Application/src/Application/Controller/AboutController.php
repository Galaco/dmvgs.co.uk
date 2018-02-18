<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AboutController extends AbstractActionController
{
    public function indexAction()
    {
	$viewModel = new ViewModel();

	$viewModel->setTemplate("application/about/index");
	
        return $viewModel;
    }
}
