<?php $print_r = function($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
};
//$print_r($this->_request->action);
?>
<!--  start nav -->

		<div class="nav">
		<div class="table">
		<ul <?php if(ucwords($this->_request->controller) == ucwords('projectos')) echo '
		class="current"';
        else echo
        'class="select"'; ?> ><li><a href="http://admin.biarq.com/Projectos"><b>Projectos</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub <?php if(ucwords($this->_request->controller) == ucwords
        ('projectos')) echo ' show' ?>">
			<ul class="sub">
				<li <?php if ((ucwords($this->_request->controller) == ucwords('projectos')) &&
                        ($this->_request->action == 'index'))echo ' class="sub_show"' ?>><a
                        href="http://admin.biarq
                        .com/Projectos">Listar Projectos</a></li>
				<li <?php if ((ucwords($this->_request->controller) == ucwords('projectos')) &&
                        ($this->_request->action == 'adicionar')
                ) echo ' class="sub_show"' ?>><a href="http://admin.biarq
                .com/Projectos/adicionar">Adicionar Projecto</a></li>
				<li <?php if ((ucwords($this->_request->controller) == ucwords('projectos')) &&
                        ($this->_request->action == 'ordenar')
                )echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/Projectos/ordenar">Ordenar Projectos</a></li>

			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
		<div class="nav-divider">&nbsp;</div>
		<ul  <?php if (ucwords($this->_request->controller) == ucwords('paginas')) echo '
		class="current"';else echo 'class="select"'; ?> ><li><a href="http://admin.biarq.com/Paginas"><b>Paginas</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub  <?php if (
            ucwords($this->_request->controller) == ucwords('paginas')
        ) echo ' show' ?>">
			<ul class="sub">
				<li <?php if ((ucwords($this->_request->controller) == ucwords('paginas')) &&
                        ($this->_request->action == 'index')
                )echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/Paginas">Listar Paginas</a></li>
				<li <?php if ((ucwords($this->_request->controller) == ucwords('paginas')) &&
                        ($this->_request->action == 'adicionar')
                )echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/Paginas/adicionar">Adicionar Paginas</a></li>
				<li <?php if ((ucwords($this->_request->controller) == ucwords('paginas')) &&
                        ($this->_request->action == 'ordenar')
                )echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/Paginas/ordenar">Ordenar Paginas</a></li>

			</ul>
		</div>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
		</li>
		</ul>
                <div class="nav-divider">&nbsp;</div>

		<ul  <?php if (ucwords($this->_request->controller) == ucwords('galeria')
        ) echo ' class="current"';else echo 'class="select"'; ?> ><li><a href="http://admin.biarq.com/galeria"><b>Galeria</b><!--[if IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<div class="select_sub <?php if (ucwords($this->_request->controller) == ucwords('galeria')
        ) echo ' show' ?>">
			<ul class="sub">
				<li <?php if ((ucwords($this->_request->controller) == ucwords('galeria')) &&
                        ($this->_request->action == 'index')
                )echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/galeria">Actualizar Galeria</a></li>
				<li <?php  if ((ucwords($this->_request->controller) == ucwords('galeria')) &&
                        ($this->_request->action == 'editar')
                )echo ' class="sub_show"' ?>><a href="http://admin.biarq.com/galeria/editar">Editar Texto</a></li>

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