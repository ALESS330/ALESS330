<?php

$_CONTROLE = "Application";
$_ROTULO = "Emissão de Relatórios";

class Application extends Controller {

    function publico() {
        return FALSE;
    }

    function index() {
        $user = new Usuario($_SESSION['username']);
        $relatorio = new Relatorio();
        $dados['listaRelatorios'] = $relatorio->listaInicial($user->getUsuario()->login);
        if(!count($dados['listaRelatorios']) && !$user){
            $this->go2("Acessos->login");
        }
        $this->render($dados);
    }

    function espelha() {
        print_r($_POST);
    }

    function printers() {
        
    }

}
