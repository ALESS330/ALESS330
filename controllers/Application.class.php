<?php

$_CONTROLE = "Application";
$_ROTULO = "Emissão de Relatórios";
 
class Application extends Controller {
    private $relatorio;

    function __construct(){
        parent::__construct();
        $this->relatorio = new Relatorio();
    }

    function publico() {
        return FALSE;
    }

    

    function index() {
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
        $user = new Usuario($username);
        $listaRelatorios = array_map(function($relatorio){
            $relatorio->link = $this->router->link("Relatorios->gerar($relatorio->nome_datasource,$relatorio->nome)");
            return $relatorio;
        }, $this->relatorio->listaInicial($user));
        
        $categorias = array_reduce($listaRelatorios, function($itens, $relatorio){
            $c =  json_decode($relatorio->categorias);;
            if(count($c)){
                $itens = array_unique(array_merge($c, $itens));
            }
            return $itens;
        }, []);

        $i = 0;
        foreach($categorias as $categoria){
            $listaFinal[$i]['nome'] = $categoria;
            $listaFinal[$i++]['relatorios'] = array_values(array_filter($listaRelatorios, function($relatorio) use ($categoria){
                $c = json_decode($relatorio->categorias);
                if(array_search($categoria, $c) !== false){
                    return true; 
                }
                return false;
            }));
        }
        $listaFinal[$i]['nome'] = 'NAO_CATEGORIZADO';
        $listaFinal[$i]['relatorios'] = array_values(
                array_filter($listaRelatorios, function($relatorio){
                $c = json_decode($relatorio->categorias);
                if(count($c) == 0){
                    return true;
                }
                return false;
            })
        );
        
        $dados['listaRelatorios'] = $listaFinal;
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
    
    function pdf_me(){
        $dados['usuario'] = "Nome do Usuário";
        $this->renderPDF($dados); 
    }

}
