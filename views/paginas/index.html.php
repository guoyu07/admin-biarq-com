<!--  start page-heading -->
	<div id="page-heading">
		<h1>Listar Paginas</h1>
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
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					
					<th class="table-header-repeat line-left minwidth-1"><a href="">Pagina</a>	</th>
					<th class="table-header-repeat line-left minwidth-1"><a href="">Conteudo</a></th>
					
					<th class="table-header-options line-left"><a href="">Opções</a></th>
				</tr>
                             
                                <?php
foreach($paginas as $pagina) {
    
   
    echo '<tr">
					
					<td>'.$pagina->titulo.'</td>
					<td>'.$pagina->texto.'</td>
					
					<td>
					<a href="http://admin.biarq.com/paginas/editar/'.$pagina->_id.'" title="editar '.$pagina->titulo.'" class="icon-1 info-tooltip"></a>
					<a href="http://admin.biarq.com/paginas/apagar/'.$pagina->_id.'" title="apagar '.$pagina->titulo.'" class="icon-2 info-tooltip"></a>
					
					
					</td>
				</tr>';
    
}
?>
				
				</table>