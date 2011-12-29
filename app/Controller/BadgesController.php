<?php
App::uses('AppController', 'Controller');
/**
 * Badges Controller
 *
 * @property Badge $Badge
 */
class BadgesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Badge->recursive = 0;
		$this->set('badges', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Badge->id = $id;
		if (!$this->Badge->exists()) {
			throw new NotFoundException(__('Invalid badge'));
		}
		$this->set('badge', $this->Badge->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Badge->create();
			if ($this->Badge->save($this->request->data)) {
				$this->Session->setFlash(__('The badge has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The badge could not be saved. Please, try again.'));
			}
		}
		$users = $this->Badge->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Badge->id = $id;
		if (!$this->Badge->exists()) {
			throw new NotFoundException(__('Invalid badge'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Badge->save($this->request->data)) {
				$this->Session->setFlash(__('The badge has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The badge could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Badge->read(null, $id);
		}
		$users = $this->Badge->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Badge->id = $id;
		if (!$this->Badge->exists()) {
			throw new NotFoundException(__('Invalid badge'));
		}
		if ($this->Badge->delete()) {
			$this->Session->setFlash(__('Badge deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Badge was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Badge->recursive = 0;
		$this->set('badges', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Badge->id = $id;
		if (!$this->Badge->exists()) {
			throw new NotFoundException(__('Invalid badge'));
		}
		$this->set('badge', $this->Badge->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Badge->create();
			if ($this->Badge->save($this->request->data)) {
				$this->Session->setFlash(__('The badge has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The badge could not be saved. Please, try again.'));
			}
		}
		$users = $this->Badge->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Badge->id = $id;
		if (!$this->Badge->exists()) {
			throw new NotFoundException(__('Invalid badge'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Badge->save($this->request->data)) {
				$this->Session->setFlash(__('The badge has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The badge could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Badge->read(null, $id);
		}
		$users = $this->Badge->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Badge->id = $id;
		if (!$this->Badge->exists()) {
			throw new NotFoundException(__('Invalid badge'));
		}
		if ($this->Badge->delete()) {
			$this->Session->setFlash(__('Badge deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Badge was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
