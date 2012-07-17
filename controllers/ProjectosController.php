<?php

namespace app\controllers;

use lithium\storage\Session;
use app\models\Projectos;
use li3_upload_progress\extensions\Upload_handler;

class ProjectosController extends \lithium\action\Controller {

    public function _init() {
        $this->_render['negotiate'] = true;

        parent::_init();

        if (!Session::read('user')) {
            $this->redirect('Sessions::add');
        }
    }

    public function index() {

        $projectos = Projectos::find('all', array(
            'order' => array('ordem' => 'ASC')
        ));
        $projectostrue = true;
        $projectosindextrue = true;
        return compact('projectos', 'projectostrue', 'projectosindextrue');
    }

    public function adicionar() {

        $projectostrue = true;
        $projectosadicionartrue = true;

        if ($this->request->data) {

            $projectos = Projectos::create();
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
            $this->redirect('/projectos/editar/' . $projectos->_id);
        }

        return compact('projectosadicionartrue', 'projectostrue');
    }

    public function editar() {
        $imagine = new \Imagine\Gmagick\Imagine();
        $sizeSmall = new \Imagine\Image\Box(125, 75);
        $sizeBig = new \Imagine\Image\Box(635, 381);
        $sizeTop = new \Imagine\Image\Box(219, 146);
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        $fotodir = LITHIUM_APP_PATH . "/webroot/img/projectos/";
        $projectostrue = true;

        $projectos = Projectos::find('first', array(
            'conditions' => array('_id' => $this->request->id)
        ));

        if ($this->request->data) {
            $imagens = $projectos->foto->to('array');
            if (isset($_FILES["fotos"]["tmp_name"])) {
                foreach ($_FILES["fotos"]["tmp_name"] as $foto) {
                    $nomeimg = uniqid('img') . '.jpg';
                    move_uploaded_file($foto, $fotodir . $nomeimg);
                    array_push($imagens, $nomeimg);

                    $imagine->open($fotodir . $nomeimg)
                            ->thumbnail($sizeBig, $mode)
                            ->save($fotodir . 'grandes/' . $nomeimg);

                    $imagine->open($fotodir . $nomeimg)
                            ->thumbnail($sizeSmall, $mode)
                            ->save($fotodir . 'pequenas/' . $nomeimg);
                }
                $projectos->foto = $imagens;
            }
            $projectos->titulo = $this->request->data['titulo'];
            $projectos->texto = $this->request->data['texto'];

            if ($projectos->fotoprincipal != $this->request->data['fotoprincipal']) {

                $imagine->open($fotodir . 'grandes/' . $this->request->data['fotoprincipal'])
                        ->thumbnail($sizeTop, $mode)
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
            $this->redirect('Projectos::index');
        }
        //return $this->render(array('layout' => false, 'json' => $projectos));
        return compact('projectos', 'projectostrue');
    }

    public function apagarfoto($idProjecto, $idFoto) {
        $idFoto = base64_decode($idFoto);

        $projecto = Projectos::find('first', array(
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

        $this->redirect('http://admin.biarq.com/projectos/editar/' . $idProjecto);
    }

    public function apagarProjecto($id) {

        $projecto = Projectos::find('first', array(
            'conditions' => array('_id' => $id)
        ));

        // $imagens = $projecto->foto->to('array');
        if (isset($projecto->foto)) {
            $imagens = $projecto->foto->to('array');
            foreach ($imagens as $imagem) {
                unlink(LITHIUM_APP_PATH . '/webroot/img/projectos/grandes/' . $imagem);
                unlink(LITHIUM_APP_PATH . '/webroot/img/projectos/pequenas/' . $imagem);
            }
        }

        if (Projectos::remove(array('_id' => $id))) {
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
        $this->redirect('Projectos::index');
    }

    public function ordenar() {

        if (isset($this->request->data['menu'])) {
            $menu = $this->request->data['menu'];
            for ($i = 0; $i < count($menu); $i++) {
                //
                Projectos::update(array('ordem' => $i), array('_id' => $menu[$i]));
            }
        }

        $projectos = Projectos::find('all', array(
            'order' => array('ordem' => 'ASC')
        ));
        $projectosordenartrue = true;
        $projectostrue = true;
        return compact('projectostrue', 'projectosordenartrue', 'projectos');
    }

    public function featured($id) {

        $projecto = Projectos::find('first', array(
            'conditions' => array('_id' => $id)
        ));
        $featured = Projectos::count(array('featured' => true));
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
        $this->redirect('Projectos::index');
    }

    public function search() {
    }

    public function upload_handler($idprojecto) {

        $upload_handler = new Upload_handler();

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
                $upload_handler->post($idprojecto);
                break;
            case 'DELETE':
                $upload_handler->delete();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }
        $this->_render = false;
    }

    public function teste() {
    }
}

?>