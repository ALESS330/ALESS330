<?php

$_CONTROLE = 'Categorias';
$_ROTULO = 'Categorias';

class Categorias extends Controller {

    private $categoria ;


    public function __construct() {
        parent::__construct();
        $this->categoria = new Categoria();
    } 
    
    function index() {
        $dados['categorias'] = $this->categoria->listaTodas();
        $this->render($dados);
    }

    function cadastro($idCategoria = NULL){
        $dados['categoria'] = null;
        if($idCategoria){
            $dados['categoria'] = $this->categoria->get($idCategoria);
        }
        $this->render($dados);
    }
    
    function salvar(){
        $dados = $_POST['categoria'];
        $nome = $dados['nome'];
        $this->categoria->salvar($dados);
        $this->sucesso("Categorias->index", "Categoria $nome salva com sucesso.");
    }
}
