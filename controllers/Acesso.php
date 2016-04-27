<?php

$_CONTROLE = 'Acesso';
$_ROTULO = 'Acesso';

class Acesso extends Controller {

    function publico() {
        return TRUE;
    }

    function login() {
        $dados = array();
        parent::render($dados);
    }

    function logar() {


        $adUFGD = array();
        $adUFGD['domain_controllers'] = array("eros.ufgd.edu.br");
        $adUFGD['base_dn'] = "DC=UFGD,DC=edu,DC=br";
        $adUFGD['account_suffix'] = "@ufgd.edu.br";

        $adEbserh['domain_controllers'] = array("ebserhnet.ebserh.gov.br");
        $adEbserh['base_dn'] = 'DC=ebserhnet,DC=ebserh,DC=gov,DC=br';
        $adEbserh['account_suffix'] = "@ebserhnet.ebserh.gov.br";

        $acesso = $_POST['acesso'];
        $username = $acesso['username'];
        $password = $acesso['password'];

        $results = array();
        $login = $username;
        
        if (preg_match("/(.+)@ufgd.edu.br/", $username, $results)) {
            $adldap = new adLDAP($adUFGD);
            $login = $results[1];
        } else {
            if (preg_match("/(.+)@ebserhnet.ebserh.gov.br/", $username, $results)) {
                $adldap = new adLDAP($adEbserh);
                $login = $results[1];
            }
        }

        $authUser = $adldap->user()->authenticate($login, $password);
        if ($authUser == true) {
            session_start();
            $_SESSION['mensagem']['sucesso'] = "Login efetuado com sucesso.";
            $sessao = new Sessao($username);
            parent::go2("Application->index");
        } else {
            // getLastError is not needed, but may be helpful for finding out why:
            echo "<pre>";
            print_r($adldap);
            echo $login;
            die($adldap->getLastError());
        }
    }

    function logout() {
        session_start();
        $oldId = session_id();
        session_destroy();
        parent::go2("Application->index");
    }

}
