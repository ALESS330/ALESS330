<?php

$_CONTROLE = 'Parametros';
$_ROTULO = 'Parâmetros';

class Parametros extends Controller {

    function ver($parametroId){
        $p = new Parametro();
        $r = new Relatorio();
        $dados['relatorios'] = $r->listaTodos();
        $dados['parametro'] = $p->get($parametroId);
        parent::render($dados);
    }
}
