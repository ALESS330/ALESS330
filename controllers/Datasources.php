<?php

$_CONTROLE = 'Datasources';
$_ROTULO = 'Datasources';

class Datasources extends Controller {

    function index() {
        $datasource = new Datasource();
        $datasources = $datasource->lista();
        $dados['datasources'] = $datasources;
        parent::render($dados);
    }

    function cadastro($idDatasource){
        $d = new Datasource();
        $datasource = $d->get();
        parent::render();
    }
}
