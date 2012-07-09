<script type="text/javascript" src="http://www.google.com/jsapi"></script>

<?php echo $this->Html->script(array("jquery-ui-1.8.16.custom.min_2","http://jqueryui.com/ui/i18n/jquery.ui.datepicker-pt.js")); ?>
<?php echo $this->Html->style("jquery-ui-1.8.16.custom"); ?>


<script type="text/javascript">     
    $(function() {
        $( "#date" ).datepicker( $.datepicker.regional[ "pt" ] );
        $( "#date" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );
        $( "#date2" ).datepicker($.datepicker.regional[ "pt" ] );
       
         $( "#date2" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );
      
    });
</script>


<script type="text/javascript">      
                      
    function drawPieChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Origem');
        data.addColumn('number', 'Visitas');
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
        chart.draw(data, {width: 600, height: 440, is3D: true, title: 'Origem/Visitas'});
    }
                	  	
                      
    function drawBarChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Dia');
        data.addColumn('number', 'Visitas');
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
        chart.draw(data, {'width': 800, 'height': 400, 'is3D': true, 'title': 'Visitas'});
                		
    }
                	  
    google.load("visualization", "1.0", {packages:["corechart"]});
    google.setOnLoadCallback(drawPieChart);
    google.setOnLoadCallback(drawBarChart);

</script>






<!--  start page-heading -->
<div id="page-heading">
    <h1>Estatísticas</h1>
</div>
<!-- end page-heading -->

<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
    <tr>
        <th rowspan="3" class="sized"><img src="http://admin.biarq.com/img/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
        <th class="topleft"></th>
        <td id="tbl-border-top">&nbsp;</td>
        <th class="topright"></th>
        <th rowspan="3" class="sized"><img src="http://admin.biarq.com/img/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
    </tr>
    <tr>
        <td id="tbl-border-left"></td>
        <td>
            <!--  start content-table-inner ...................................................................... START -->
            <div id="content-table-inner">

                <!--  start table-content  -->
                <div id="table-content">

  <?= $this->form->create($datas = NULL, array('method' => 'post')); ?>
                    <?= $this->form->field('Data_Inicial', array('class' => "inp-form",'id'=>'date')); ?>
                   <?= $this->form->field('Data_Final', array('class' => "inp-form",'id'=>'date2')); ?>
                   

                    <?= $this->form->submit('Alterar intervalo de Tempo'); ?>
                    <?= $this->form->end(); ?>
                   

                    <br><br><h3> <?= $full_start_date . " to " . $full_end_date ?></h3>

                    <div id='barchart_div'></div>
                    <div id='piechart_div'></div>

                    <?php
                    echo "<h1>Origens do trafego</h1></br>";

                    echo '<table id="product-table"  border="0" width="100%" cellpadding="0" cellspacing="0" >
                                <tr>
                                    <th class="table-header-repeat line-left">
                                    <a href="">Origem</a>
                                    </th >
                                    <th class="table-header-repeat line-left">
                                    <a href="">Visitas</a>
                                    </th>
                                </tr>';
                    $table_row = 0;
                    foreach ($referrers as $referrer) {
                        if ($table_row % 2) {
                            echo "<tr><td>";
                        } else {
                            echo "<tr><td>";
                        }
                        echo $referrer["source"] . "</td><td>" . number_format($referrer["visits"]) . "</td></tr>";
                        $table_row++;
                    }
                    echo "</table>";
                    
                     echo "<h1>Origens do trafego / Cidade</h1></br>";

                    echo '<table id="product-table"  border="0" width="100%" cellpadding="0" cellspacing="0" >
                                <tr>
                                    <th class="table-header-repeat line-left">
                                    <a href="">Cidade</a>
                                    </th >
                                    <th class="table-header-repeat line-left">
                                    <a href="">Visitas</a>
                                    </th>
                                </tr>';
                    $table_row = 0;
                    foreach ($cidades as $referrer) {
                        if ($table_row % 2) {
                            echo "<tr><td>";
                        } else {
                            echo "<tr><td>";
                        }
                        echo $referrer["city"] . "</td><td>" . number_format($referrer["visits"]) . "</td></tr>";
                        $table_row++;
                    }
                    echo "</table>";
                    ?>

                    
                