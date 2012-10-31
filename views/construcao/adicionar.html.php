<!--  start page-heading -->
<div id="page-heading">
    <h1>Adicionar Projecto em construção</h1>
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


                    <!-- Load TinyMCE -->
                    <script type="text/javascript"
                            src="http://admin.biarq.com/js/tiny_mce/jquery.tinymce.js"></script>
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



                    <?= $this->form->create($photo = NULL,
                    array('method' => 'post', 'enctype' => 'multipart/form-data')); ?>
                    <?= $this->form->field('titulo', array('class' => "inp-form")); ?>
                    <?= $this->form->field('texto',
                    array('type' => 'textarea', 'class' => 'tinymce')); ?>


                    <?= $this->form->submit('Continuar'); ?>
                    <?= $this->form->end(); ?>

