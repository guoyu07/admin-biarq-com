<!--  start page-heading -->
<div id="page-heading">
    <h1>Propriedades de Biarq</h1>
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
                    <?= $this->form->create($user); ?>
                    <?= $this->form->field('username', array('class' => "inp-form")); ?>
                    <h4 style="color: ">Deixa em branco, se preencheres muda a pass</h4>
                    <?= $this->form->field('password', array('type' => 'password','class' => 'inp-form')); ?>
                    <?= $this->form->field('Nome_Utilizador', array('class' => 'inp-form')); ?>
                    <?= $this->form->field('Nome_Site', array('class' => 'inp-form')); ?>
                    <?= $this->form->field('Site_title', array('class' => 'inp-form')); ?>
                    <?= $this->form->textarea('Keywords', array('class' => "inp-form", 'class'=>'form-textarea')); ?>
                    
                    <?= $this->form->field('Email_Formulario', array('class' => "inp-form")); ?>
                    <?= $this->form->field('Google_Analytics_Id', array('class' => "inp-form")); ?>
                    



                    <?= $this->form->submit('editar'); ?>

                    <?= $this->form->end(); ?>