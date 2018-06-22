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
        $dados = array();
        $dados['datasource'] = $d->get($idDatasource);
        parent::render($dados);
    }
}
