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
use Application\Model\Entity\SportCenter;

use Application\Model\Entity\User;
use Application\Model\Entity\Sport;
use Application\Model\Entity\Court;

use Application\Form\RegistrationForm;
use Application\Form\NewSportForm;
use Application\Form\NewCourtForm;

class IndexController extends AbstractActionController {


	private $message = '';

	private function isUserAuth() {
		$userAuthNamespace = new Container('userAuthNamespace');
		return isset($userAuthNamespace->id);
	}

	private function isAdministratorUser() {
		$userAuthNamespace = new Container('userAuthNamespace');
		return $userAuthNamespace->isAdministrator;
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
		$this->setAction('');

		$sportCenter = $this->entity()->getEntityManager()->createQuery("SELECT s FROM Application\Model\Entity\SportCenter s")->getResult();

		$this->layout()->setVariables(array(
			'homeActive' => 'active',
			'contactActive' => '',
			'administrationActive' => '',
			'signupActive' => '',
			'userAuth' => $this->isUserAuth(),
			'adminVisible' => $this->isAdministratorUser(),
		));
		
		// index.pthml
		return new ViewModel(array('message' => $this->params()->fromRoute('message'), 'sportCenter' => $sportCenter[0]));
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
				$user->setAdministrator(false);
				
				$this->entity()->getEntityManager()->persist($user);
				$this->entity()->getEntityManager()->flush();

				$this->redirect()->toRoute('home');
			}
		}
		
		$this->layout()->setVariables(array(
			'homeActive' => '',
			'contactActive' => '',
			'administrationActive' => '',
			'signupActive' => 'active',
			'userAuth' => $this->isUserAuth(),
			'adminVisible' => $this->isAdministratorUser(),
		));
		
		// signup.phtml
		return new ViewModel(array(
			'form' => $form,
		));
	}
	
	public function signoutAction() {
		$userAuthNamespace = new Container('userAuthNamespace');
		unset($userAuthNamespace->id);
		unset($userAuthNamespace->isAdministrator);
		
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
			
			if (!$user) { // Login process failed
				if ($this->getAction() == '')
					return $this->redirect()->toRoute('home', array('message' => 'error'));
				else
					return $this->redirect()->toRoute('home', array('action' => $this->getAction(), 'message' => 'error'));
			} else { // Login process succeeded
				$userAuthNamespace = new Container('userAuthNamespace');
				$userAuthNamespace->id = $user->getId();
				$userAuthNamespace->isAdministrator = $user->getAdministrator();
				
				if ($this->getAction() == '')
					return $this->redirect()->toRoute('home', array('message' => 'success'));
				else
					return $this->redirect()->toRoute('home', array('action' => $this->getAction(), 'message' => 'success'));
			}
		}
		
		return new ViewModel(array('message' => $this->params()->fromRoute('message')));
	}
	
	public function contactAction() {
		$this->setAction('contact');
	
	 	// PASS VARIABLE IS ADMIN !!!
		$this->layout()->setVariables(array(
			'homeActive' => '',
			'contactActive' => 'active',
			'administrationActive' => '',
			'signupActive' => '',
			'userAuth' => $this->isUserAuth(),
			'adminVisible' => $this->isAdministratorUser(),
		));
	
		// contact.phtml
		return new ViewModel(array('message' => $this->params()->fromRoute('message')));
	}
	
	public function adminAction() {
		$this->setAction('admin');
	
		if (!$this->isUserAuth() && $this->params()->fromRoute('message') != 'notloggedin' && $this->params()->fromRoute('message') != 'notpermitted')
			return $this->redirect()->toRoute('home', array('action' => 'admin', 'message' => 'notloggedin'));

		if (!$this->isAdministratorUser() && $this->params()->fromRoute('message') != 'notpermitted' && $this->params()->fromRoute('message') != 'notloggedin')
			return $this->redirect()->toRoute('home', array('action' => 'admin', 'message' => 'notpermitted'));


		$newSportForm = new NewSportForm();
		$newCourtForm = new NewCourtForm();
		$request = $this->getRequest();
		if ($request->isPost()) {
			// Add a sport
			if (isset($request->getPost()->newSportSubmit)) {
				$sport = new Sport();
				$newSportForm->setInputFilter($sport->getInputFilter());
				$newSportForm->setData($request->getPost());
				
				if ($newSportForm->isValid()) {
					$sport->exchangeArray($newSportForm->getData());
					
					$this->entity()->getEntityManager()->persist($sport);
					$this->entity()->getEntityManager()->flush();
				}
			// Add a court
			} else if (isset($request->getPost()->newCourtSubmit))  {
				$court = new Court();
				$newCourtForm->setInputFilter($court->getInputFilter());
				$newCourtForm->setData($request->getPost());

				if ($newCourtForm->isValid()) {
					$court->exchangeArray($newCourtForm->getData());

					$sport = $this->entity()->getEntityManager()->find('Application\Model\Entity\Sport', $newCourtForm->get('sport')->getValue());
					$court->setSport($sport);

					$this->entity()->getEntityManager()->persist($court);
					$this->entity()->getEntityManager()->flush();
				}
			// Modify a court
			} else if (isset($request->getPost()->modifyCourtSubmit)) {
				$court = new Court();
				$newCourtForm->setInputFilter($court->getInputFilter());
				$newCourtForm->setData($request->getPost());

				if ($newCourtForm->isValid()) {
					$court->exchangeArray($newCourtForm->getData());

					$sport = $this->entity()->getEntityManager()->find('Application\Model\Entity\Sport', $newCourtForm->get('sport')->getValue());
					$court->setSport($sport);

					$query = $this->
							 entity()->
							 getEntityManager()->
							 createQuery("UPDATE Application\Model\Entity\Court c SET c.name = ?1, c.description = ?2, c.sport = ?3 WHERE c.id = ?4");

					$query->setParameter(1, $court->getName());
					$query->setParameter(2, $court->getDescription());
					$query->setParameter(3, $court->getSport());
					$query->setParameter(4, $court->getId());
					$query->getResult();
				}
			}
		}

		$sports = $this->entity()->getEntityManager()->createQuery("SELECT s FROM Application\Model\Entity\Sport s")->getResult();
	
		$this->layout()->setVariables(array(
			'homeActive' => '',
			'contactActive' => '',
			'administrationActive' => 'active',
			'signupActive' => '',
			'userAuth' => $this->isUserAuth(),
			'adminVisible' => $this->isAdministratorUser(),
		));
	
		// admin.phtml

		return new ViewModel(array(
			'sports' => $sports,
			'newSportForm' => $newSportForm,
			'newCourtForm' => $newCourtForm,
			'message' => $this->params()->fromRoute('message'),
		));
	}
    

	
	public function getReservationAction()
	{

	}	

	public function delReservationAction()
	{

	}	

	public function addReservationAction()
	{

	}	

	public function updReservationAction()
	{

	}

}
