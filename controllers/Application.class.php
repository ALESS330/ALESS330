<?php

$_CONTROLE = "Application";
$_ROTULO = "Emissão de Relatórios";

class Application extends Controller {

    function publico() {
        return FALSE;
    }

    function index() {
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
        $user = new Usuario($username);
        $relatorio = new Relatorio();
        $dados['listaRelatorios'] = $relatorio->listaInicial($user);
        if (!count($dados['listaRelatorios']) && !$user) {
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
