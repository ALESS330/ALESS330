<?php

$_CONTROLE = "Application";
$_ROTULO = "Emissão de Relatórios";

class Application extends Controller {

    function publico() {
        return TRUE;
    }

    function index() {
        $dados = array();
        $this->render($dados);
    }

}
