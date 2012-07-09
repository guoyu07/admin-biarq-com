<?php

namespace app\controllers;

use lithium\security\Auth;
use app\models\Biarq;
use lithium\storage\Session;
use app\libraries\Google\Analytics;

class UtilizadoresController extends \lithium\action\Controller {
     public function _init() {

        parent::_init();
        if (!Session::read('user'))
            $this->redirect('Sessions::add');
    }

    /**
     *
     * @return type 
     */
    public function index() {
        $userstrue = TRUE;
        $usersindextrue = TRUE;
        

        return compact('userstrue', 'usersindextrue');
    }

    /**
     *
     * @return type 
     */
    public function editar() {
        $userstrue = TRUE;
        $usersadicionartrue = TRUE;
        $user = Biarq::find('first', array(
                        'conditions' => array('_id' => 1)
                    ));

        if (($this->request->data) && $user->save()) {
            return $this->redirect('Utilizadores::index');
        }
        return compact('user', 'userstrue', 'userseditartrue');
    }

    public function settings() {
        
        
        
        
        
    }

    /**
     * 
     */
    public function stats() {
        $analytics = new Analytics();
        if(!Session::read('sessionToken')){
             Session::write('sessionToken', $analytics->googleLogin('thesyncim@gmail.com', 'Kirk1zodiak'));

        }
        if($this->request->data){
             $start_date = $this->request->data['Data_Inicial'];
        $end_date = $this->request->data['Data_Final'];
            
        }
       

       
        //$start_date = $_POST['startdate'];
        //$end_date = $_POST['enddate'];
        $siteid = 'ga:52850742|biarq';
        if((!isset($start_date) && !isset($end_date))){
        
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


        $requrlvisits = sprintf("https://www.google.com/analytics/feeds/data?ids=%s&metrics=ga:visits,ga:visitors&start-date=%s&end-date=%s", $tableId, $start_date, $end_date);

        $visitsxml = $analytics->call_api(Session::read('sessionToken'), $requrlvisits);
        $visits = $analytics->parse_data($visitsxml);


        //get trafic referalls
        $requrl = sprintf("https://www.google.com/analytics/feeds/data?ids=%s&dimensions=ga:source&metrics=ga:visits&filters=ga:medium==referral&start-date=%s&end-date=%s&sort=-ga:visits&max-results=10", $tableId, $start_date, $end_date);
        $referralsxml = $analytics->call_api(Session::read('sessionToken'), $requrl);
        $referrers = $analytics->parse_data($referralsxml);


        if ($visits_graph_type == "date") {
            $requrlvisitsgraph = sprintf("https://www.google.com/analytics/feeds/data?ids=%s&dimensions=ga:date&metrics=ga:visits&start-date=%s&end-date=%s", $tableId, $start_date, $end_date);
        } else {
            $requrlvisitsgraph = sprintf("https://www.google.com/analytics/feeds/data?ids=%s&dimensions=ga:month,ga:year&metrics=ga:visits&sort=ga:year&start-date=%s&end-date=%s", $tableId, $start_date, $end_date);
        }

        $visitsgraphxml = $analytics->call_api(Session::read('sessionToken'), $requrlvisitsgraph);
        $visitsgraph = $analytics->parse_data($visitsgraphxml);

        return compact('visitsgraph', 'referrers', 'visits_graph_type', 'full_end_date', 'full_start_date');
    }

}

?>