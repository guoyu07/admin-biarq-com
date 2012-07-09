<?php

namespace app\models;

 

class Projectos extends  \li3_behaviors\extensions\Model {

    protected $_actsAs = array(
        'Dateable',
        'Searchable' => array(
			'fields' => array('titulo')
	)
    );
}

?>