
<!--  start page-heading -->
<div id="page-heading">
    <h1>editar fotos da Galeria</h1>
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
                    <h3>para apagar  da galeria clica na foto</h3>
<?php

foreach ($fotosGaleria as $foto) {

                        echo '<a href="http://admin.biarq.com/Galeria/eliminarfoto/' . $foto . '">' . $this->html->image('projectos/pequenas/' . $foto) . '</a>';
 }
 ?>








<h3>para adicionar a galeria clica na foto</h3>
<?php


 foreach ($fotos as $foto) {

                        echo '<a href="http://admin.biarq.com/Galeria/adicionar/' . $foto . '">' . $this->html->image('projectos/pequenas/' . $foto) . '</a>';
 }
 ?>
