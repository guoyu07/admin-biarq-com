<?php

namespace app\controllers;

use lithium\storage\Session;
use app\models\Construcao;
use li3_upload_progress\extensions\Upload_handler;
use lithium\core\Libraries;

class ConstrucaoController extends \lithium\action\Controller
{

    public function _init()
    {
        $this->_render['negotiate'] = true;

        parent::_init();

        if (!Session::read('user')) {
            $this->redirect('Sessions::add');
        }
    }

    public function index()
    {

        $projectos = Construcao::find('all', array(
            'order' => array('ordem' => 'ASC')
        ));

        return compact('projectos');
    }

    public function adicionar()
    {


        if ($this->request->data) {

            $projectos = Construcao::create();
            $projectos->titulo = $this->request->data['titulo'];
            $projectos->texto = $this->request->data['texto'];

            $projectos->foto = array();

            if ($projectos->save()) {
                Session::write(
                    'message', array(
                    'status' => 'green',
                    'msg' => 'projecto ' . $projectos->titulo . ' adicionado.'
                ));
            } else {
                Session::write(
                    'message', array(
                    'status' => 'red',
                    'msg' => 'Falha ao inserir ' . $projectos->titulo
                ));
            }
            array('controller' => 'projectos', 'action' => 'editar', 'args' => array());
            $this->redirect(array('construcao::editar', 'id' => $projectos->_id));

        }

        return;
    }

    public function editar()
    {
        $imagine = new \Imagine\Gmagick\Imagine();
        $sizeTop = new \Imagine\Image\Box(219, 146);
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        $fotodir = LITHIUM_APP_PATH . "/webroot/img/projectos/";


        $projectos = Construcao::find('first', array(
            'conditions' => array('_id' => $this->request->id)
        ));

        if ($this->request->data) {


            $projectos->titulo = $this->request->data['titulo'];
            $projectos->texto = $this->request->data['texto'];

            if ($projectos->fotoprincipal != $this->request->data['fotoprincipal']) {

                $imagine->open($fotodir . 'grandes/' . $this->request->data['fotoprincipal'])
                    ->resize($sizeTop, $mode)
                    ->save($fotodir . 'principal/' . $this->request->data['fotoprincipal']);
                @unlink($fotodir . 'principal/' . $projectos->fotoprincipal);

                $projectos->fotoprincipal = $this->request->data['fotoprincipal'];
            }

            if ($projectos->save()) {
                Session::write(
                    'message', array(
                    'status' => 'green',
                    'msg' => 'projecto ' . $projectos->titulo . ' editado com sucesso'
                ));
            } else {
                Session::write(
                    'message', array(
                    'status' => 'red',
                    'msg' => 'Falha ao editar ' . $projectos->titulo
                ));
            }
            $this->redirect('construcao::index');
        }

        //return $this->render(array('layout' => false, 'json' => $projectos));
        return compact('projectos');
    }

    public function apagarfoto($idProjecto, $idFoto)
    {
        $idFoto = base64_decode($idFoto);

        $projecto = Construcao::find('first', array(
            'conditions' => array('_id' => $idProjecto)
        ));
        Session::write(
            'message', array(
            'status' => 'red',
            'msg' => 'Tens de escolher um foto principal antes de apagar esta'
        ));
        $imagens = $projecto->foto->to('array');
        if ($projecto->fotoprincipal != $idFoto) {
            $imagens = array_diff($imagens, array($idFoto));

            unlink(LITHIUM_APP_PATH . '/webroot/img/projectos/grandes/' . $idFoto);
            unlink(LITHIUM_APP_PATH . '/webroot/img/projectos/pequenas/' . $idFoto);
            $projecto->foto = $imagens;
            if ($projecto->save()) {
                Session::write(
                    'message', array(
                    'status' => 'green',
                    'msg' => 'foto apagada!'
                ));
            } else {
                Session::write(
                    'message', array(
                    'status' => 'red',
                    'msg' => 'erro ao apagar foto! tenta novamente'
                ));
            }
        }

        $this->redirect(array('construcao::editar', 'id' => $idProjecto));
    }

