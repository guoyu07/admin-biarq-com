
<!--  start nav -->
		<div class="nav">
		<div class="table">
		<ul <?php if(isset($projectostrue)) echo ' class="current"';else echo 'class="select"'; ?> ><li><a href="http://admin.biarq.com/Projectos"><b>Projectos</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub <?php if(isset($projectostrue)) echo ' show' ?>">
			<ul class="sub">
				<li <?php if(isset($projectostrue) && isset($projectosindextrue))echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/Projectos">Listar Projectos</a></li>
				<li <?php if(isset($projectostrue) && isset($projectosadicionartrue))echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/Projectos/adicionar">Adicionar Projecto</a></li>
				<li <?php if(isset($projectostrue) && isset($projectosordenartrue))echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/Projectos/ordenar">Ordenar Projectos</a></li>
				
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		<div class="nav-divider">&nbsp;</div>   
		<ul <?php if(isset($paginastrue)) echo ' class="current"';else echo 'class="select"'; ?> ><li><a href="http://admin.biarq.com/Paginas"><b>Paginas</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub <?php if(isset($paginastrue)) echo ' show' ?>">
			<ul class="sub">
				<li <?php if(isset($paginastrue) && isset($paginasindextrue))echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/Paginas">Listar Paginas</a></li>
				<li <?php if(isset($paginastrue) && isset($paginasadicionartrue))echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/Paginas/adicionar">Adicionar Paginas</a></li>
				<li <?php if(isset($paginastrue) && isset($paginasordenartrue))echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/Paginas/ordenar">Ordenar Paginas</a></li>
				
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
                <div class="nav-divider">&nbsp;</div>   
		 
		<ul <?php if(isset($galeriatrue)) echo ' class="current"';else echo 'class="select"'; ?> ><li><a href="http://admin.biarq.com/galeria"><b>Galeria</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub <?php if(isset($galeriatrue)) echo ' show' ?>">
			<ul class="sub">
				<li <?php if(isset($galeriatrue) && isset($galeriaindextrue))echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/galeria">Actualizar Galeria</a></li>
				<li <?php if(isset($galeriatrue) && isset($galeriaeditartrue))echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/galeria/editar">Editar Texto</a></li>
				
			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		                
		
		
		
		
		
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
		</div>
		<!--  start nav -->