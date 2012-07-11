<?= $this->html->style(array('imageselect', 'ui-darkness/jquery-ui-1.8.16.custom'))
; ?>
<style>
    #gallery {
        float: left;
        width: 65%;
        min-height: 12em;
    }

    * html #gallery {
        height: 12em;
    }

        /* IE6 */
    .gallery.custom-state-active {
        background: #eee;
    }

    .gallery li {
        float: left;
        width: 96px;
        padding: 0.4em;
        margin: 0 0.4em 0.4em 0;
        text-align: center;
    }

    .gallery li h5 {
        margin: 0 0 0.4em;
        cursor: move;
    }

    .gallery li a {
        float: right;
    }

    .gallery li a.ui-icon-zoomin {
        float: left;
    }

    .gallery li a.ui-icon-trash2 {
        float: left;
    }

    .gallery li img {
        width: 100%;
        cursor: move;
    }

    #trash {
        float: right;
        width: 32%;
        min-height: 18em;
        padding: 1%;
    }

    * html #trash {
        height: 18em;
    }

        /* IE6 */
    #trash h4 {
        line-height: 16px;
        margin: 0 0 0.4em;
    }

    #trash h4 .ui-icon {
        float: left;
    }

    #trash .gallery h5 {
        display: none;
    }
</style>




<script type="text/javascript">

    var i = 0;
    function addField() {
        $('div#projectos').append('<?= $this->form->field('fotos[]', array('type' => 'file')); ?>');
        i++;
        return false;
    }
</script>

<!-- Load TinyMCE -->
<script type="text/javascript" src="http://admin.biarq.com/js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="http://admin.biarq.com/js/imageselect.js"></script>

<script type="text/javascript">
    $().ready(function () {

        $('textarea.tinymce').tinymce({
            // Location of TinyMCE script
            script_url:'http://admin.biarq.com/js/tiny_mce/tiny_mce.js',

            // General options
            theme:"advanced",
            plugins:"autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

            // Theme options
            theme_advanced_buttons1:"save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2:"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3:"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4:"insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
            theme_advanced_toolbar_location:"top",
            theme_advanced_toolbar_align:"left",
            theme_advanced_statusbar_location:"bottom",
            theme_advanced_resizing:true


        });
    });
</script>
<!-- /TinyMCE -->


<!--  start page-heading -->
<div id="page-heading">
    <h1>editar <?= $projectos->titulo ?></h1>
</div>
<!-- end page-heading -->
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
    <tr>
        <th rowspan="3" class="sized">
            <img src="http://admin.biarq.com/img/shared/side_shadowleft.jpg"
                    width="20"
                    height="300"
                    alt="" /></th>
        <th class="topleft"></th>
        <td id="tbl-border-top">&nbsp;</td>
        <th class="topright"></th>
        <th rowspan="3" class="sized">
            <img src="http://admin.biarq.com/img/shared/side_shadowright.jpg"
                    width="20"
                    height="300"
                    alt="" /></th>
    </tr>
    <tr>
        <td id="tbl-border-left"></td>
        <td>
            <!--  start content-table-inner ...................................................................... START -->
            <div id="content-table-inner">

                <!--  start table-content  -->
                <div id="table-content">
                    <?= $this->_render('element', 'mensagem'); ?>
                    <?= $this->form->create($projectos,
                    array('method' => 'post', 'enctype' => 'multipart/form-data')); ?>

                    <?= $this->form->field('titulo', array('class' => "inp-form")); ?>
                    <?= $this->form->field('texto',
                    array('type' => 'textarea', 'class' => 'tinymce')); ?>
                    <input type="button" onclick="addField();" value="adicionar fotos" /><br />

                    <div id="projectos"></div>


                    <br>
                    <select name="fotoprincipal" id="teste">
                        <?php
                        foreach ($projectos->foto as $foto) {
                            $cond = '';
                            if ($projectos->fotoprincipal == $foto) {
                                $cond = ' selected="selected"';
                            }
                            echo' <option ' . $cond . ' value="' . $foto .
                                    '" > http://admin.biarq.com/img/projectos/pequenas/' . $foto .
                                    '</option>';
                        }
                        ?>
                    </select>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>


                    <div class="demo ui-widget ui-helper-clearfix">

                        <ul class="gallery ui-helper-reset ui-helper-clearfix">

                            <?php
                            $r = 1;
                            foreach ($projectos->foto as $foto) {
                                echo'<li class="ui-widget-content ui-corner-tr">
		<h5 class="ui-widget-header">foto' . $r . '</h5>
		<img src="http://admin.biarq.com/img/projectos/pequenas/' . $foto . '"  alt="foto' . $r . '" width="96" height="72" //>
		<a href="http://admin.biarq.com/img/projectos/grandes/' . $foto . '" title="Ver maior" class="ui-icon ui-icon-zoomin">Ver Maior</a>
		<a href="http://admin.biarq.com/projectos/apagarfoto/' . $projectos->_id . '/' . $foto . '" title="Delete this image" class="ui-icon ui-icon-trash">Apagar imagem</a>
	</li>';

                                ++$r;
                            }
                            ?>

                        </ul>


                    </div>
                    <!-- End demo -->


                    <script type="text/javascript">

                        $(document).ready(function () {
                            $('select[name=fotoprincipal]').ImageSelect({dropdownWidth:125});
                        });

                    </script>

                    <?= $this->form->submit('Editar Projecto'); ?>
                    <?= $this->form->end(); ?>
