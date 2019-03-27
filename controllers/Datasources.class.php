<?php

$_CONTROLE = 'Datasources';
$_ROTULO = 'Datasources';

class Datasources extends Controller {

    private $datasource ;


    public function __construct() {
        parent::__construct();
        $this->datasource = new Datasource();
    }
    
    function index() {
        $datasource = new Datasource();
        $datasources = $datasource->lista();
        $dados['datasources'] = $datasources;
        $this->render($dados);
    }

    function cadastro($idDatasource){
        $d = new Datasource();
        $dados = array();
        $dados['datasource'] = $d->get($idDatasource);
        $this->render($dados);
    }
    
    function salvar(){
        $dados = $_POST['datasource'];
        if(!isset($dados['ativo'])){
            $dados['ativo'] = FALSE;
        }
        foreach ($dados as $campo => $valor){
            echo "<br>$campo = $valor<br>";
        }
        $this->datasource->mostrarSQL();
        $this->datasource->salvar($dados);
        $this->sucesso("Datasources->index", "Datasource salvo com sucesso.");
    }
}
