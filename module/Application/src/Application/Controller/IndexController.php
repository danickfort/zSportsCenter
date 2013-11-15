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
use Application\Controller\Plugin\Entity;
use Application\Model\Entity\Post;

use Application\Model\User;
use Application\Form\RegistrationForm;

class IndexController extends AbstractActionController {
	
    public function indexAction() {	

        // Permet d'obtenir la liste des posts actuellement en base
         $em = $this->entity()->getEntityManager();

         $posts = $em->createQuery("SELECT p from Application\Model\Entity\Post p ORDER BY p.date DESC")->getResult();
			return new ViewModel(array( 
			'posts' => $posts,
		));
    }
	
	public function signupAction() {
		$form = new RegistrationForm();
		
		/*$request = $this->getResquest();
		if ($request->isPost())
		{
			$user = new User();
			$form->setData($request->getPost());
			
			// $user->exchangeArray($form->-getData());
		}*/
		
		return new ViewModel(array(
			'form' => $form,
		));
	}
    
    public function addpostAction() {
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
	}
	
	public function loginAction() {
		// vérification champs login pass
		// vérification dans base de données
		// création session (voir google zf2 login action)
		
		// redirection vers page prec (chercher zf2 redireciton sur la page précédente)
		
		// dans les autres pages, traiter la session
	}
}
