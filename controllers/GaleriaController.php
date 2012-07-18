<?php

namespace app\controllers;

/*
 * 
 * 
 */

use app\libraries\Image\ImageTool as Resize;
use app\models\Galeria;
use app\models\Projectos;
use lithium\storage\Session;

class GaleriaController extends \lithium\action\Controller {
     public function _init() {

        parent::_init();
        if (!Session::read('user'))
            $this->redirect('Sessions::add');
    }

    public function index() {
 
        $galeriatrue = TRUE;
        $galeriaindextrue = TRUE;

        $galeria = Galeria::find('first');

        $projectos = Projectos::find('all');

        $i = 0;
        foreach ($projectos as $projecto) {
            foreach ($projecto->foto as $foto) {
                $fotos[$i] = $foto;
                ++$i;
            }
        }
        $fotosGaleria = $galeria->foto->to('array');




        return compact('galeria', 'fotosGaleria', 'fotos');
    }

    public function adicionar($foto = NULL) {



        if ($foto) {


            $fotodir = LITHIUM_APP_PATH .'/webroot/img/projectos/';
            $fotoOriginal = substr($foto,0,-10).'.jpg';
           

            $config['image_library'] = 'gd2';
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['source_image'] = $fotodir .  $fotoOriginal;
            $config['new_image'] = $fotodir . 'galeria/' . $foto;
            $config['width'] = 615;
            $config['height'] = 302;
           $img = new Resize($config);
           $img->resize();

            $galeria = Galeria::find('first');

            $fotos = $galeria->foto->to('array');
            array_push($fotos, $foto);
            $galeria->foto = $fotos;
            $galeria->save();
        }

        $this->redirect('Galeria::index');
    }

    public function editar() {
        if (($this->request->data)) {
            $galeria = galeria::find('first');



            $galeria->texto = $this->request->data['texto'];



            $galeria->save();
            $this->redirect('galeria::index');
        }
        $galeria = galeria::find('first');

        return compact('galeria');
    }

    public function eliminarfoto($id) {
        $galeria = Galeria::find('first');

        $imagens = $galeria->foto->to('array');
        $imagens = array_diff($imagens, array($id));
        $galeria->foto = $imagens;
        $galeria->save();
         unlink(LITHIUM_APP_PATH.'/webroot/img/projectos/galeria/' . $id);
        $this->redirect('Galeria::index');
    }

}

?>
