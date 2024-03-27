<?php

namespace App\Controller;

use App\Model\Table\LogDetailesTable;

use App\Controller\AppController;


class HomePageController extends AppController
{






    public function index()
    {

        $this->viewBuilder()->setLayOut('');

        $this->loadModel('TeamLeaders');
        $this->loadModel('Users');
        $this->loadModel('LogDetailes');

        $user_id = $this->Auth->User('id');
        $personalDetailes = $this->Users->find('all')->where(['id' => $user_id])->first();
        //print_r($personalDetailes);
        //exit;
        $leaders = $this->TeamLeaders->find('all')->toArray();



        $currentDate = date('Y-m-d');
        // echo $currentDate;
        $detailes = $this->LogDetailes->find('all')
            ->where(['user_id' => $user_id, 'Date(date_time)' => $currentDate])
            ->first();
        // print_r($detailes);exit;


        $this->set(compact('leaders'));
        $this->set(compact('detailes'));
        $this->set(compact('personalDetailes'));
    }




    public function  addingTime()
    {

        if ($this->request->is('post')) {

            $user_id = $this->Auth->User('id');


            $this->loadModel('LogDetailes');
            if (!empty($this->request->data['login_time'])) {
                $this->request->data['user_id'] = $user_id;
                $log = $this->LogDetailes->newEntity();
                $log = $this->LogDetailes->patchEntity($log, $this->request->data);
                $this->LogDetailes->save($log);
                $this->Flash->success(__('You Submitted LogIn Time.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $currentDate = date('Y-m-d');
                $detailes = $this->LogDetailes->find('all')->where(['user_id' => $user_id, 'DATE(date_time)' => $currentDate])->first();
                $data = $this->request->data;
                $this->LogDetailes->updateAll([
                    'logout_time' => $data['logout_time'],
                    'logout_intimate' => $data['logout_intimate']
                ], ['id' => $detailes['id']]);
                $this->Flash->success(__('You Submitted LogOut Time.'));
                return $this->redirect(['action' => 'index']);
            }
        }
    }
}
