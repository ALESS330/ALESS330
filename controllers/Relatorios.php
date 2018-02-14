<?php

$_CONTROLE = 'Relatorios';
$_ROTULO = 'Relatórios';

require_once dirname(dirname(dirname(__FILE__))) . "/formularios/models/Formulario.php";
require_once dirname(dirname(dirname(__FILE__))) . "/formularios/utils/GeradorFormulario.php";

class Relatorios extends Controller {

    private $relatorio;

    public function __construct() {
        parent::__construct();
        $this->relatorio = new Relatorio();
    }

    function index() {
        parent::render();
    }

    function pagina($pagina = 1, $busca = " ") {
        parent::json($this->relatorio->pagina($pagina, $busca));
    }

    function propriedades($idRelatorio) {
        $dados['relatorio'] = $this->relatorio->get($idRelatorio);
        $dados['gruposRelatorio'] = $this->relatorio->getGrupos($idRelatorio);
        $dados['parametros'] = $this->relatorio->getParametros($idRelatorio);
        parent::render($dados);
    }

    function cadastro($id = NULL) {
        $dados = array();
        if ($id) {
            $dados['relatorioAtual'] = $this->relatorio->get($id);
        }
        $datasource = new Datasource();
        $datasources = $datasource->lista();
        $dados['datasources'] = $datasources;
        parent::render($dados);
    }

    function excluir($relatorioId){
        $retorno = $this->relatorio->deleta($relatorioId);
        if (!$retorno){
            throw new Exception("Erro na exclusão do relatório $relatorioId");
        }
        $_SESSION['mensagem']['sucesso'] = "Relatório $relatorioId excluído com sucesso";
        $this->index();
    }
    
    function salvar() {
        $dadosRelatorio = $_POST['relatorio'];
        $dadosRelatorio['codigo_sql'] = str_replace("'", "''", $dadosRelatorio['codigo_sql']);
        $dadosRelatorio['relatorio_pai_id'] = is_numeric($dadosRelatorio['relatorio_pai_id']) === TRUE ? $dadosRelatorio['relatorio_pai_id'] : null;
        $dadosRelatorio['parametrizado'] = ($dadosRelatorio['parametrizado'] == true) ? true : false;
        $this->relatorio->salvar($dadosRelatorio);
        $_SESSION['mensagem']['sucesso'] = "Relatório salvo com sucesso.";
        parent::go2("Relatorios->index()");
    }

    function gerar($datasource, $nomeRelatorio) {
        $relatorio = $this->relatorio->selectByEquals("nome", $nomeRelatorio);
        $parametros = count($_GET);
        if($relatorio[0]->parametrizado && !$parametros){
            $_SESSION['action'] = $this->router->link("Relatorios->gerar($datasource,$nomeRelatorio)"); //$router
            $_SESSION['isTela'] = true;
            $_SESSION['toRelatorio'] = true;
            $rt = new RelatorioTela();
            $telaId = $rt->getBy(array("relatorio_id" => $relatorio[0]->id))->formulario_id;
            $formulario = new Formulario();
            $f = $formulario->getBy(array("id"=>$telaId));
            parent::go2("/formularios/formulario/$f->nome");
        }

        if ($this->relatorio->checarAcesso($relatorio[0]->id) !== TRUE) { 
            //arquivo enviado
            $_SESSION['mensagem']['erro'] = "Acesso não autorizado a este relatório.";
            parent::go2("Application->index");
            exit();
        }
        $construtor = new ConstrutorRelatorios();
        $data['relatorio'] = $construtor->getRelatorio($nomeRelatorio, $datasource);
        $data['estrutura'] = $construtor->getEstruturaRelatorio($nomeRelatorio);
        parent::render($data);
    }

    function gerarPdf($datasource, $nomeRelatorio) {
        $data = array();
        $construtor = new ConstrutorRelatorios();
        $data['html'] = $construtor->getRelatorio($nomeRelatorio, $datasource);

        $estrutura = $construtor->getEstruturaRelatorio($nomeRelatorio)[0];
        $data['nome'] = $estrutura['nome_relatorio'];
        $data['descricao'] = $estrutura['descricao'];
        ini_set("max_execution_time", 90);
        parent::renderPdf($data);
    }

    function gerarExcel($datasource, $nomeRelatorio) {
        $data = array();
        $construtor = new ConstrutorRelatorios();
        $data['dados'] = $construtor->getDadosRaw($nomeRelatorio, $datasource);
        $estrutura = $construtor->getEstruturaRelatorio($nomeRelatorio);
        $data['tipo'] = $estrutura[0]['tipo'];
        $data['coluna_grupo'] = $estrutura[0]['coluna_grupo'];
        $data['nome_relatorio'] = $nomeRelatorio;
        parent::renderExcel($data);
    }

    function gerarCsv($datasource, $nomeRelatorio) {
        $data = array();
        $construtor = new ConstrutorRelatorios();
        $data['dados'] = $construtor->getDadosRaw($nomeRelatorio, $datasource);
        $estrutura = $construtor->getEstruturaRelatorio($nomeRelatorio);
        $data['tipo'] = $estrutura[0]['tipo'];
        $data['coluna_grupo'] = $estrutura[0]['coluna_grupo'];
        $data['nome_relatorio'] = $nomeRelatorio;
        parent::renderCsv($data);
    }

}
