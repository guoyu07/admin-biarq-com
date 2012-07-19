<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo $this->title(); ?></title>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <?=$this->scripts(); ?>
    <?= $this->styles(); ?>

    <link rel="stylesheet"
            href="http://admin.biarq.com/css/screen.css"
            type="text/css"
            media="screen"
            title="default" />
    <!--[if IE]>
    <link rel="stylesheet"
            media="all"
            type="text/css"
            href="http://admin.biarq.com/css/pro_dropline_ie.css" />
    <![endif]-->

    <!--  jquery core -->

    <?php echo $this->Html->script(array(
    'http://code.jquery.com/jquery-1.6.2.min.js',
    'jquery-ui-1.8.16.custom.min'
));?>
    <!--  checkbox styling script -->
    <!-- <script src="http://jqueryui.com/ui/jquery.ui.core.js" type="text/javascript"></script> -->

    <script src="http://admin.biarq.com/js/jquery/jquery.bind.js" type="text/javascript"></script>


    <!-- Custom jquery scripts -->
    <script src="http://admin.biarq.com/js/jquery/custom_jquery.js" type="text/javascript"></script>

    <!-- Tooltips -->
    <script src="http://admin.biarq.com/js/jquery/jquery.tooltip.js"
            type="text/javascript"></script>
    <script src="http://admin.biarq.com/js/jquery/jquery.dimensions.js"
            type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $('a.info-tooltip ').tooltip({
                track:true,
                delay:0,
                fixPNG:true,
                showURL:false,
                showBody:" - ",
                top:-35,
                left:5
            });
        });
    </script>


</head>
<body>
<!-- Start: page-top-outer -->
<div id="page-top-outer">

    <!-- Start: page-top -->
    <div id="page-top">

        <!-- start logo -->
        <div id="logo">
            <a href="http://admin.biarq.com/"><img src="http://www.biarq.com/img/logo.png"
                    width="156"
                    height="40"
                    alt="" /></a>
        </div>
        <!-- end logo -->


        <div class="clear"></div>

    </div>
    <!-- End: page-top -->

</div>
<!-- End: page-top-outer -->

<div class="clear">&nbsp;</div>

<!--  start nav-outer-repeat................................................................................................. START -->
<div class="nav-outer-repeat">
    <!--  start nav-outer -->
    <div class="nav-outer">

        <!-- start nav-right -->
        <div id="nav-right">

            <div class="nav-divider">&nbsp;</div>
            <div class="showhide-account">
                <img src="http://admin.biarq.com/img/shared/nav/nav_myaccount.gif"
                        width="93"
                        height="14"
                        alt="" /></div>
            <div class="nav-divider">&nbsp;</div>
            <a href="http://admin.biarq.com/logout"
                    id="logout"><img src="http://admin.biarq.com/img/shared/nav/nav_logout.gif"
                    width="64"
                    height="14"
                    alt="" /></a>

            <div class="clear">&nbsp;</div>

            <!--  start account-content -->
            <div class="account-content">
                <div class="account-drop-inner">
                    <a href="http://admin.biarq.com/biarq/" id="acc-settings">Settings</a>

                    <div class="clear">&nbsp;</div>
                    <div class="acc-line">&nbsp;</div>

                    <a href="http://admin.biarq.com/biarq/inbox" id="acc-inbox">Inbox</a>

                    <div class="clear">&nbsp;</div>
                    <div class="acc-line">&nbsp;</div>
                    <a href="http://admin.biarq.com/biarq/stats" id="acc-stats">Estatísticas</a>
                </div>
            </div>
            <!--  end account-content -->

        </div>
        <!-- end nav-right -->


        <?= $this->_render('element', 'menu'); ?>

    </div>
    <div class="clear"></div>
    <!--  start nav-outer -->
</div>
<!--  start nav-outer-repeat................................................... END -->

<div class="clear"></div>

<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
    <!-- start content -->
    <div id="content">


        <?php echo $this->content(); ?>

    </div>
    <!--  end table-content  -->

    <div class="clear"></div>

</div>
<!--  end content-table-inner ............................................END  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
    <th class="sized bottomleft"></th>
    <td id="tbl-border-bottom">&nbsp;</td>
    <th class="sized bottomright"></th>
</tr>
</table>
<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>

<!-- start footer -->
<div id="footer">
    <!-- <div id="footer-pad">&nbsp;</div> -->
    <!--  start footer-left -->
    <div id="footer-left">
        Biarq.com &copy; Copyright thesyncim.
        <a href="http://admin.biarq.com/">thesyncim@gmail.com</a>. All rights reserved.
    </div>
    <!--  end footer-left -->
    <div class="clear">&nbsp;</div>
</div>
<!-- end footer -->

</body>
</html>