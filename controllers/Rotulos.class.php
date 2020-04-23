<?php

$_CONTROLE = 'Rotulos';
$_ROTULO = 'Rótulos';

class Rotulos extends Controller {

    private $rotulo ;


    function __construct() {
        parent::__construct();
        $this->rotulo = new Rotulo();
    }
     
    function index() {
        $rotulo = new Rotulo();
        $datasources = $rotulo->lista();
        $dados['datasources'] = $datasources;
        $this->render($dados);
    }

    function cadastro($idDatasource){
        $d = new Rotulo();
        $dados = array();
        $dados['rotulo'] = $d->get($idDatasource);
        $this->render($dados);
    }
    
    function salvar(){
        $dados = $_POST['rotulo'];
        if(!isset($dados['ativo'])){
            $dados['ativo'] = FALSE;
        }
        foreach ($dados as $campo => $valor){
            echo "<br>$campo = $valor<br>";
        }
        $this->rotulo->mostrarSQL();
        $this->rotulo->salvar($dados);
        $this->sucesso("Datasources->index", "Rotulo salvo com sucesso.");
    }
}
