<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
		$viewModel = new ViewModel();

		$viewModel->setTemplate("application/index/index");
	
        return $viewModel;
    }
}
