<!--  start page-heading -->
<div id="page-heading">
    <h1>list alliances</h1>
</div>

<script type="text/javascript">
    $(document).ready(function(){$("#delete").click(function(){if(!confirm("really?")){return false;}});});
</script>    


<!-- end page-heading -->

<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
    <tr>
        <th rowspan="3" class="sized"><img src="http://develop.azorestv.com/img/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
        <th class="topleft"></th>
        <td id="tbl-border-top">&nbsp;</td>
        <th class="topright"></th>
        <th rowspan="3" class="sized"><img src="http://develop.azorestv.com/img/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
    </tr>
    <tr>
        <td id="tbl-border-left"></td>
        <td>
            <!--  start content-table-inner ...................................................................... START -->
            <div id="content-table-inner">

                <!--  start table-content  -->
                <div id="table-content">
                    <?= $this->_render('element', 'mensagem'); ?>
                    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
                        <tr>

                            <th class="table-header-repeat line-left minwidth-1"><a href="">Name</a>	</th>
                            <th class="table-header-repeat line-left minwidth-1"><a href="">Power</a></th>
                            <th class="table-header-repeat line-left"><a href="">Overlord</a></th>
                            <th class="table-header-options line-left"><a href="">Options</a></th>
                        </tr>
                        <?php
                     //   echo $player;
                        
                        foreach ($alliances as $projecto) {
                            $condicao = '';
                            $acto = 'por na';
                            if ($projecto->featured == TRUE) {
                                
                                $condicao = '  style="background-color: #393939"';
                            }


                            echo '<tr">
					
					<td><a href="http://develop.azorestv.com/alliances/listplayers/' . $projecto->_id . '" title="list ' . $projecto->name . '" class="info-tooltip">' . $projecto->name . '</a></td>
					<td>' . $projecto->power . '</td>
					<td>' . $projecto->overlord . '</td>
					<td' . $condicao . '>
					<a href="http://develop.azorestv.com/alliances/editar/' . $projecto->_id . '" title="edit ' . $projecto->name . '" class="icon-1 info-tooltip"></a>
					<a  id="delete" href="http://develop.azorestv.com/alliances/apagaralliance/' . $projecto->_id . '" title="delete ' . $projecto->name . '" class="icon-2 info-tooltip"></a>
					<a href="http://develop.azorestv.com/alliances/featured/' . $projecto->_id . '" title=" add player" class="icon-3 info-tooltip"></a>
					
					</td>
				</tr>';
                        }
                        ?>

                    </table>
                    <!--  end product-table................................... --> 