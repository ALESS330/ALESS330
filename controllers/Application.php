<?php

$_CONTROLE = "Application";
$_ROTULO = "Emissão de Relatórios";

class Application extends Controller {

    function publico() {
        return FALSE;
    }

    function index() {
        $relatorio = new Relatorio();
        $user = new Usuario($_SESSION['username']);
        if(!$user){
            throw new Exception("Não encontrado usuário ativo na lista inicial de relatórios.");
        }
        $dados['listaRelatorios'] = $relatorio->listaInicial($user->getUsuario()->login);
        $this->render($dados);
    }

    function espelha() {
        print_r($_POST);
    }

    function printers() {
        
    }

}
