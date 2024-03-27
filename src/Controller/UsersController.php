<?php

namespace App\Controller;

use App\Controller\AppController;


class UsersController extends AppController
{


    public function registration()
    {
        $this->viewBuilder()->setLayout('');
        if ($this->request->is('post')) {
            $this->loadModel('Users');



            $userDetailes = $this->Users->find('all')->where(['employee_id' => $this->request->data['employee_id']])->first();

            if (empty($userDetailes)) {
                $user = $this->Users->newEntity();
                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('You have Registered successfully.'));
                    return $this->redirect(['action' => 'login']);
                }
            } else {
                $this->Flash->error(__('You already Registered.'));
                //return $this->redirect(['action' => 'registration']);
            }
        }
    }


    public function login()
    {
        $this->viewBuilder()->setLayout('');


        if ($this->request->is('post')) {
            $this->loadModel('Users');
            $user = $this->Auth->identify();
            //print_r($user);exit;
            if ($user) {
                $this->Auth->setUser($user);
                $this->Flash->success(__('Login successful.'));
                return $this->redirect(['controller' => 'HomePage', 'action' => 'index',]);
                // echo "<script>alert('Login successful.');</script>";

            } else {
                $this->Flash->error(__('Invalid username or password, try again'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login', 'error' => 'Invalid email or password']);

                //  echo "back to login";exit;
            }
        }
    }

    public function logout()
    {
        $this->viewBuilder()->setLayout('');
        //$this->Auth->logout();
        $this->Flash->success(__('Logout successful.'));
        return $this->redirect($this->Auth->logout());
        // return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
}
