<?php

namespace app\controllers;

use app\models\Biarq;
use lithium\storage\Session;
use app\libraries\Google\Analytics;
use app\models\Mensagens;
use lithium\security\Password;

class BiarqController extends \lithium\action\Controller {

    public function _init() {

        parent::_init();
        if (!Session::read('user'))
            print_r(Session::read('user'));
           // $this->redirect('Sessions::add');
    }

    /**
     *
     * @return type
     */
    public function inbox() {
        $mensagens = Mensagens::find('all');


       
        return compact('mensagens');
    }

    /**
     *
     * @return type
     */
    public function index() {



        $user = Biarq::find('first', array(
                    'conditions' => array('_id' => 1)
                ));

        if (($this->request->data)) {


            $user = Biarq::find('first', array(
                        'conditions' => array('_id' => 1)
                    ));
            $user->username = $this->request->data['username'];
            if ($this->request->data['password'] != '') {
                $user->password = Password::hash($this->request->data['password']);
            }
            $user->Nome_Site = $this->request->data['Nome_Site'];
            $user->Keywords = $this->request->data['Keywords'];
            $user->Nome_Utilizador = $this->request->data['Nome_Utilizador'];
            $user->Site_title = $this->request->data['Site_title'];

            $user->Email_Formulario = $this->request->data['Email_Formulario'];
            $user->Google_Analytics_Id = $this->request->data['Google_Analytics_Id'];
            $user->save();





            return $this->redirect('Biarq::index');
        }
        return compact('user', 'userstrue', 'userseditartrue');
    }

    public function apagarsms($id) {
        Mensagens::remove(array('_id' => $id));
        $this->redirect('Biarq::inbox');
    }

    /**
     *
     * @return type
     */
    public function stats() {

        $user = Session::read("user");
        $Google_Analytics_Id = $user['Google_Analytics_Id'];


        $analytics = new Analytics();
        if (!Session::read('sessionToken')) {
            Session::write(
                    'sessionToken', $analytics->googleLogin('thesyncim@gmail.com', 'Kirk1zodiak'));
        }
        if ($this->request->data) {
            $start_date = $this->request->data['Data_Inicial'];
            $end_date = $this->request->data['Data_Final'];
        }



        //$start_date = $_POST['startdate'];
        //$end_date = $_POST['enddate'];
        $siteid = $Google_Analytics_Id;
        if ((!isset($start_date) && !isset($end_date))) {

            //set form vars
            $start_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 31, date("Y")));
            $end_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        }

        if (!isset($visits_graph_type))
            $visits_graph_type = 'date';

//format date inputs for output on page
        $start_date_parts = explode("-", $start_date);
        $end_date_parts = explode("-", $end_date);

        $full_start_date = date("d-F-y", mktime(0, 0, 0, $start_date_parts[1], $start_date_parts[2], $start_date_parts[0]));
        $ga_start_date = date("Y-m-d", mktime(0, 0, 0, $start_date_parts[1], $start_date_parts[2], $start_date_parts[0]));

        $full_end_date = date("d-F-y", mktime(0, 0, 0, $end_date_parts[1], $end_date_parts[2], $end_date_parts[0]));
        $ga_end_date = date("Y-m-d", mktime(0, 0, 0, $end_date_parts[1], $end_date_parts[2], $end_date_parts[0]));



        $tableId = substr($siteid, 0, strpos($siteid, "|"));


        $requrlvisits = sprintf(
                "https://www.google.com/analytics/feeds/data?ids=%s&metrics=ga:visits,ga:visitors&start-date=%s&end-date=%s", $tableId, $start_date, $end_date);

        $visitsxml = $analytics->call_api(Session::read('sessionToken'), $requrlvisits);
        $visits = $analytics->parse_data($visitsxml);


        //get trafic referalls
        $requrl = sprintf(
                "https://www.google.com/analytics/feeds/data?ids=%s&dimensions=ga:source&metrics=ga:visits&filters=ga:medium==referral&start-date=%s&end-date=%s&sort=-ga:visits&max-results=10", $tableId, $start_date, $end_date);
        $referralsxml = $analytics->call_api(Session::read('sessionToken'), $requrl);
        $referrers = $analytics->parse_data($referralsxml);

        $cidades = sprintf("https://www.google.com/analytics/feeds/data?ids=%s&dimensions=ga:city&metrics=ga:visits&sort=-ga:visits&start-date=%s&end-date=%s&max-results=20", $tableId, $start_date, $end_date);
        $a = $analytics->call_api(Session::read('sessionToken'), $cidades);
        $cidades = $analytics->parse_data($a);



        if ($visits_graph_type == "date") {
            $requrlvisitsgraph = sprintf("https://www.google.com/analytics/feeds/data?ids=%s&dimensions=ga:date&metrics=ga:visits&start-date=%s&end-date=%s", $tableId, $start_date, $end_date);
        } else {
            $requrlvisitsgraph = sprintf("https://www.google.com/analytics/feeds/data?ids=%s&dimensions=ga:month,ga:year&metrics=ga:visits&sort=ga:year&start-date=%s&end-date=%s", $tableId, $start_date, $end_date);
        }

        $visitsgraphxml = $analytics->call_api(Session::read('sessionToken'), $requrlvisitsgraph);
        $visitsgraph = $analytics->parse_data($visitsgraphxml);

        return compact('visitsgraph', 'referrers', 'visits_graph_type', 'full_end_date', 'full_start_date', 'cidades');
    }

}

?>