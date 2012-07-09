<!--  start page-heading -->
<div id="page-heading">
    <h1>listar Projectos</h1>
</div>

<script type="text/javascript">
    $(document).ready(function(){$("#delete").click(function(){if(!confirm("Queres mesmo apagar?")){return false;}});});
</script>    


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
                    <?= $this->_render('element', 'mensagem'); ?>
                    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
                        <tr>

                            <th class="table-header-repeat line-left minwidth-1"><a href="">Projecto</a>	</th>
                            <th class="table-header-repeat line-left minwidth-1"><a href="">Texto Projecto</a></th>
                            <th class="table-header-repeat line-left"><a href="">Foto Principal</a></th>
                            <th class="table-header-options line-left"><a href="">Options</a></th>
                        </tr>
                        <?php
                        foreach ($projectos as $projecto) {
                            $condicao = '';
                            $acto = 'por na';
                            if ($projecto->featured == TRUE) {
                                $acto = 'tirar da';
                                $condicao = '  style="background-color: #393939"';
                            }


                            echo '<tr">
					
					<td>' . $projecto->titulo . '</td>
					<td>' . $projecto->texto . '</td>
					<td><a href=""><img src="http://admin.biarq.com/img/projectos/pequenas/' . $projecto->fotoprincipal . '"/></td>
					<td' . $condicao . '>
					<a href="http://admin.biarq.com/projectos/editar/' . $projecto->_id . '" title="editar ' . $projecto->titulo . '" class="icon-1 info-tooltip"></a>
					<a  id="delete" href="http://admin.biarq.com/projectos/apagarprojecto/' . $projecto->_id . '" title="apagar ' . $projecto->titulo . '" class="icon-2 info-tooltip"></a>
					<a href="http://admin.biarq.com/projectos/featured/' . $projecto->_id . '" title="' . $acto . ' pagina principal" class="icon-3 info-tooltip"></a>
					
					</td>
				</tr>';
                        }
                        ?>

                    </table>
                    <!--  end product-table................................... --> 