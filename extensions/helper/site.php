<?php

namespace app\extensions\helper;

class Site extends \lithium\template\Helper {

    public function url() {
        return "http://".$_SERVER['HTTP_HOST'];

    }
}

?>
