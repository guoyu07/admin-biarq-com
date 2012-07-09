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

                            <th class="table-header-repeat line-left minwidth-1"><a href="">De</a>	</th>
                            <th class="table-header-repeat line-left minwidth-1">
                                <a href="">telemóvel</a></th>
                            <th class="table-header-repeat line-left minwidth-1"><a href="">email</a></th>
                            <th class="table-header-repeat line-left minwidth-1"><a href="">conteudo</a></th>
                            <th class="table-header-repeat line-left minwidth-1"><a href="">data</a></th>
                            <th class="table-header-options line-left"><a href="">Opções</a></th>
                        </tr>

                        <?php
                        $hex2bin = function($data) {
                                    $bin = "";
                                    $i = 0;
                                    do {
                                        $bin .= chr(hexdec($data{$i} . $data{($i + 1)}));
                                        $i += 2;
                                    } while ($i < strlen($data));

                                    return $bin;
                                };



                        $unpack = function ($bin) use ($hex2bin) {
                                    $bin = $hex2bin($bin);

                                    if (PHP_INT_SIZE <= 4) {
                                        list(, $h, $l) = unpack('n*', $bin);
                                        return ($l + ($h * 0x010000));
                                    } else {
                                        list(, $int) = unpack('N', $bin);
                                        return $int;
                                    }
                                };



                        foreach ($mensagens as $pagina) {
                            $id=get_object_vars($pagina->_id);


                            echo '<tr">
					
					<td>' . $pagina->nome . '</td>
					<td>' . $pagina->telemovel . '</td>
                                            <td>' . $pagina->email . '</td>
					<td>' . $pagina->texto . '</td>
					<td>' . date("Y-m-d H:i:s", $unpack($id['$id'])) . '</td>
					<td>
					
					<a href="http://admin.biarq.com/biarq/apagarsms/' . $pagina->_id . '" title="apagar ' . $pagina->titulo . '" class="icon-2 info-tooltip"></a>
					
					
					</td>
				</tr>';
                        }
                        ?>

                    </table>