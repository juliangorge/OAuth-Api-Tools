<?php
namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction(){
    	var_dump($this->getIdentity());
        return new ViewModel();
    }

    public function loginAction(){
        return new ViewModel();
    }
}
