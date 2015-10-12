<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class TodosController extends AppController {
  		
  	public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['ajax_add','ajax_refresh','ajax_maj_status','ajax_delete']);
    }

    public function index() {
    	$todos = $this->Todos->find('all', [
    		'order' => ['Todos.created' => 'ASC']
		]);	//debug($todos); die();
        $this->set('todos', $todos);
    }

    // Add // Ajax // Post // Json
    public function ajax_add() {
    	if(!$this->request->is('ajax')) {
	        throw new BadRequestException();
	    }
	    $this->autoRender = false;
        $d=array();
		$d['result'] =  0;
        $d['message'] =  "Method _POST seulement.";
        if ($this->request->is('post')) {
            $text = $_POST['value'];
            if ($text=='') {
                    $d['result'] = 0;
                    $d['message'] = "La tâche ne peut pas être vide.";
            } else {
            	$Todos = TableRegistry::get('Todos');
            	$e = $Todos->newEntity();
				$e->text = $text;
				$e->status = 0;
				if ($Todos->save($e)) {
					$d['result'] =  1;
					$d['message'] = "La tâche a été ajoutée.";
					// Pour le refresh
					$d['url'] = "todos/ajax_refresh"; //".$e->id;
					$d['data'] = $e->id;
					$d['div'] = "#todos";
				}				
	        }
        }
		$this->set('_serialize', $d);
		echo json_encode($d);
    }       
    
    // Refresh // Ajax // Get // Html
	// J'ai fais le choix de chercher l'enregistrement ajouté pour l'afficher via un partial à la suite des enregistrements déjà affichés.
	// Il aurrait été plus simple et plus rapide de rafraichir l'index lors d'un ajout réussi. 
    public function ajax_refresh() {
    	if(!$this->request->is('ajax')) {
	        throw new BadRequestException();
	    }
	    $this->layout = 'empty'; //$this->viewBuilder()->layout('empty');
		$this->autoRender = false;	    
        $id = $_POST['value'];
    	$e = $this->Todos->get($id);
        $this->set('e', $e);
        $this->render('_todo');
    }
	
	// Maj status // Ajax // Post // Json
    public function ajax_maj_status() {
    	if(!$this->request->is('ajax')) {
	        throw new BadRequestException();
	    }
	    $this->autoRender = false;
        $d=array();
		$d['result'] =  0;
        $d['message'] =  "Method _POST seulement.";
        if ($this->request->is('post')) {
            $id = $_POST['value'];
			$e = $this->Todos->get($id); //$e = $this->Todos->findById($id)->first(); //debug($e); die();
            if ($e->status==1) {
                $status=0;
                $d['message'] =  "La tâche est à faire.";
            } else {
                $status=1;
                $d['message'] =  "La tâche est finie.";
            }
			$e->status = $status;
			$this->Todos->save($e);			   
            $d['result'] =  $status;
        } 
		$this->set('_serialize', $d);
		echo json_encode($d);
    }

    // Delete // Ajax // Post // Json
    public function ajax_delete() {
		if(!$this->request->is('ajax')) {
	        throw new BadRequestException();
	    }
		$this->autoRender = false;
        $d=array();
		$d['result'] =  0;
        $d['message'] =  "Method _POST seulement.";
        if ($this->request->is('post')) {
            $id = $_POST['value'];
			if ($id=='') {
            	$d['result'] = 0;
                $d['message'] = "Id non défini.";
            } else {
            	$e= $this->Todos->get($id);
				$this->Todos->delete($e);
				$d['result'] =  1;
	            $d['message'] =  "La tâche a été supprimée.";
			}
        }
        echo json_encode($d);
    }
	
}
