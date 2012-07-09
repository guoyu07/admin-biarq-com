<?php
//so session vars can be used
session_start();

//clientLogin: try to log in user

$_SESSION['sessionToken'] = googleLogin('thesyncim@gmail.com', 'Kirk1zodiak');

//AuthSub: exchange token for session token so multiple calls can be made to api
if (isset($_REQUEST['token'])) {
    $_SESSION['authSub'] = true;
     echo '<pre>';
print_r($_REQUEST['token']);
echo '</pre>';
   // $_SESSION['sessionToken'] = get_session_token($_REQUEST['token']);
   
}

    

if (isset($_REQUEST['logout'])) {
    //clear session vars to start fresh
    session_unset();
}
//set form vars
$start_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 31, date("Y")));
    $end_date = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
    //$start_date = $_POST['startdate'];
    //$end_date = $_POST['enddate'];
    $posttableid = 'ga:52850742|biarq';
    $table_Id = substr('ga:52850742|biarq', 0, strpos('ga:52850742|biarq', "|"));
     if(!isset($graph_type)) $graph_type = 'date';

//format date inputs for output on page
$start_date_parts = explode("-", $start_date);
$end_date_parts = explode("-", $end_date);

$full_start_date = date("d-F-y", mktime(0, 0, 0, $start_date_parts[1], $start_date_parts[2], $start_date_parts[0]));
$ga_start_date = date("Y-m-d", mktime(0, 0, 0, $start_date_parts[1], $start_date_parts[2], $start_date_parts[0]));

$full_end_date = date("d-F-y", mktime(0, 0, 0, $end_date_parts[1], $end_date_parts[2], $end_date_parts[0]));
$ga_end_date = date("Y-m-d", mktime(0, 0, 0, $end_date_parts[1], $end_date_parts[2], $end_date_parts[0]));

//checks for valid date
function checkdaterange($start_date, $end_date) {
    $errormsg = "valid";

    if ($start_date > $end_date)
        $errormsg = "invalid";

    return $errormsg;
}

//returns sessionToken for multiple calls to API
function googleLogin($email, $passwd) {

    $clientlogin_url = "https://www.google.com/accounts/ClientLogin";
    $clientlogin_post = array(
        "accountType" => "GOOGLE",
        "Email" => $email,
        "Passwd" => $passwd,
        "service" => "analytics",
        "source" => "my-analytics"
    );

    $curl = curl_init($clientlogin_url);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $clientlogin_post);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($curl);

    preg_match("/Auth=([a-z0-9_\-]+)/i", $response, $matches);
    $sessionToken = $matches[1];

    if (strlen($sessionToken) == 0) {
        $sessionToken = "Authentication Failed.";
    }

    return $sessionToken;
}

//returns session token for multiple calls to API
function get_session_token($onetimetoken) {
    $output = call_api($onetimetoken, "https://www.google.com/accounts/AuthSubSessionToken");

    if (preg_match("/Token=(.*)/", $output, $matches)) {
        $sessionToken = $matches[1];
    } else {
        echo "Error authenticating with Google.";
        exit;
    }

    return $sessionToken;
}

