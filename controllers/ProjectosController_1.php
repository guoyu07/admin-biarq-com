<?php

namespace app\controllers;

use lithium\storage\Session;
use app\models\Projectos as Projectos;
use app\libraries\Image\ImageTool as Resize;

class ProjectosController extends \lithium\action\Controller {

    public function _init() {

        parent::_init();
        if (!Session::read('user'))
            $this->redirect('Sessions::add');


        Projectos::applyFilter('save', function($self, $params, $chain) {

                    //Temporarily store our entity object so that we can manipulate it
                    $record = $params['entity'];

                    //If an id doesn't exist yet, then we know we're saving for the first time. If a 
                    //password is provided, we need to hash it
                    var_dump($record->foto);

                    //Write the modified object back to $params
                    $params['entity'] = $record;

                    //Allow the next filter to be run
                    return $chain->next($self, $params, $chain);
                });
    }

    public function index() {


        $projectos = Projectos::find('all', array(
                    'order' => array('ordem' => 'ASC')
                ));
        $projectostrue = TRUE;
        $projectosindextrue = TRUE;
        return compact('projectos', 'projectostrue', 'projectosindextrue');
    }

    public function adicionar() {

        $projectostrue = TRUE;
        $projectosadicionartrue = TRUE;

        if ($this->request->data) {
            $projectos = Projectos::create();
            $projectos->titulo = $this->request->data['titulo'];
            $projectos->texto = $this->request->data['texto'];

            $config['image_library'] = 'gd2';
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = FALSE;
            $projectos->save();


            $imagens = array();


            foreach ($_FILES["fotos"]["tmp_name"] as $foto) {
                $nomeimg = uniqid('img');
                $nomeimgjpg = $nomeimg . '.jpg';
                $fotodir = "/var/www/vhosts/biarq.com/admin/app/webroot/img/projectos/";
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
                Session::write('message', array('status' => 'green', 'msg' => 'projecto ' . $projectos->titulo . ' adicionado.<a href="http://admin.biarq.com/projectos/adicionar"> adiciona outro</>'));
            } else {
                Session::write('message', array('status' => 'red', 'msg' => 'Falha ao inserir ' . $projectos->titulo));
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
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = FALSE;
            $fotodir = "/var/www/vhosts/biarq.com/admin/app/webroot/img/projectos/";




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
            $config['create_thumb'] = FALSE;
            $config['source_image'] = $fotodir . 'grandes/' . $this->request->data['fotoprincipal'];
            $config['new_image'] = $fotodir . 'principal/' . $this->request->data['fotoprincipal'];
            $config['width'] = 219;
            $config['height'] = 146;
            $img = new Resize($config);
            $img->resize();

            $projectos->foto = $imagens;
            if ($projectos->save()) {
                Session::write('message', array('status' => 'green', 'msg' => 'projecto ' . $projectos->titulo . ' editado com sucesso'));
            } else {
                Session::write('message', array('status' => 'red', 'msg' => 'Falha ao editar ' . $projectos->titulo));
            }
            $this->redirect('Projectos::index');
        }
        $projectos = Projectos::find('first', array(
                    'conditions' => array('_id' => $id)
                ));
        $projectostrue = TRUE;
        return compact('projectos', 'projectostrue');
    }

    public function apagarfoto($idProjecto, $idFoto) {

        echo $idProjecto;
        echo'<br>';
        echo $idFoto;
        $projecto = Projectos::find('first', array(
                    'conditions' => array('_id' => $idProjecto)
                ));

        $imagens = $projecto->foto->to('array');
        $imagens = array_diff($imagens, array($idFoto));

        unlink('/var/www/vhosts/biarq.com/admin/app/webroot/img/projectos/grandes/' . $idFoto);
        unlink('/var/www/vhosts/biarq.com/admin/app/webroot/img/projectos/pequenas/' . $idFoto);
        $projecto->foto = $imagens;
        if ($projecto->save()) {
            Session::write('message', array('status' => 'green', 'msg' => 'foto apagada!'));
        } else {
            Session::write('message', array('status' => 'red', 'msg' => 'erro ao apagar foto! tenta novamente'));
        }
        $this->redirect('http://admin.biarq.com/projectos/editar/' . $idProjecto);
    }

    public function apagarProjecto($id) {

        $projecto = Projectos::find('first', array(
                    'conditions' => array('_id' => $id)
                ));

        $imagens = $projecto->foto->to('array');
        foreach ($imagens as $imagem) {
            unlink('/var/www/vhosts/biarq.com/admin/app/webroot/img/projectos/grandes/' . $imagem);
            unlink('/var/www/vhosts/biarq.com/admin/app/webroot/img/projectos/pequenas/' . $imagem);
        }

        if (Projectos::remove(array('_id' => $id))) {
            Session::write('message', array('status' => 'green', 'msg' => 'projecto ' . $projecto->titulo . ' apagado com sucesso'));
        } else {
            Session::write('message', array('status' => 'red', 'msg' => 'Falha ao apagar ' . $projecto->titulo));
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
        $projectosordenartrue = TRUE;
        $projectostrue = TRUE;
        return compact('projectostrue', 'projectosordenartrue', 'projectos');
    }

    public function featured($id) {

        $projecto = Projectos::find('first', array(
                    'conditions' => array('_id' => $id)
                ));
        $featured = Projectos::count(array('featured' => true));
        if ($featured < 4) {

            $projecto->featured = TRUE;
            Session::write('message', array('status' => 'green', 'msg' => 'projecto ' . $projecto->titulo . ' adicionado a pagina principal'));
        }
        if ($featured == 4) {
            if ($projecto->featured == FALSE) {
                Session::write('message', array('status' => 'red', 'msg' => 'O limite de projectos na Home são 4! é necessario remover primeiro um para adicionar este '));
            }
            if ($projecto->featured == TRUE) {
                $projecto->featured = FAlSE;
                Session::write('message', array('status' => 'green', 'msg' => 'projecto ' . $projecto->titulo . ' removido a pagina principal'));
            }
        }


        if (!$projecto->save()) {
            Session::write('message', array('status' => 'red', 'msg' => 'Falha ao adicionar ' . $projecto->titulo . ' a pagina principal, tenta novamente'));
        }
        $this->redirect('Projectos::index');
    }

    public function search() {
        
    }

    public function teste() {
        
    }

}

?>