<?=
$this->html->style(array('imageselect', 'ui-darkness/jquery-ui-1.8.16.custom'))
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


    <div id="projectos"></div>


    <br>
    <select name="fotoprincipal" id="fotoprincipal">
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

        <div id="result"></div>


    </div>
    <!-- End demo -->



    <script type="text/javascript">
        $(document).ready(function () {
            $("select[name='fotoprincipal']").ImageSelect({dropdownWidth:125})
        });




    </script>

    <?= $this->form->submit('Editar Projecto'); ?>
    <?= $this->form->end(); ?>




    <!-- Bootstrap CSS Toolkit styles -->
    <link rel="stylesheet"
            href="/css/bootstrap.min.css">
    <!-- Generic page styles -->

    <!-- Bootstrap styles for responsive website layout, supporting different screen sizes -->
    <link rel="stylesheet"
            href="/css/bootstrap-responsive.min.css">

    <!-- Bootstrap CSS fixes for IE6 -->
    <!--[if lt IE 7]>
    <link rel="stylesheet"
            href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css">
    <![endif]-->
    <!-- Bootstrap Image Gallery styles -->
    <link rel="stylesheet"
            href="http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="/css/jquery.fileupload-ui.css">
    <!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="/projectos/upload_handler/<?=$projectos->_id?>"
            method="POST"
            enctype="multipart/form-data">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="icon-trash icon-white"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
            </div>
            <!-- The global progress information -->
            <div class="span5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active"
                        role="progressbar"
                        aria-valuemin="0"
                        aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped">
            <tbody class="files"
                    data-toggle="modal-gallery"
                    data-target="#modal-gallery"></tbody>
        </table>
    </form>
    <br>


</div>
<!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>

        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body">
        <div class="modal-image"></div>
    </div>
    <div class="modal-footer">
        <a class="btn modal-download" target="_blank">
            <i class="icon-download"></i>
            <span>Download</span>
        </a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
            <i class="icon-play icon-white"></i>
            <span>Slideshow</span>
        </a>
        <a class="btn btn-info modal-prev">
            <i class="icon-arrow-left icon-white"></i>
            <span>Previous</span>
        </a>
        <a class="btn btn-primary modal-next">
            <span>Next</span>
            <i class="icon-arrow-right icon-white"></i>
        </a>
    </div>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
        <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span>
            {%=locale.fileupload.errors[file.error] || file.error%}
        </td>
        {% } else if (o.files.valid && !i) { %}
        <td>
            <div class="progress progress-success progress-striped active"
                    role="progressbar"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    aria-valuenow="0">
                <div class="bar" style="width:0%;"></div>
            </div>
        </td>
        <td class="start">{% if (!o.options.autoUpload) { %}
            <button class="btn btn-primary">
                <i class="icon-upload icon-white"></i>
                <span>{%=locale.fileupload.start%}</span>
            </button>
                          {% } %}
        </td>
        {% } else { %}
        <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
                           {% } %}
        </td>
    </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
        <td></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span>
            {%=locale.fileupload.errors[file.error] || file.error%}
        </td>
        {% } else { %}
        <td class="preview">{% if (file.thumbnail_url) { %}
            <a href="{%=file.url%}"
                    title="{%=file.name%}"
                    rel="gallery"
                    download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
                            {% } %}
        </td>
        <td class="name">
            <a href="{%=file.url%}"
                    title="{%=file.name%}"
                    rel="{%=file.thumbnail_url&&'gallery'%}"
                    download="{%=file.name%}">{%=file.name%}</a>
        </td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger"
                    data-type="{%=file.delete_type%}"
                    data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
    {% } %}
</script>


<!-- The Templates plugin is included to render the upload/download listings -->
<script src="http://blueimp.github.com/JavaScript-Templates/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.com/JavaScript-Canvas-to-Blob/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
<script src="http://blueimp.github.com/cdn/js/bootstrap.min.js"></script>
<script src="http://blueimp.github.com/Bootstrap-Image-Gallery/js/bootstrap-image-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/js/upload_progress/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/js/upload_progress/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="/js/upload_progress/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<script src="/js/upload_progress/jquery.fileupload-ui.js"></script>
<!-- The localization script -->
<script src="/js/upload_progress/locale.js"></script>
<!-- The main application script -->
<script src="/js/upload_progress/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]>
<script src="/js/upload_progress/cors/jquery.xdr-transport.js"></script><![endif]-->


<script type="text/javascript">
    $('#fileupload')

            .bind('fileuploadcompleted', function (e, data) {
                $.getJSON('http://admin.biarq.com/projectos/editar/<?=$projectos->_id?>.json',
                        function (data) {
                            //console.log(data);
                            document.getElementById("result").innerHTML = tmpl("tmpl-demo", data);

                        });

            })



</script>


<script type="text/x-tmpl" id="tmpl-demo">
    <ul class="gallery ui-helper-reset ui-helper-clearfix">


        {% for (var i=0; i
        <o.projectos.foto.length
        ; i++) { %}

        <li class="ui-widget-content ui-corner-tr" id="imagens">
            <h5 class="ui-widget-header">foto{%=[i]%}</h5>
            <img src="http://admin.biarq.com/img/projectos/pequenas/{%=o.projectos.foto[i]%}"
                    alt="foto' . $r . '"
                    width="96"
                    height="72" />
            <a href="http://admin.biarq.com/img/projectos/grandes/{%=o.projectos.foto[i]%}"
                    title="Ver maior"
                    class="ui-icon ui-icon-zoomin">Ver Maior</a>
            <a href="http://admin.biarq.com/projectos/apagarfoto/{%=o
            .projectos_id%}/javascript:Base64.encode({%=o
            .projectos.foto[i]%})"
                    title="Delete this image" class="ui-icon ui-icon-trash">Apagar imagem</a>
        </li>

        {% } %}
    </ul>
</script>


<script type="text/javascript">
    $.getJSON('http://admin.biarq.com/projectos/editar/<?=$projectos->_id?>.json',
            function (data) {
                console.log(data);
                document.getElementById("result").innerHTML = tmpl("tmpl-demo", data);

            });


</script>


