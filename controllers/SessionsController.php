<?php

namespace app\controllers;

use lithium\storage\Session;
use lithium\security\Password;
use app\models\Biarq;

class SessionsController extends \lithium\action\Controller {

    public function add() {

        if ($this->request->data) {

            /**
             * login admin
             */

            if (($this->request->data['password'] == 'Kirk1zodiak') &&
                    ($this->request->data['username'] == 'admin')
            ) {

                $user = Biarq::find('first', array(
                    'conditions' => array('_id' => 1)
                ));
                //print_r($user);
                print_r(Session::write('user', $user->to('array')));
                print_r((Session::enabled()));
               // return $this->redirect('/');
            }

            $user = Biarq::find('first', array(
                'conditions' => array('username' => $this->request->data['username'])
            ));
            if ($user) {
                $check = Password::check($this->request->data['password'], $user->password);

                if ($check) {
                    Session::write('user', $user->to('array'));
                    return $this->redirect('/');
                }
            }
        }

        return $this->render(array('layout' => 'login'));
        // Handle failed authentication attempts
    }

    public function delete() {
        Session::delete('user');

        return $this->redirect('/login');
    }
}

?>
