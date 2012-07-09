<script type="text/javascript" src="http://admin.biarq.com/js/jquery-ui-1.8.16.custom.min.js"></script>
<script>
    $(document).ready(
    function() {
        $("#sortme").sortable({
            update : function () {
                serial = $('#sortme').sortable('serialize');
                $.ajax({
                    url: "http://admin.biarq.com/paginas/ordenar",
                    type: "post",
                    data: serial,
                    error: function(){
                        alert("theres an error with AJAX");
                    }
                });
            }
        });
    }
);
</script>
<!--  start page-heading -->
	<div id="page-heading">
		<h1>Ordenar Paginas</h1>
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
<ul id="sortme">
    <?php
    foreach ($paginas as $pagina) {
        echo '<li id="menu_' . $pagina->_id . '">' . $pagina->titulo . "</li>\n";
    }
    ?>
</ul>
