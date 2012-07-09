<?php

namespace app\controllers;

use lithium\storage\Session;
use app\models\Alliances as Alliances;
use app\models\Players as Players;
use li3_player\extensions\Player;

class alliancesController extends \lithium\action\Controller {

    public function _init() {

        parent::_init();
        /*
         * 
         * if (!Session::read('user'))
          $this->redirect('Sessions::add');


          alliances::applyFilter('save', function($self, $params, $chain) {

          //Temporarily store our entity object so that we can manipulate it
          $record = $params['entity'];

          //If an id doesn't exist yet, then we know we're saving for the first time. If a
          //password is provided, we need to hash it
          var_dump($record->foto);

          //Write the modified object back to $params
          $params['entity'] = $record;

          //Allow the next filter to be run
          return $chain->next($self, $params, $chain);
          });
         * 
         * 
         */
    }

    public function index() {

        
        $alliances = alliances::find('all', array(
                    'order' => array('ordem' => 'ASC')
                ));
        $alliancestrue = TRUE;
        $alliancesindextrue = TRUE;
        return compact('alliances', 'alliancestrue', 'alliancesindextrue', 'player');
    }

    public function adicionar() {

        $alliancestrue = TRUE;
        $alliancesadicionartrue = TRUE;

        if ($this->request->data) {
            $alliances = alliances::create();
            $alliances->name = $this->request->data['name'];
            $alliances->power = $this->request->data['power'];
            $alliances->overlord = $this->request->data['overlord'];



            if ($alliances->save()) {
                Session::write('message', array('status' => 'green', 'msg' => 'projecto ' . $alliances->name . ' successfully added '));
            } else {
                Session::write('message', array('status' => 'red', 'msg' => 'error ' . $alliances->name));
            }
            $this->redirect('alliances::index');


            //$success = $post->save();
        }

        return compact('alliancesadicionartrue', 'alliancestrue');
    }

    public function apagaralliance($id) {



        if (alliances::remove(array('_id' => $id))) {
            Session::write('message', array('status' => 'green', 'msg' => 'Alliance ' . $projecto->name . ' successfully deleted'));
        } else {
            Session::write('message', array('status' => 'red', 'msg' => 'error ' . $projecto->name));
        }
        $this->redirect('alliances::index');
    }

    public function editar($id) {
        $alliances = alliances::find('first', array(
                    'conditions' => array('_id' => $id)
                ));

        if ($this->request->data) {

            $alliances->name = $this->request->data['name'];
            $alliances->power = $this->request->data['power'];
            $alliances->overlord = $this->request->data['overlord'];


            if ($alliances->save()) {
                Session::write('message', array('status' => 'green', 'msg' => 'projecto ' . $alliances->titulo . ' editado com sucesso'));
            } else {
                Session::write('message', array('status' => 'red', 'msg' => 'Falha ao editar ' . $alliances->titulo));
            }
            $this->redirect('alliances::index');
        }


        $alliancestrue = TRUE;
        return compact('alliances', 'alliancestrue');
    }

    public function listplayers($id) {
        $players = Players::find('all', array(
                    'order' => array('power' => 'ASC'),
                    'conditions' => array('alliance' => $id)
                ));


        return compact('players');
    }

}

?>