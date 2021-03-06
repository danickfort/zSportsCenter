<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Doctrine\ORM\Query;


use Zend\Mvc\Controller\AbstractActionController;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;
use Application\Controller\Plugin\Entity;

use Application\Model\Entity\User;
use Application\Model\Entity\Sport;
use Application\Model\Entity\Court;
use Application\Model\Entity\SportCenter;
use Application\Model\Entity\Reservation;
use Application\Model\Entity\HourlyPrice;
use Application\Model\Entity\Holiday;

use Application\Form\RegistrationForm;
use Application\Form\NewSportForm;
use Application\Form\NewCourtForm;
use Application\Form\SportCenterForm;
use Application\Form\HourlyPriceForm;
use Application\Form\SportCenterVacationForm;
use Application\Form\ModifyHourlyPriceForm;

use Application\Form\ReservationForm;

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
		$sports = $this->entity()->getEntityManager()->createQuery("SELECT s FROM Application\Model\Entity\Sport s")->getResult();

		if (count($sportCenter) != 0) {
			$sportCenter = $sportCenter[0];
		} else {
			$sportCenter = null;
		}

		$showCalendar = false;
		$sportsCounter = 0;
		$courtsCounter = 0;
		if (count($sports) != 0) {
			foreach ($sports as $sport) {
				$courtsCounter += count($sport->getCourts());
			}
		}
		if ($courtsCounter != 0) {
			$showCalendar = true;
		} else {
			$showCalendar = false;
		}

		$this->layout()->setVariables(array(
			'homeActive' => 'active',
			'contactActive' => '',
			'administrationActive' => '',
			'signupActive' => '',
			'userAuth' => $this->isUserAuth(),
			'adminVisible' => $this->isAdministratorUser(),
			));

		$isAdmin = 0;
		$lastReservations = 0;
		$isLoggedIn = 0;

		if ($this->isAdministratorUser())
		{
			$isAdmin = 1;
			$lastReservations = $this->entity()->getEntityManager()->createQueryBuilder()
			->select('e')
			->from('Application\Model\Entity\Reservation', 'e')
			->orderBy('e.id','DESC')
			->setMaxResults(10)
			->getQuery()
			->getResult();
		}

		if ($this->isUserAuth())
		{
			$isLoggedIn = 1;
		}
        // index.pthml
		return new ViewModel(array(
			'sports' => $sports,
			'lastReservations' => $lastReservations,
			'isLoggedIn' => $isLoggedIn,
			'isAdmin' => $isAdmin,
			'message' => $this->params()->fromRoute('message'),
			'sportCenter' => $sportCenter,
			'showCalendar' => $showCalendar,
			));
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

		$sportCenter = $this->entity()->getEntityManager()->createQuery("SELECT s FROM Application\Model\Entity\SportCenter s")->getResult();

		$this->layout()->setVariables(array(
			'homeActive' => '',
			'contactActive' => 'active',
			'administrationActive' => '',
			'signupActive' => '',
			'userAuth' => $this->isUserAuth(),
			'adminVisible' => $this->isAdministratorUser(),
			));

		// contact.phtml
		return new ViewModel(array('message' => $this->params()->fromRoute('message'), 'sportCenter' => $sportCenter[0]));
	}
	
	public function adminAction() {
		$sportCenterActive = 'active';
		$usersActive = '';
		$sportsActive = '';

		$this->setAction('admin');

		$performedAction = '';

		if (!$this->isUserAuth() && $this->params()->fromRoute('message') != 'notloggedin' && $this->params()->fromRoute('message') != 'notpermitted')
			return $this->redirect()->toRoute('home', array('action' => 'admin', 'message' => 'notloggedin'));

		if (!$this->isAdministratorUser() && $this->params()->fromRoute('message') != 'notpermitted' && $this->params()->fromRoute('message') != 'notloggedin')
			return $this->redirect()->toRoute('home', array('action' => 'admin', 'message' => 'notpermitted'));


		$newSportForm = new NewSportForm();
		$newCourtForm = new NewCourtForm();
		$sportCenterForm = new SportCenterForm();
		$sportCenterVacationForm = new SportCenterVacationForm();
		$modifyHourlyPriceForm = new ModifyHourlyPriceForm();
		
		$sportCenters = $this->entity()->getEntityManager()->createQuery("SELECT s FROM Application\Model\Entity\SportCenter s")->getResult();
		$openingHour = 7;
		$closingHour = 18;
		$defaultHourlyPrice = 25;

		if (!$sportCenters) {
			$sportCenterForm->get('newSportCenterSubmit')->setAttribute('name', 'newSportCenterSubmit');
			$sportCenterForm->get('newSportCenterSubmit')->setAttribute('value', 'New sport center');

			$hourlyPriceForm = new HourlyPriceForm(null, 9, 18);
		} else {
			if (!isset($this->request->getPost()->modifySportCenterSubmit)) {
				$sportCenter = $sportCenters[0];

				$sportCenterForm->get('id')->setAttribute('value', $sportCenter->getId());
				$sportCenterForm->get('name')->setAttribute('value', $sportCenter->getName());
				$sportCenterForm->get('address')->setAttribute('value', $sportCenter->getAddress());
				$sportCenterForm->get('city')->setAttribute('value', $sportCenter->getCity());
				$sportCenterForm->get('postCode')->setAttribute('value', $sportCenter->getPostCode());
				$sportCenterForm->get('phone')->setAttribute('value', $sportCenter->getPhone());
				$sportCenterForm->get('twitter')->setAttribute('value', $sportCenter->getTwitter());
				$sportCenterForm->get('facebook')->setAttribute('value', $sportCenter->getFacebook());
				$sportCenterForm->get('defaultHourlyPrice')->setAttribute('value', $sportCenter->getDefaultHourlyPrice());
				$sportCenterForm->get('openingHour')->setAttribute('value', $sportCenter->getOpeningHour());
				$sportCenterForm->get('closingHour')->setAttribute('value', $sportCenter->getClosingHour());

				$sportCenterVacationForm->get('sportCenter')->setAttribute('value', $sportCenter->getId());

			}
			$sportCenter = $sportCenters[0];

			$openingHour = $sportCenter->getOpeningHour();
			$closingHour = $sportCenter->getClosingHour();
			$defaultHourlyPrice = $sportCenter->getDefaultHourlyPrice();

			$hourlyPriceForm = new HourlyPriceForm(null, $sportCenter->getOpeningHour(), $sportCenter->getClosingHour());

			$sportCenterForm->get('newSportCenterSubmit')->setAttribute('name', 'modifySportCenterSubmit');
			$sportCenterForm->get('newSportCenterSubmit')->setAttribute('value', 'Modify sport center');
		}

		$request = $this->getRequest();
		if ($request->isPost()) {
			// Add a sport
			if (isset($request->getPost()->newSportSubmit)) {
				$sportCenterActive = '';
				$usersActive = '';
				$sportsActive = 'active';

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
				$sportCenterActive = '';
				$usersActive = '';
				$sportsActive = 'active';

				$court = new Court();
				$newCourtForm->setInputFilter($court->getInputFilter());
				$newCourtForm->setData($request->getPost());

				if ($newCourtForm->isValid()) {
					$court->exchangeArray($newCourtForm->getData());

					$sport = $this->entity()->getEntityManager()->find('Application\Model\Entity\Sport', $newCourtForm->get('sport')->getValue());
					$court->setSport($sport);

					$this->entity()->getEntityManager()->persist($court);
					$this->entity()->getEntityManager()->flush();

					$performedAction = 'addCourt';
				}
			// Modify a court
			} else if (isset($request->getPost()->modifyCourtSubmit)) {
				$sportCenterActive = '';
				$usersActive = '';
				$sportsActive = 'active';

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

					$performedAction = 'updCourt';
				}
			// Add the sport center
			} else if (isset($request->getPost()->newSportCenterSubmit)) {
				$sportCenterActive = 'active';
				$usersActive = '';
				$sportsActive = '';

				$sportCenter = new SportCenter();
				$sportCenterForm->setInputFilter($sportCenter->getInputFilter());
				$sportCenterForm->setData($request->getPost());

				if ($sportCenterForm->isValid()) {
					$sportCenter->exchangeArray($sportCenterForm->getData());

					$this->entity()->getEntityManager()->persist($sportCenter);
					$this->entity()->getEntityManager()->flush();
				}
			}
			// Modify the sport center
			else if (isset($request->getPost()->modifySportCenterSubmit)) {
				$sportCenterActive = 'active';
				$usersActive = '';
				$sportsActive = '';

				$sportCenter = new SportCenter();
				$sportCenterForm->setInputFilter($sportCenter->getInputFilter());
				$sportCenterForm->setData($request->getPost());

				if ($sportCenterForm->isValid()) {
					$sportCenter->exchangeArray($sportCenterForm->getData());

					$query = $this->
					entity()->
					getEntityManager()->
					createQuery("UPDATE Application\Model\Entity\SportCenter c SET c.name = ?1, c.address = ?2, c.city = ?3, c.postCode = ?4, c.phone = ?5, c.twitter = ?6, c.facebook = ?7, c.openingHour = ?8, c.closingHour = ?9, c.defaultHourlyPrice = ?10 WHERE c.id = ?11");

					$query->setParameter(1, $sportCenter->getName());
					$query->setParameter(2, $sportCenter->getAddress());
					$query->setParameter(3, $sportCenter->getCity());
					$query->setParameter(4, $sportCenter->getPostCode());
					$query->setParameter(5, $sportCenter->getPhone());
					$query->setParameter(6, $sportCenter->getTwitter());
					$query->setParameter(7, $sportCenter->getFacebook());
					$query->setParameter(8, $sportCenter->getOpeningHour());
					$query->setParameter(9, $sportCenter->getClosingHour());
					$query->setParameter(10, $sportCenter->getDefaultHourlyPrice());
					$query->setParameter(11, $sportCenter->getId());

					$query->getResult();
				}
			}
			// Add hourly price for a court
			else if (isset($request->getPost()->hourlyPriceSubmit)) {
				$sportCenterActive = '';
				$usersActive = '';
				$sportsActive = 'active';

				$hourlyPrice = new HourlyPrice();
				$hourlyPriceForm->setInputFilter($hourlyPrice->getInputFilter());
				$hourlyPriceForm->setData($request->getPost());

				if ($hourlyPriceForm->isValid()) {
					$entityManager = $this->entity()->getEntityManager();

					$startTime = intval($hourlyPriceForm->get('startTime')->getValue());
					$stopTime = intval($hourlyPriceForm->get('stopTime')->getValue());
					$price = intval($hourlyPriceForm->get('hourlyPrice')->getValue());
					$idCourt = intval($hourlyPriceForm->get('court')->getValue());

					$court = $entityManager->find('Application\Model\Entity\Court', $idCourt);


					for($time = $startTime; $time <= $stopTime; $time++) {
						$hourlyPrice = new HourlyPrice();

						$hourlyPrice->setTime($time);
						$hourlyPrice->setHourlyPrice($price);
						$hourlyPrice->setCourt($court);

						$entityManager->persist($hourlyPrice);
						$entityManager->flush();
					}
				}
			}
			// Add sport center vacation
			else if (isset($request->getPost()->sportCenterVacationSubmit)) {
				$sportCenterActive = 'active';
				$usersActive = '';
				$sportsActive = '';
				
				$holiday = new Holiday();
				$sportCenterVacationForm->setInputFilter($holiday->getInputFilter());
				$sportCenterVacationForm->setData($request->getPost());

				if ($sportCenterVacationForm->isValid()) {
					$holiday->exchangeArray($sportCenterVacationForm->getData());

					$sportCenter = $this->entity()->getEntityManager()->find('Application\Model\Entity\SportCenter', $sportCenterVacationForm->get('sportCenter')->getValue());
					$holiday->setSportCenter($sportCenter);

					$this->entity()->getEntityManager()->persist($holiday);
					$this->entity()->getEntityManager()->flush();
				}
			}
			// Modify hourly prices for a court
			else if (isset($request->getPost()->modifyHourlyPriceSubmit)) {
				$sportCenterActive = '';
				$usersActive = '';
				$sportsActive = 'active';

				$id = $request->getPost()->id;
				$price = $request->getPost()->hourlyPrice;

				$hourlyPrice = $this->entity()->getEntityManager()->find('Application\Model\Entity\HourlyPrice', $id);

				$hourlyPrice->setHourlyPrice($price);

				$this->entity()->getEntityManager()->persist($hourlyPrice);
				$this->entity()->getEntityManager()->flush();
			}
		}

		$sports = $this->entity()->getEntityManager()->createQuery("SELECT s FROM Application\Model\Entity\Sport s")->getResult();
		$users = $this->entity()->getEntityManager()->createQuery("SELECT s FROM Application\Model\Entity\User s")->getResult();

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
			'sportCenterActive' => $sportCenterActive,
			'usersActive' => $usersActive,
			'sportsActive' => $sportsActive,
			'sports' => $sports,
			'openingHour' => $openingHour,
			'closingHour' => $closingHour,
			'defaultHourlyPrice' => $defaultHourlyPrice,
			'users' => $users,
			'newSportForm' => $newSportForm,
			'newCourtForm' => $newCourtForm,
			'sportCenterForm' => $sportCenterForm,
			'hourlyPriceForm' => $hourlyPriceForm,
			'sportCenterVacationForm' => $sportCenterVacationForm,
			'modifyHourlyPriceForm' => $modifyHourlyPriceForm,
			'message' => $this->params()->fromRoute('message'),
			));
	}

	public function removeSportAction()
	{
		$params = $this->getRequest()->getPost();

		$code = $this->params()->fromQuery('code',0);
		$id = $this->params()->fromQuery('id',0);

		// Admin want delete a sport
		if ($code == "removeSport") {
			$qb = $this->entity()->getEntityManager()->createQueryBuilder()
			->select("c")
			->from("Application\Model\Entity\Court", "c")
			->where("c.sport = :sport");

			$qb->setParameter('sport', $id);

			$courts = $qb->getQuery()->getResult();

			$names = array();
			foreach($courts as $court) {
				$names[] = $court->getName();
			}

			return new JsonModel(array(
				'idSport' => $id,
				'courts' => $names,
				));
		} else if ($code == "confirm") {
			$qb = $this->entity()->getEntityManager()->createQueryBuilder()
			->select("c")
			->from("Application\Model\Entity\Court", "c")
			->where("c.sport = :sport");
			$qb->setParameter("sport", $id);
			$courts = $qb->getQuery()->getResult();

			$namesCourt = array();
			// deleting courts
			foreach($courts as $court) {
				$namesCourt[] = str_replace(' ', '', $court->getName());
				$idCourt = $court->getId();

				// delete hourly prices for the current court
				$query = $this->entity()->getEntityManager()->createQuery("DELETE Application\Model\Entity\HourlyPrice h WHERE h.court = ?1");
				$query->setParameter(1, $idCourt);
				$result = $query->getResult();
				// delete reservations for the current court
				$query = $this->entity()->getEntityManager()->createQuery("DELETE Application\Model\Entity\Reservation r WHERE r.court = ?1");
				$query->setParameter(1, $idCourt);
				$result = $query->getResult();
				// delete current court
				$query = $this->entity()->getEntityManager()->createQuery("DELETE Application\Model\Entity\Court c WHERE c.id = ?1");
				$query->setParameter(1, $idCourt);
				$result = $query->getResult();
			}

			$qb = $this->entity()->getEntityManager()->createQueryBuilder()
			->select("s")
			->from("Application\Model\Entity\Sport", "s")
			->where("s.id = :id");

			$qb->setParameter("id", $id);

			$sports = $qb->getQuery()->getResult();

			$sportName = '';
			foreach($sports as $sport) {
				$sportName = $sport->getName();
			}

			$query = $this->entity()->getEntityManager()->createQuery("DELETE Application\Model\Entity\Sport s WHERE s.id = ?1");
			$query->setParameter(1, $id);
			$result = $query->getResult();
			
			return new JsonModel(array(
				'sportName' => str_replace(' ', '', $sportName),
				'namesCourt' => $namesCourt,
				));
		}
	}

	public function removeCourtAction()
	{
		$params = $this->getRequest()->getPost();

		$code = $this->params()->fromQuery('code',0);
		$id = $this->params()->fromQuery('id',0);

		// Admin want delete a sport
		if ($code == "removeCourt") {
			$qb = $this->entity()->getEntityManager()->createQueryBuilder()
			->select("r")
			->from("Application\Model\Entity\Reservation", "r")
			->where("r.court = :court");

			$qb->setParameter('court', $id);

			$reservations = $qb->getQuery()->getResult();

			$usersName = array();
			foreach($reservations as $reservation) {
				$usersName[] = $reservation->getUser()->getFirstName();
			}

			return new JsonModel(array(
				'idCourt' => $id,
				'usersName' => $usersName,
				));
		} else if ($code == "confirm") {
			$court = $this->entity()->getEntityManager()->find('Application\Model\Entity\Court', $id);
			$nameCourt = $court->getName();

			// delete hourly prices for the current court
			$query = $this->entity()->getEntityManager()->createQuery("DELETE Application\Model\Entity\HourlyPrice h WHERE h.court = ?1");
			$query->setParameter(1, $id);
			$result = $query->getResult();
			// delete reservations for the current court
			$query = $this->entity()->getEntityManager()->createQuery("DELETE Application\Model\Entity\Reservation r WHERE r.court = ?1");
			$query->setParameter(1, $id);
			$result = $query->getResult();

			// delete the court
			$query = $this->entity()->getEntityManager()->createQuery("DELETE Application\Model\Entity\Court c WHERE c.id = ?1");
			$query->setParameter(1, $id);
			$result = $query->getResult();
			
			// return court name
			return new JsonModel(array(
				'nameCourt' => str_replace(' ', '', $nameCourt),
				));
		}
	}

	public function removeVacationAction()
	{
		$code = $this->params()->fromQuery('code',0);
		$id = $this->params()->fromQuery('id',0);

		if ($code == "removeVacation") {
			return new JsonModel(array(
				'idVacation' => $id,
				));
		} else if ($code == "confirm") {
			// delete the court
			$query = $this->entity()->getEntityManager()->createQuery("DELETE Application\Model\Entity\Holiday h WHERE h.id = ?1");
			$query->setParameter(1, $id);
			$result = $query->getResult();
			
			return new JsonModel(array(
				'idVacation' => $id,
				));
		}
	}

	public function removeUserAction()
	{

		$code = $this->params()->fromPost('code',0);
		$id = $this->params()->fromPost('id',0);


		if($code == "confirm")
		{
			$qb = $this->entity()->getEntityManager()->createQueryBuilder()
			->select("r")
			->from("Application\Model\Entity\Reservation", "r")
			->where("r.user = :user");
			$qb->setParameter('user', $id);

			foreach ($qb->getQuery()->getResult() as $res):
				$this->entity()->getEntityManager()->remove($res);
			endforeach;

			$this->entity()->getEntityManager()->flush();


			$query = $this->entity()->getEntityManager()->find("Application\Model\Entity\User", $id);
			$this->entity()->getEntityManager()->remove($query);

			$this->entity()->getEntityManager()->flush();
			
			return new JsonModel(array(
				'code' => "success"
				));
		}
		elseif ($code == "removeUser")
		{
			$qb = $this->entity()->getEntityManager()->createQueryBuilder()
			->select("r")
			->from("Application\Model\Entity\Reservation", "r")
			->where("r.user = :user");

			$qb->setParameter('user', $id);

			$result = $qb->getQuery()->getResult();

			$reservations = array();
			foreach($reservations as $reservation)
			{
				$ids[] = $court->getId();
			}

			$user = $this->entity()->getEntityManager()->find("Application\Model\Entity\User", $id);

			return new JsonModel(array(
				'idUser' => $user->getId(),
				'name' => $user->getNickname(),
				));
		}

	}

	public function getReservationAction()
	{

		$start = (int) $this->params()->fromQuery('start', 0);
		$end   = (int) $this->params()->fromQuery('end', 0);
		$courtId   = (int) $this->params()->fromQuery('courtId', 0);

		$starting_at = date('Y-m-d H:i:s', $start);
		$ending_at   = date('Y-m-d H:i:s', $end);
		$records = '';

		$userAuthNamespace = new Container('userAuthNamespace');
		$currentUserId = $userAuthNamespace->id;

        //$court = $this->entity()->getEntityManager()->find("Application\Model\Entity\Court", $courtId);

		$records = $this->entity()->getEntityManager()->createQueryBuilder()
		->select('e')
		->from('Application\Model\Entity\Reservation', 'e')
		->setParameter('starting_at', $starting_at)
		->where('e.startDateTime >= :starting_at')
		->setParameter('ending_at', $ending_at)
		->andWhere('e.endDateTime < :ending_at')
		->setParameter('courtId', $courtId)
		->andWhere('e.court = :courtId')
		->getQuery()
		->getResult();


		$list = array();

		foreach($records as $record)
		{
			$bgcolor = ($record->getUser()->getId() == $currentUserId) ? '#33B5E5' : '#AA66CC';
			$item = array(
				'id' => $record->getId() + "",
				'title' => "Réservé",
				'start' => $record->getStartDateTime()->format('Y-m-d H:i'),
				'end' => $record->getEndDateTime()->format('Y-m-d H:i'),
				'allDay' => false,
				'backgroundColor' => $bgcolor,
				);
			$list[] = $item;
		}


		return new JsonModel(array(
			'events' => $list
			)
		);
	}	

	public function delReservationAction()
	{
		$success = false;
		$message = 'Bad request';
		$ts = $this->params()->fromPost('ts', 0);
		$id = (int)$this->params()->fromPost('id', 0);

		if (!$this->isAdministratorUser())
		{
			return new JsonModel(array(
				'message' => 'Vous devez être administrateur pour faire ça!',
				'success' => false,
				));
		}

		if (!$id || !$ts) {

			return new JsonModel(array(
				'message' => $message,
				'success' => false,
				));
		}

		$request = $this->getRequest();

		$qb = $this->entity()->getEntityManager()->createQueryBuilder()
		->select('e')
		->from('Application\Model\Entity\Reservation', 'e')
		->where('e.id = :id');

		$qb->setParameter('id', $id);

		$query = $qb->getQuery();

		$reservation = '';
		try {
			$reservation = $query->getSingleResult(Query::HYDRATE_OBJECT);
		} catch (\Exception $e) {
			return false;
		}

		if (!$reservation) {
			$message = 'Not found';

			return new JsonModel(array(
				'message' => $message,
				'success' => false,
				));
		}

		if ($request->isPost()) {
			$this->entity()->getEntityManager()->remove($reservation);
			$this->entity()->getEntityManager()->flush();

			$success = true;
            // translate helper
			$message = 'L\'entrée ' . $id . ' a été supprimée';
		}

		return new JsonModel(array(
			'message' => $message,
			'success' => $success,
			'ts' => $ts,
			));
	}

	public function addReservationAction()
	{

		$request = $this->getRequest();

		$success = false;
		$ts      = $this->params()->fromPost('ts', 0);
		$courtId = $this->params()->fromPost('courtId', 0);
		$id = 0;
		$message = 'Bad request';

		$form = new ReservationForm();

		$userAuthNamespace = new Container('userAuthNamespace');
		$currentUserId = $userAuthNamespace->id;

		if (!$this->isUserAuth())
		{

			return new JsonModel(array(
				'message' => 'Connectez-vous avant de réserver!',
				'success' => $success,
				'ts' => $ts
				)
			);
		}

		if ($request->isPost()) {

			$calculatedPrice = 0;

			$isOnVacation = false;

			$startDateTime = new \DateTime($request->getPost()['start']);
			$endDateTime = new \DateTime($request->getPost()['end']);

        	//CALCULATE PRICE
        	$startValue = $startDateTime->format('G'); // G = hour without leading 0, 24-hour format
        	$endValue = $endDateTime->format('G');

        	$sportCenter = $this->entity()->getEntityManager()->createQuery("SELECT s FROM Application\Model\Entity\SportCenter s")->getSingleResult();

        	foreach(range($startValue,$endValue-1) as $hour) {
        		$hourlyPrice = null;
        		$price = 0;
        		try {
        			$hourlyPrice = $this->entity()->getEntityManager()->createQueryBuilder()
        			->select('e')
        			->from('Application\Model\Entity\HourlyPrice', 'e')
        			->setParameter('court',$courtId)
        			->where('e.court = :court')
        			->setParameter('hour', 8)
        			->andWhere('e.time = :hour')
        			->getQuery()
        			->getSingleResult();
        		}
        		catch (\Doctrine\ORM\NoResultException $e)
        		{
        			$price = $sportCenter->getDefaultHourlyPrice();
        		}
        		if (is_object($hourlyPrice)) $price = $hourlyPrice->getHourlyPrice();
        		$calculatedPrice += $price;
        	}
        	//END CALCULATE PRICE

        	//CHECK VACATION
        	$vacations = $this->entity()->getEntityManager()->createQueryBuilder()
        	->select('e')
        	->from('Application\Model\Entity\Holiday', 'e')
        	->getQuery()
        	->getResult();

        	foreach ($vacations as $vacation)
        	{
        		$vacationStartDate = $vacation->getStartDate();
        		$vacationEndDate = $vacation->getEndDate();
        		$vacationEndDate->setDate($vacationEndDate->format('Y'),
        			$vacationEndDate->format('m'),
        			$vacationEndDate->format('d')+1);
		     	// No overlap check
        		if (($startDateTime >= $vacationStartDate && $startDateTime <= $vacationEndDate)
        			&& ($endDateTime >= $vacationStartDate && $endDateTime <= $vacationEndDate))
        		{
					//is overlapping with a vacation
        			$sucess = false;
        			$message = "The sports center is on holiday from " . $vacationStartDate->format('Y-m-d H:i') . " to " . $vacationEndDate->format('Y-m-d H:i') ."<br/>Please choose another time";
        			$isOnVacation = true;
        			break;
        		}
        	}
        	
        	//END CHECK VACATION
        	if (!$isOnVacation)
        	{
        		$form->setData($request->getPost());

        		$court = $this->entity()->getEntityManager()->find('Application\Model\Entity\Court', $courtId);
        		$user = $this->entity()->getEntityManager()->find('Application\Model\Entity\User', $currentUserId);

        		$reservation = new Reservation();

        		$reservation->setUser($user);
        		$reservation->setCourt($court);

        		$form->setInputFilter($reservation->getInputFilter());
        		if ($form->isValid()) {

        			$data = $form->getData();

        			$reservation->populate($data);

        			$this->entity()->getEntityManager()->persist($reservation);
        			$this->entity()->getEntityManager()->flush();

        			$success   = true;
        			$message = 'Réservation ajoutée!';
        			$id = (int)$reservation->getId();
        		}
        	}
        }

        return new JsonModel(array(
        	'message' => $message,
        	'success' => $success,
        	'ts' => $ts,
        	'courtId' => $courtId,
        	'calculatedPrice' => $calculatedPrice,
        	'id' => $id
        	)
        );
    }	

    public function updReservationAction()
    {
    	$request = $this->getRequest();
    	$success = false;
    	$message = 'Bad request';
    	$ts = $this->params()->fromPost('ts', 0);
    	$id = (int)$this->params()->fromPost('id', 0);
    	$start = $this->params()->fromPost('start',0);
    	$end = $this->params()->fromPost('end',0);

    	if (!$this->isAdministratorUser())
    	{
    		return new JsonModel(array(
    			'message' => 'Vous devez être administrateur pour faire ça!',
    			'success' => false,
    			));
    	}

    	if ($request->isPost()) {
    		$reservation = $this->entity()->getEntityManager()->find('Application\Model\Entity\Reservation', $id);
    		$reservation->setStartDateTime(new \DateTime($start));
    		$reservation->setEndDateTime(new \DateTime($end));
    		$this->entity()->getEntityManager()->flush();

    		$message = 'Réservation mise à jour !';
    	}

    	return new JsonModel(array(
    		'message' => $message,
    		'success' => false,
    		));
    }

}