<?php

namespace app\controllers;

/*
 *
 *
 */
use lithium\storage\Session;
use app\models\Paginas;

class PaginasController extends \lithium\action\Controller {
    public function _init() {

        parent::_init();
        if (!Session::read('user')) {
            $this->redirect('Sessions::add');
        }
    }

    public function index() {

        $paginastrue = true;
        $paginasindextrue = true;

        $paginas = Paginas::find('all', array(
            'order' => array('ordem' => 'ASC')
        ));

        return compact('paginasindextrue', 'paginastrue', 'paginas');
    }

    public function adicionar() {

        $paginastrue = true;
        $paginasadicionartrue = true;

        if (isset($this->request->data['titulo'])) {
            $pagina = Paginas::create();
            $pagina->titulo = $this->request->data['titulo'];
            $pagina->texto = $this->request->data['texto'];
            $pagina->save();
        }

        return compact('paginasadicionartrue', 'paginastrue');
    }

    public function editar($id) {
        $print_r = function($var) {
            echo '<pre>';
            print_r($var);
            echo '</pre>';
        };
        $print_r($this->request);
        if (($this->request->data)) {
            $pagina = Paginas::find('first', array(
                'conditions' => array('_id' => $id)
            ));

            $pagina->titulo = $this->request->data['titulo'];
            $pagina->texto = $this->request->data['texto'];

            $pagina->save();
            $this->redirect('Paginas::index');
        }
        $pagina = Paginas::find('first', array(
            'conditions' => array('_id' => $id)
        ));
        $paginastrue = true;
        return compact('pagina', 'paginastrue');
    }

    public function apagar($id) {
        Paginas::remove(array('_id' => $id));
        $this->redirect('Paginas::index');
    }

    public function ordenar() {

        if (isset($this->request->data['menu'])) {
            $menu = $this->request->data['menu'];
            for ($i = 0; $i < count($menu); $i++) {
                //
                Paginas::update(array('ordem' => $i), array('_id' => $menu[$i]));
            }
        }

        $paginas = Paginas::find('all', array(
            'order' => array('ordem' => 'ASC')
        ));
        $paginasordenartrue = true;
        $paginastrue = true;
        return compact('paginastrue', 'paginasordenartrue', 'paginas');
    }
}

?>