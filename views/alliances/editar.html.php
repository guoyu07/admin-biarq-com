<!--  start page-heading -->
<div id="page-heading">
    <h1>Edit Alliance <?=$alliances->name?></h1>
</div>
<!-- end page-heading -->

<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
    <tr>
        <th rowspan="3" class="sized"><img src="http://develop.azorestv.com/img/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
        <th class="topleft"></th>
        <td id="tbl-border-top">&nbsp;</td>
        <th class="topright"></th>
        <th rowspan="3" class="sized"><img src="http://develop.azorestv.com/img/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
    </tr>
    <tr>
        <td id="tbl-border-left"></td>
        <td>
            <!--  start content-table-inner ...................................................................... START -->
            <div id="content-table-inner">

                <!--  start table-content  -->
                <div id="table-content">
                   
                 


                    <?= $this->form->create($alliances); ?>
                    <?= $this->form->field('name', array('class' => "inp-form")); ?>
                    <?= $this->form->field('power', array('class' => "inp-form")); ?>
                    <?= $this->form->field('overlord', array('class' => "inp-form")); ?>
                    <?= $this->form->submit('Edit Alliance'); ?>
                    <?= $this->form->end(); ?>

