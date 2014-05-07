<?php
App::uses('AppController', 'Controller');
/**
 * Events Controller
 *
 * @property Event $Event
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class EventsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Event->recursive = 0;
		$this->set('events', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid event'));
		}
		$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
		$this->set('event', $this->Event->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
         if (!$this->Event->exists($id)) {
           
			throw new NotFoundException(__('Invalid event'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('The event has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
			$this->request->data = $this->Event->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		$this->request->is('post');
		if ($this->Event->delete($id)) {
			$this->Session->setFlash(__('The event has been deleted.'));
		} else {
			$this->Session->setFlash(__('The event could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	public function event(){
        $this->autoRender=false;
        $user_id=$this->Auth->user('id');
        $events=$this->Event->find('all',array('conditions'=>array('Event.user_id'=>$user_id)));
        foreach ($events as $key => $event) {
                   $events_arr[$key]=$event['Event'];
        }
        echo json_encode($events_arr);
    }
    
    public function add_event(){
        if (!empty($this->request->data)) {
            if ($this->request->is('post')) {
                    $this->request->data['Event']['user_id'] = $this->Auth->user('id');
                        if ($this->Event->save($this->request->data)) {
                            $this->Session->setFlash('Your event has been saved.');
                            $this->redirect(array('action' => 'index'));
                        }
            }
        }
    }
   	public function add() {
        if ($this->request->is('post')) {
			$this->Event->create();
			$_POST['user_id'] = $this->Auth->user('id');
			if ($this->Event->save($_POST)) {
			} else {
				
			}
		}	
    }
    public function calendar($year=null,$month=null,$day=null) {
            if ($year!=null) {
                $this->set('openYear',$year);
                if ($month!=null) {
                    $month = ltrim($month,'0');
                    $month = $month-1;
                    $this->set('openMonth',$month);
                }
                if ($day!=null){
                    $day = ltrim($day,'0');
                    $this->set('openDay',$day);
                }   
            }
    }
    public function resize ($id=null,$dayDelta,$minDelta) {
        if ($id!=null) {
            $ev = $this->Event->findById($id);
            $ev['Event']['end']=date('Y-m-d H:i:s',strtotime($dayDelta.' days '.$minDelta.' minutes',strtotime($ev['Event']['end'])));
            $this->Event->save($ev);
        }
        $this->redirect(array('controller' => "events", 'action' => "calendar",substr($ev['Event']['start'],0,4),substr($ev['Event']['start'],5,2),substr($ev['Event']['start'],8,2)));
    }
    public function feed() {
        $mysqlstart = date( 'Y-m-d H:i:s', $this->params['url']['start']);
        $mysqlend = date('Y-m-d H:i:s', $this->params['url']['end']);
        $conditions = array('Event.start BETWEEN ? AND ?'
                        => array($mysqlstart,$mysqlend));
        $events = $this->Event->find('all',array('conditions' =>$conditions));
        foreach($events as $event) {
            if($event['Event']['all_day'] == 1) {
                $allday = true;
                $end = $event['Event']['start'];
            } else {
                $allday = false;
                $end = $event['Event']['end'];
            }
            $data[] = array(
                    'id' => $event['Event']['id'],
                    'title'=>$event['Event']['title'],
                    'details' => $event['Event']['details'],
                    'start'=>$event['Event']['start'],
                    'end' => $end,
                    'allDay' => $allday,
                    'url' => Router::url('/') . 'CAKECALENDAR/app/view/Events'.$event['Event']['id'],
                    'className' => $event['EventType']['color']
            );
        }
        $this->set("json", json_encode($data));
    }
     }
?>