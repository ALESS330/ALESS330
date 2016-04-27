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

}
