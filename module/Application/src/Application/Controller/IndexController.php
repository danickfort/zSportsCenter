<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Application\Controller\Plugin\Entity;
use Application\Model\Entity\Post;

use Application\Model\Entity\User;
use Application\Form\RegistrationForm;

class IndexController extends AbstractActionController {
	private function isUserAuth() {
		$userAuthNamespace = new Container('userAuthNamespace');
		return isset($userAuthNamespace->id);
	}
	
	private function setAction($action) {
		$actionNamespace = new Container('actionNamespace');
		$actionNamespace->actionName = $action;
	}
	
	private function getAction() {
		$actionNamespace = new Container('actionNamespace');
		if (isset($actionNamespace->actionName)) {
			return $actionNamespace->actionName;
		} else {
			return '';
		}
	}
	
    public function indexAction() {	
         /* $em = $this->entity()->getEntityManager();

         $posts = $em->createQuery("SELECT p from Application\Model\Entity\Post p ORDER BY p.date DESC")->getResult();
			return new ViewModel(array( 
			'posts' => $posts,
		)); */
		$this->setAction('');
		
		$this->layout()->setVariables(array(
			'homeActive' => 'active',
			'contactActive' => '',
			'administrationActive' => '',
			'signupActive' => '',
			'userAuth' => $this->isUserAuth(),
		));
		
		// index.pthml
		return new ViewModel();
    }
	
	public function signupAction() {
		$this->setAction('signup');
	
		$form = new RegistrationForm();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$user = new User();
			$form->setInputFilter($user->getInputFilter());
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				$user->exchangeArray($form->getData());
				
				$this->entity()->getEntityManager()->persist($user);
				$this->entity()->getEntityManager()->flush();
			}
		}
		
		$this->layout()->setVariables(array(
			'homeActive' => '',
			'contactActive' => '',
			'administrationActive' => '',
			'signupActive' => 'active',
			'userAuth' => $this->isUserAuth(),
		));
		
		// signup.phtml
		return new ViewModel(array(
			'form' => $form,
		));
	}
	
	public function signoutAction() {
		$userAuthNamespace = new Container('userAuthNamespace');
		unset($userAuthNamespace->id);
		
		// return $this->redirect()->toRoute('home', array('action' => $this->getAction()));
		if ($this->getAction() == '')
			return $this->redirect()->toRoute('home');
		else
			return $this->redirect()->toRoute('home', array('action' => $this->getAction()));
	}
	
	public function signinAction() {
		$request = $this->getRequest();
		if ($request->isPost()) {
			$postParams = $request->getPost();
			$nickname = $postParams['nickname'];
			$password = $postParams['password'];
			
			$user = $this->entity()->getEntityManager()->getRepository('Application\Model\Entity\User')->findOneBy(array('nickname' => $nickname, 'password' => $password));
			
			if (!$user) {
				return $this->redirect()->toRoute('home', array('action' => 'signin'));
			} else {
				$userAuthNamespace = new Container('userAuthNamespace');
				$userAuthNamespace->id = $user->getId();
				
				// return $this->redirect()->toRoute('home', array('action' => $this->getAction()));
				if ($this->getAction() == '')
					return $this->redirect()->toRoute('home');
				else
					return $this->redirect()->toRoute('home', array('action' => $this->getAction()));
			}
		}
		
		/*$this->layout()->setVariables(array(
			'homeActive' => '',
			'contactActive' => '',
			'administrationActive' => '',
			'signupActive' => '',
		));*/
		
		// it's depend!
		return new ViewModel();
	}
	
	public function contactAction() {
		$this->setAction('contact');
	
		$this->layout()->setVariables(array(
			'homeActive' => '',
			'contactActive' => 'active',
			'administrationActive' => '',
			'signupActive' => '',
			'userAuth' => $this->isUserAuth(),
		));
	
		// contact.phtml
		return new ViewModel();
	}
	
	public function adminAction() {
		$this->setAction('admin');
	
		if (!$this->isUserAuth())
			return $this->redirect()->toRoute('home', array('action' => 'signin'));
	
		$this->layout()->setVariables(array(
			'homeActive' => '',
			'contactActive' => '',
			'administrationActive' => 'active',
			'signupActive' => '',
			'userAuth' => $this->isUserAuth(),
		));
	
		// admin.phtml
		return new ViewModel();
	}
    
    /*public function addpostAction() {
		if($this->getRequest()->isPost()) {
			 $postParam = $this->getRequest()->getPost(); 
             $title = $postParam['title']; 
             $date = $postParam['date']; 
             $description = $postParam['description']; 
             
             $post = new Post(); 
             $post->setTitle($title); 
             $post->setDate(new \DateTime($date)); 
             $post->setDescription($description); 
             $this->entity()->getEntityManager()->persist($post); 
             $this->entity()->getEntityManager()->flush();
             
             return $this->redirect()->toRoute('home'); 
             }
		return new ViewModel();
	}*/
}
