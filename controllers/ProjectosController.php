<?php

namespace app\controllers;

use lithium\storage\Session;
use app\models\Projectos as Projectos;
use app\libraries\Image\ImageTool as Resize;

class ProjectosController extends \lithium\action\Controller {

    public function _init() {

        parent::_init();
        if (!Session::read('user')) {
     var_dump(Session::$_configurations);
            var_dump(Session::read('user'));
            //$this->redirect('Sessions::add');
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

            $config['image_library'] = 'gd2';
            $config['create_thumb'] = true;
            $config['maintain_ratio'] = false;
            $projectos->save();


            $imagens = array();


            foreach ($_FILES["fotos"]["tmp_name"] as $foto) {
                $nomeimg = uniqid('img');
                $nomeimgjpg = $nomeimg . '.jpg';
                $fotodir = LITHIUM_APP_PATH . "/webroot/img/projectos/";
                move_uploaded_file($foto, $fotodir . $nomeimgjpg);
                array_push($imagens, $nomeimg . '_thumb.jpg');

                $config['source_image'] = $fotodir . $nomeimgjpg;
                $config['new_image'] = $fotodir . 'grandes/' . $nomeimgjpg;
                $config['width'] = 635;
                $config['height'] = 381;
                $img = new Resize($config);
                $img->resize();

                $config['source_image'] = $fotodir . $nomeimgjpg;
                $config['new_image'] = $fotodir . 'pequenas/' . $nomeimgjpg;
                $config['width'] = 125;
                $config['height'] = 75;
                $img = new Resize($config);
                $img->resize();
            }
            $projectos->foto = $imagens;
            if ($projectos->save()) {
                Session::write(
                        'message', array(
                    'status' => 'green',
                    'msg' => 'projecto ' . $projectos->titulo . ' adicionado.'));
            } else {
                Session::write(
                        'message', array(
                    'status' => 'red',
                    'msg' => 'Falha ao inserir ' . $projectos->titulo
                ));
            }
            $this->redirect('Projectos::index');


            //$success = $post->save();
        }

        return compact('projectosadicionartrue', 'projectostrue');
    }

    public function editar($id) {

        if ($this->request->data) {
            $projectos = Projectos::find('first', array(
                        'conditions' => array('_id' => $id)
                    ));

            $config['image_library'] = 'gd2';
            $config['create_thumb'] = true;
            $config['maintain_ratio'] = false;
            $fotodir = LITHIUM_APP_PATH . "/webroot/img/projectos/";




            $imagens = $projectos->foto->to('array');

            if (isset($_FILES["fotos"]["tmp_name"])) {
                foreach ($_FILES["fotos"]["tmp_name"] as $foto) {
                    $nomeimg = uniqid('img');
                    $nomeimgjpg = $nomeimg . '.jpg';

                    move_uploaded_file($foto, $fotodir . $nomeimgjpg);
                    array_push($imagens, $nomeimg . '_thumb.jpg');

                    $config['source_image'] = $fotodir . $nomeimgjpg;
                    $config['new_image'] = $fotodir . 'grandes/' . $nomeimgjpg;
                    $config['width'] = 635;
                    $config['height'] = 381;
                    $img = new Resize($config);

                    $img->resize();
                    $config['source_image'] = $fotodir . $nomeimgjpg;
                    $config['new_image'] = $fotodir . 'pequenas/' . $nomeimgjpg;
                    $config['width'] = 125;
                    $config['height'] = 75;
                    $img = new Resize($config);
                    $img->resize();
                }
            }
            $projectos->titulo = $this->request->data['titulo'];
            $projectos->texto = $this->request->data['texto'];
            $projectos->fotoprincipal = $this->request->data['fotoprincipal'];
            $config['create_thumb'] = false;
            $config['source_image'] = $fotodir . 'grandes/' . $this->request->data['fotoprincipal'];
            $config['new_image'] = $fotodir . 'principal/' . $this->request->data['fotoprincipal'];
            $config['width'] = 219;
            $config['height'] = 146;
            $img = new Resize($config);
            $img->resize();

            $projectos->foto = $imagens;
            if ($projectos->save()) {
                Session::write(
                        'message', array(
                    'status' => 'green',
                    'msg' => 'projecto ' . $projectos->titulo . ' editado com sucesso'));
            } else {
                Session::write(
                        'message', array(
                    'status' => 'red',
                    'msg' => 'Falha ao editar ' . $projectos->titulo));
            }
            $this->redirect('Projectos::index');
        }
        $projectos = Projectos::find('first', array(
                    'conditions' => array('_id' => $id)
                ));
        $projectostrue = true;
        return compact('projectos', 'projectostrue');
    }

    public function apagarfoto($idProjecto, $idFoto) {


        $projecto = Projectos::find('first', array(
                    'conditions' => array('_id' => $idProjecto)
                ));
        Session::write(
                'message', array(
            'status' => 'red',
            'msg' => 'Tens de escolher um foto principal antes de apagar esta'));
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
                    'msg' => 'foto apagada!'));
            } else {
                Session::write(
                        'message', array(
                    'status' => 'red',
                    'msg' => 'erro ao apagar foto! tenta novamente'));
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
                'msg' => 'projecto ' . $projecto->titulo . ' apagado com sucesso'));
        } else {
            Session::write(
                    'message', array(
                'status' => 'red',
                'msg' => 'Falha ao apagar ' . $projecto->titulo));
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
                        'msg' => 'projecto ' . $projecto->titulo . ' Featured.'));}
        if ($featured == 4) {
            if ($projecto->featured == false) {
                Session::write(
                        'message', array(
                            'status' => 'red',
                            'msg' => 'O limite de projectos na Home são 4!Apaga primeiro um '));
            }
            if ($projecto->featured == true) {
                $projecto->featured = false;
                Session::write(
                        'message', array(
                            'status' => 'green',
                            'msg' => 'projecto ' . $projecto->titulo . ' Unfeatured'));
            }
        }


        if (!$projecto->save()) {
            Session::write(
                    'message', array(
                        'status' => 'red',
                        'msg' => 'Falha ao adicionar ' . $projecto->titulo . '.'));
        }
        $this->redirect('Projectos::index');
    }

    public function search() {

    }

    public function teste() {

    }
}

?>