    public function apagarProjecto()
    {

        $projecto = Construcao::find('first', array(
            'conditions' => array(
                '_id' => $this->request->id
            )
        ));

        // $imagens = $projecto->foto->to('array');
        if (isset($projecto->foto)) {

            foreach ($projecto->foto->to('array') as $imagem) {
                unlink(LITHIUM_APP_PATH . '/webroot/img/projectos/grandes/' . $imagem);
                unlink(LITHIUM_APP_PATH . '/webroot/img/projectos/pequenas/' . $imagem);
                unlink(LITHIUM_APP_PATH . '/webroot/img/original/' . $imagem);
            }
        }

        if (Construcao::remove(array('_id' => $this->request->id))) {
            Session::write(
                'message', array(
                'status' => 'green',
                'msg' => 'projecto ' . $projecto->titulo . ' apagado com sucesso'
            ));
        } else {
            Session::write(
                'message', array(
                'status' => 'red',
                'msg' => 'Falha ao apagar ' . $projecto->titulo
            ));
        }
        $this->redirect('Construcao::index');
    }

    public function ordenar()
    {

        if (isset($this->request->data['menu'])) {
            $menu = $this->request->data['menu'];
            for ($i = 0; $i < count($menu); $i++) {
                //
                Construcao::update(array('ordem' => $i), array('_id' => $menu[$i]));
            }
        }

        $projectos = construcao::find('all', array(
            'order' => array('ordem' => 'ASC')
        ));

        return compact('projectos');
    }

    public function featured()
    {

        $projecto = Construcao::find('first', array(
            'conditions' => array('_id' => $this->request->id)
        ));
        $featured = Construcao::count(array('featured' => true));
        if ($featured < 4) {

            $projecto->featured = true;
            Session::write(
                'message', array(
                'status' => 'green',
                'msg' => 'projecto ' . $projecto->titulo . ' Featured.'
            ));
        }
        if ($featured == 4) {
            if ($projecto->featured == false) {
                Session::write(
                    'message', array(
                    'status' => 'red',
                    'msg' => 'O limite de projectos na Home são 4!Apaga primeiro um '
                ));
            }
            if ($projecto->featured == true) {
                $projecto->featured = false;
                Session::write(
                    'message', array(
                    'status' => 'green',
                    'msg' => 'projecto ' . $projecto->titulo . ' Unfeatured'
                ));
            }
        }

        if (!$projecto->save()) {
            Session::write(
                'message', array(
                'status' => 'red',
                'msg' => 'Falha ao adicionar ' . $projecto->titulo . '.'
            ));
        }
        $this->redirect('Construcao::index');
    }

    public function search()
    {
    }

    public function upload_handler()
    {

        /**/


        $upload_handler = new Upload_handler();

        $upload_handler->applyFilter('handle_form_data', function ($self, $params, $chain) {

            $projectos = Construcao::find('first', array(
                'conditions' => array('_id' => $params['id'])
            ));

            $imagens = $projectos->foto->to('array');
            array_push($imagens, $params['file']->name);
            $projectos->foto = $imagens;
            $projectos->save();
            return $chain->next($self, $params, $chain);
        });

        header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Content-Disposition: inline; filename="files.json"');
        header('X-Content-Type-Options: nosniff');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                $upload_handler->get();
                break;
            case 'POST':
                $upload_handler->post($this->request->id);
                break;
            case 'DELETE':
                $upload_handler->delete();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }
        $this->_render = false;
    }

    public function teste()
    {


        $imagine = new \Imagine\Gmagick\Imagine();
        $size = new \Imagine\Image\Box(635, 381);
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;



        $projectos = Construcao::find('all', array(

                'order' => array('ordem' => 'ASC'),
                'fields' => 'foto',"limit"=>3,"page"=>4)
        );

        $fotos =[];
        foreach ($projectos as $projecto) {
            foreach($projecto->to('array') as $fotoarray){
               foreach($fotoarray as $foto){
                   array_push($fotos,$foto);

               }
            }
        }
$cont=0;



        foreach (glob(LITHIUM_APP_PATH . "/webroot/img/projectos/*.jpg") as $srcimg) {

         $imgname= substr($srcimg ,-20);
          if (in_array($imgname,$fotos)){
              $new_file_path = Libraries::get(true, 'path') . '/webroot/img/projectos/grandes/' . $imgname;
              $success = $imagine->open($srcimg)
                  ->resize($size, $mode)
                  ->save($new_file_path);
             if($success)
                 echo "done $imgname </br>";

          }

        }
echo $cont;
    }


}

?>