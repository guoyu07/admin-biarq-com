<?php
/**
 * Configure proper permissions on image folders 
 *
 * @copyright     Copyright 2012, Michael Nitschinger (michael@nitschinger.at)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\extensions\command;

use app\models\Projectos;
use lithium\core\Libraries;
class Install extends \lithium\console\Command {

	

	public $webroot = null;

	protected function _init() {
		parent::_init();
		$this->webroot = $this->webroot ?: LITHIUM_APP_PATH . '/webroot';
	}

	public function run() {
		/*$this->header("Installing Biarq Admin site");

		$cmd = "find {$this->webroot}/img/. -type d -exec chmod 777 {} \;";

		$this->out("Executing: $cmd"); 
		
		system($cmd);*/

        $imagine = new \Imagine\Gmagick\Imagine();
        $size = new \Imagine\Image\Box(635, 381);
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;


        $projectos = Projectos::find('all', array(

                'order' => array('ordem' => 'ASC'),
                'fields' => 'foto')
        );

        $fotos = [];
        foreach ($projectos as $projecto) {
            foreach ($projecto->to('array') as $fotoarray) {
                foreach ($fotoarray as $foto) {
                    array_push($fotos, $foto);

                }
            }
        }
        $cont = 0;


        foreach (glob(LITHIUM_APP_PATH . "/webroot/img/projectos/grandes/*.jpg") as $srcimg) {

            $imgname = substr($srcimg, -20);
            if (!in_array($imgname, $fotos)) {
                echo "fail $imgname \n";


            }

        }
        echo $cont;
	}

}

?>