//gets the data
function call_api($sessionToken, $url) {
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    if (isset($_SESSION['authSub'])) {
        $curlheader[0] = sprintf("Authorization: AuthSub token=\"%s\"/n", $sessionToken);
    } else {
        $curlheader[0] = "Authorization: GoogleLogin auth=" . $sessionToken;
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, $curlheader);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

//returns accounts list as array	
function parse_account_list($xml) {
    $doc = new DOMDocument();
    if (stripos($xml, "<") !== FALSE) {
        $doc->loadXML($xml);

        $entries = $doc->getElementsByTagName('entry');
        $i = 0;
        $profiles = array();
        foreach ($entries as $entry) {
            $profiles[$i] = array();

            $title = $entry->getElementsByTagName('title');
            $profiles[$i]["title"] = $title->item(0)->nodeValue;

            $entryid = $entry->getElementsByTagName('id');
            $profiles[$i]["entryid"] = $entryid->item(0)->nodeValue;

            $tableId = $entry->getElementsByTagName('tableId');
            $profiles[$i]["tableId"] = $tableId->item(0)->nodeValue;

            $i++;
        }
        return $profiles;
    } else {
        $sessionToken = "Authentication Failed.";
    }
}

//returns data as array	
function parse_data($xml) {
    $doc = new DOMDocument();
    $doc->loadXML($xml);

    $entries = $doc->getElementsByTagName('entry');
    $i = 0;
    $results = array();
    foreach ($entries as $entry) {

        $dimensions = $entry->getElementsByTagName('dimension');
        foreach ($dimensions as $dimension) {
            $results[$i][ltrim($dimension->getAttribute("name"), "ga:")] = $dimension->getAttribute('value');
        }

        $metrics = $entry->getElementsByTagName('metric');
        foreach ($metrics as $metric) {
            $results[$i][ltrim($metric->getAttribute('name'), "ga:")] = $metric->getAttribute('value');
        }

        $i++;
    }
    return $results;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Google Analytics with Google Charts - PHP</title>

        <script type="text/javascript" src="http://www.google.com/jsapi"></script>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>

        <link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css">

            <!--put your own CSS here -->
           
            <style>
                div.ui-datepicker {
                    font-size: 75%;
                }
            </style>
            <script type="text/javascript" language="javascript">
                $().ready(function() {
                    $("#startdate").datepicker({showOn: 'button', buttonImage: 'SmallCalendar.gif',  buttonImageOnly: true, dateFormat: 'dd-MM-yy',changeMonth: true,changeYear: true,
                        altField: '#start_alternate',altFormat: 'yy-mm-dd',minDate: new Date(2006, 8 - 1, 1),maxDate: -1});
                    $("#enddate").datepicker({showOn: 'button', buttonImage: 'SmallCalendar.gif',  buttonImageOnly: true, dateFormat: 'dd-MM-yy',changeMonth: true,changeYear: true,altField: '#end_alternate',altFormat: 'yy-mm-dd',minDate: new Date(2006, 8 - 1, 2),maxDate: -1});	
	
                });
            </script>

    </head>
    <body>
        <div id="wrapper">

            <div id="header" class="container_16">
                <h1><span>Google Analytics</span> Web Stats &amp; Google Charts <span>PHP</span></h1>
            </div>

            <div id="content-wrap" class="container_16">   

                <?php {
                    $accountxml = call_api($_SESSION['sessionToken'], "https://www.google.com/analytics/feeds/accounts/default");
                    // Get an array with the available accounts
                    $profiles = parse_account_list($accountxml);

                    echo "<div class='grid_6 prefix_5 suffix_5'>";
                    echo "<div id='logout'><a href='" . $_SERVER['PHP_SELF'] . "?logout=1'>Log out</a></div>";
                    echo "<h2>Select Site and Date Range</h2>";
                    ?>

                    <p><label for='startdate'>Start Date:</label>
                        <input id='startdate' readonly='readonly' type='text' value='<?php echo $full_start_date; ?>' /><input type='hidden' name='startdate' id='start_alternate' value='<?php echo $ga_start_date; ?>' /></p>
                    <p><label for='enddate'>End Date:</label>
                        <input id='enddate' readonly='readonly' type='text' value='<?php echo $full_end_date; ?>' /><input type='hidden' name='enddate' id='end_alternate' value='<?php echo $ga_end_date; ?>' /></p>
                    <p><label for='graphtype'>Visitor Graph Type:</label>
                        <input id="radio_month" type="radio" name="graphtype" value="month" checked="checked" />Month
                        <input id="radio_day" type="radio" name="graphtype" value="date" <?php if ($graph_type == 'date') echo "checked='checked'"; ?> />Day</p>
                    <p><input type='submit' value='Submit' /></p></form>

                </div>
    <?php
}

if (isset($posttableid)) {
    echo "<div class='grid_16' style='margin-top: 1em;'>";

    $website = substr(strrchr($posttableid, "|"), 1);
    $tableId = substr($posttableid, 0, strpos($posttableid, "|"));

    if (checkdaterange($start_date, $end_date) == "invalid") {
        echo "<p class='errorMessage'>Date range of " . $full_start_date . " to " . $full_end_date . " is invalid. Please reselect the dates.</p>";
        exit;
    } else {

        $visits_graph_type = $graph_type;

        echo "<h1 style='text-transform:uppercase'>" . $website . "<br /><span style='color: #999999'>";
        echo "" . $full_start_date . " to " . $full_end_date . "</span></h1>";

        // For each website, get visits and visitors
        $requrlvisits = sprintf("https://www.google.com/analytics/feeds/data?ids=%s&metrics=ga:visits,ga:visitors&start-date=%s&end-date=%s", $tableId, $start_date, $end_date);

        $visitsxml = call_api($_SESSION['sessionToken'], $requrlvisits);

        $visits = parse_data($visitsxml);

        foreach ($visits as $visit) {
            echo "<h2>Visits: " . number_format($visit["visits"]) . "</h2><h2>Visitors: " . number_format($visit["visitors"]) . "</h2>";
        }

        echo "<div id='barchart_div'></div>";
        echo "<div id='piechart_div'></div>";

        // For each website, get referrals
        $requrl = sprintf("https://www.google.com/analytics/feeds/data?ids=%s&dimensions=ga:source&metrics=ga:visits&filters=ga:medium==referral&start-date=%s&end-date=%s&sort=-ga:visits&max-results=10", $tableId, $start_date, $end_date);

        $referralsxml = call_api($_SESSION['sessionToken'], $requrl);
        $referrers = parse_data($referralsxml);

        echo "<h1>Referrers</h1>";

        echo "<table width='75%' class='dataTable listTable'><tr class='headerRow'><th>Referrer</th><th>Visits</th></tr>";
        $table_row = 0;
        foreach ($referrers as $referrer) {
            if ($table_row % 2) {
                echo "<tr><td>";
            } else {
                echo "<tr class='oddrow'><td>";
            }
            echo $referrer["source"] . "</td><td class='visits'>" . number_format($referrer["visits"]) . "</td.</tr>";
            $table_row++;
        }
        echo "</table>";

        // For each website, get visits graph data
        if ($visits_graph_type == "date") {
            $requrlvisitsgraph = sprintf("https://www.google.com/analytics/feeds/data?ids=%s&dimensions=ga:date&metrics=ga:visits&start-date=%s&end-date=%s", $tableId, $start_date, $end_date);
        } else {
            $requrlvisitsgraph = sprintf("https://www.google.com/analytics/feeds/data?ids=%s&dimensions=ga:month,ga:year&metrics=ga:visits&sort=ga:year&start-date=%s&end-date=%s", $tableId, $start_date, $end_date);
        }

        $visitsgraphxml = call_api($_SESSION['sessionToken'], $requrlvisitsgraph);
        $visitsgraph = parse_data($visitsgraphxml);
        ?>

                    <script type="text/javascript">      
                      
                        function drawPieChart() {
                            var data = new google.visualization.DataTable();
                            data.addColumn('string', 'Referrer');
                            data.addColumn('number', 'Visits');
                            data.addRows(<?php echo sizeof($referrers) ?>);
        <?php
        $row = 0;
        foreach ($referrers as $referrer) {
            ?>
                                    data.setValue(<?php echo $row ?>,0,'<?php echo $referrer["source"] ?>');
                                    data.setValue(<?php echo $row ?>,1,<?php echo $referrer["visits"] ?>);
            <?php
            $row++;
        }
        ?>

                            var chart = new google.visualization.PieChart(document.getElementById('piechart_div'));
                            chart.draw(data, {width: 600, height: 440, is3D: true, title: 'Referrer/Visits'});
                        }
                	  	
                      
                        function drawBarChart() {
                            var data = new google.visualization.DataTable();
                            data.addColumn('string', 'Day');
                            data.addColumn('number', 'Visits');
                            data.addRows(<?php echo sizeof($visitsgraph) ?>);
        <?php
        $row = 0;
        foreach ($visitsgraph as $visits) {
            ?>
                        data.setValue(<?php echo $row ?>,0,'<?php
            if ($visits_graph_type == "month") {
                echo date("M", mktime(0, 0, 0, $visits["month"])) . " " . $visits["year"];
            } else {
                echo substr($visits['date'], 6, 2) . "-" . date('M', mktime(0, 0, 0, substr($visits['date'], 4, 2))) . "-" . substr($visits['date'], 0, 4);
            }
            ?>');
                        data.setValue(<?php echo $row ?>,1,<?php echo $visits["visits"] ?>);
            <?php
            $row++;
        }
        ?>
                var chart = new google.visualization.ColumnChart(document.getElementById('barchart_div'));
                chart.draw(data, {'width': 700, 'height': 400, 'is3D': true, 'title': 'Visits'});
                		
            }
                	  
            google.load("visualization", "1.0", {packages:["corechart"]});
            google.setOnLoadCallback(drawPieChart);
            google.setOnLoadCallback(drawBarChart);

                    </script>
                    <?php
                }
            }
            ?>
        </div>
        </div>

        </div>
    </body>
</html>