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


        $paginas = Paginas::find('all', array(
            'order' => array('ordem' => 'ASC')
        ));

        return compact('paginas');
    }

    public function adicionar() {



        if (isset($this->request->data['titulo'])) {
            $pagina = Paginas::create();
            $pagina->titulo = $this->request->data['titulo'];
            $pagina->texto = $this->request->data['texto'];
            $pagina->save();
        }

        return;
    }

    public function editar() {


        if (($this->request->data)) {
            $pagina = Paginas::find('first', array(
                'conditions' => array('_id' => $this->request->id)
            ));

            $pagina->titulo = $this->request->data['titulo'];
            $pagina->texto = $this->request->data['texto'];

            $pagina->save();
            $this->redirect('Paginas::index');
        }
        $pagina = Paginas::find('first', array(
            'conditions' => array('_id' => $this->request->id)
        ));

        return compact('pagina');
    }

    public function apagar() {
        Paginas::remove(array('_id' => $this->request->id));
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

        return compact('paginas');
    }
}

?>