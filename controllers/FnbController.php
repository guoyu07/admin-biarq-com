<?php

namespace app\controllers;
use app\libraries\li3_u1\extensions\data\source\Ubuntu1;
use app\libraries\li3_u1\extensions\data\source\Ubuntu1api;
use lithium\storage\Session;
use app\models\Projectos;
use app\models\Mapping;
use li3_u1\extensions\UbuntuOne;
use li3_gearman\models\Tasks;
use \li3_gearman\Gearman;

class FnbController extends \lithium\action\Controller {

	public function index() {

		if (!Session::read('u1')) {
			($u1 = new Ubuntu1('thesyncim@gmail.com', 'Kirk1zodiak', 'teste2'));

			($u1->getTokens());

			($u1->tellU1());
			Session::write('u1', $u1);

		}

		$u1 = Session::read('u1');

		//$u1 = new Ubuntu1api($u1->conskey, $u1->conssec, $u1->token, $u1->token_secret);

		//$player = file_get_contents('/var/www/admin.biarq.com/app/webroot/download.json');
		flush();
		//$content = file_get_contents('/var/www/admin.biarq.com/app/webroot/img/paginas/biarq_1.png');

		//$path = realpath('/var/www/admin.biarq.com/app/webroot/img/projectos/grandes/');
		//$mapping = array();
		//$projectos = Projectos::find('all');

		//foreach ($projectos as $projecto) {
		//	$projecto->mapping = array();
		//	foreach ($projecto->foto as $foto) {
		//		$infop = $u1->getItemInfo("biarq/projectos/pequenas/{$foto}");
		//		$infog = $u1->getItemInfo("biarq/projectos/grandes/{$foto}");
		//		$projecto->mapping[$foto] = array(
		//			'pequenas' => $infop['public_url'],
		//			'grandes' => $infog['public_url']
		//		);
		//		print_r($projecto->mapping[$foto]);
		//	}
		//}



		//$map = function($imgId,$projecto){
		//	$edited =substr($imgId,0,-4);
		//	echo $projecto->mapping[$edited]['jpg']['pequenas'];





	//	};
		echo '<pre>';

//UbuntuOne::connect();
		//var_dump(UbuntuOne::write('marcelo',array('directory'=>'true')));
		//var_dump((Session::read('u1')));
		//foreach ($projectos as $projecto){
	//		foreach ($projecto->foto as $foto) {
	//		//$map($foto,$projecto);

		//	}

		//}


		//var_dump($projectos->save());
		//print_r($projecto->mapping);
		//echo count($lista);
		//	foreach ($lista as $foto) {
		//		$content = file_get_contents("/var/www/admin.biarq.com/app/webroot/img/projectos/pequenas/{$foto}");

		//		$u1->putFileContent("biarq/projectos/pequenas/{$foto}", "$content");
		//	}

		//$a = ($u1->getItemInfo('biarq/projectos/grandes', true));
		//$mapping = array();
		//foreach ($a["children"] as $foto) {
		//	substr($foto['path'], -26);
		//	array_push($mapping, array(substr($foto['path'], -26) => $foto['public_url']));
			//$u1->publishItem(substr($foto['path'], 1), true);
		//}
		//var_export($mapping);
		//print_r($u1->oauth);
		//print_r(UbuntuOne::connect());
		/*$result = Gearman::run('default', 'app\tasks\Hello');
		var_dump($result);

		$result = Gearman::run('default', 'app\tasks\Hello::say', array(
			'Mariano'
		), array('background' => true));
		var_dump($result);*/



		$result = Gearman::run('default', 'app\tasks\UbuntuOne::write',
			array('marcelo/boost_1_49_0.tar.gz',array('content' => '/var/www/admin.biarq.com/app/webroot/test/boost_1_49_0.tar.gz')),
			array('background' => true));
		var_dump(Gearman::status('default', 'H:mc-188-165-46-30.ovh.net:146'));



		$this->_stop();

		//UbuntuOne::write('marcelo/teste.txt',array(	'content'=>'teste9'));


		echo '</pre>';

		//$u1->putEmptyItem('directory', 'marcelo');
		//var_dump($u1->getItemInfo('CapturaEcra-11.png'));
		//var_dump(
		//$content = file_get_contents("/var/www/admin.biarq
		//.com/app/webroot/img/projectos/grandes/img4ebea27c774fa_thumb.jpg");
		//var_dump($u1->putEmptyItem('file', 'biarq/projectos/grandes/teste.png'));


		 //compact('player');
	}
}

?>