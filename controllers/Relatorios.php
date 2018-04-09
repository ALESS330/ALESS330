<?php

$_CONTROLE = 'Relatorios';
$_ROTULO = 'Relatórios';

require_once dirname(dirname(dirname(__FILE__))) . "/formularios/models/Formulario.php";
require_once dirname(dirname(dirname(__FILE__))) . "/formularios/utils/GeradorFormulario.php";

class Relatorios extends Controller {

    private $relatorio;
    private $construtor;

    public function __construct() {
        parent::__construct();
        $this->relatorio = new Relatorio();
        $this->construtor = new ConstrutorRelatorios();
        $this->setObjeto($this->relatorio);
    }

    function index() {
        parent::render();
    }

    function pagina($pagina = 1, $busca = " ") {
        parent::json($this->relatorio->pagina($pagina, $busca));
    }

    function propriedades($idRelatorio) {
        $dados['relatorio'] = $this->buscaOuNulo($idRelatorio);
        $dados['gruposRelatorio'] = $this->relatorio->getGrupos($idRelatorio);
        $tp = $this->relatorio->getTelaParametros($idRelatorio);
        $objFormulario = new Formulario();
        $f = $objFormulario->get($tp[0]->formulario_id);
        $dados['telaParametros'] = $f;
        parent::render($dados);
    }

    function cadastro($id = NULL) {
        $dados = array();
        if ($id) {
            $dados['relatorioAtual'] = $this->buscaOuNulo($id);
        }
        $datasource = new Datasource();
        $dados['datasources'] = $datasource->lista();
        parent::render($dados);
    }

    function excluir($relatorioId) {
        $retorno = $this->relatorio->deleta($relatorioId);
        if (!$retorno) {
            throw new Exception("Erro na exclusão do relatório $relatorioId");
        }
        $this->mensagemSucesso("Relatório $relatorioId excluído com sucesso");
        $this->index();
    }

    function salvar() {
        $dadosRelatorio = $_POST['relatorio'];
        //$dadosRelatorio['codigo_sql'] = str_replace("'", "''", $dadosRelatorio['codigo_sql']);
        $dadosRelatorio['relatorio_pai_id'] = is_numeric($dadosRelatorio['relatorio_pai_id']) === TRUE ? $dadosRelatorio['relatorio_pai_id'] : null;
        $dadosRelatorio['parametrizado'] = ($dadosRelatorio['parametrizado'] == true) ? true : false;
        $this->relatorio->salvar($dadosRelatorio);
        $this->mensagemSucesso("Relatório salvo com sucesso.");
        parent::go2("Relatorios->index()");
    }

    function gerar($datasource, $nomeRelatorio) {
        $relatorio = $this->relatorio->selectByEquals("nome", $nomeRelatorio);
        $parametros = count($_GET);
        if ($relatorio[0]->parametrizado && !$parametros) {
            $_SESSION['action'] = $this->router->link("Relatorios->gerar($datasource,$nomeRelatorio)"); //$router
            $rt = new RelatorioTela();
            $telaId = $rt->getBy(array("relatorio_id" => $relatorio[0]->id))->formulario_id;
            $formulario = new Formulario();
            $f = $formulario->getBy(array("id" => $telaId));
            parent::go2("/formularios/tela-relatorio/$f->nome");
        }

        if ($this->relatorio->checarAcesso($relatorio[0]->id) !== TRUE) {
            $this->mensagemInfo("Acesso não autorizado a este relatório.");
            $this->go2("Application->index");
        }
        $construtor = new ConstrutorRelatorios();
        $data['relatorio'] = $construtor->getRelatorio($nomeRelatorio, $datasource);
        $data['estrutura'] = $construtor->getEstruturaRelatorio($nomeRelatorio);
        $imprimir = $_GET['imprimir'];
        $u = "";
        if ($imprimir) {
            $r = $this->toPDF($datasource, $nomeRelatorio, $data);
            $u = explode("&imprimir=", $_SERVER['REQUEST_URI'])[0];
            if ($r) {
                $this->mensagemSucesso("Relatório impresso com sucesso!");
            } else {
                $this->mensagemErro("Falha ao imprimir o relatório!");
            }
            $this->go2("$u");
        }
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

    private function toPDF($datasource, $nomeRelatorio) {
        $impressora = '/printers/HUGD_PULSEIRA_TESTE';
        $construtor = new ConstrutorRelatorios();
        $dados = $construtor->getDados($nomeRelatorio, $datasource);
        require_once dirname("..") . '/classes/lib/print-ipp/PrintIPP.php';

        $pulseira = $dados[0];
        $ipp = new PrintIPP();
        $ipp->setHost('10.18.0.38');
        $ipp->setPrinterURI($impressora);
        $ipp->setMimeMediaType("application/vnd.cups-raw");
        require_once dirname("..") . "/view/Relatorios/layouts/$nomeRelatorio.prn.php";
        $ipp->setData($layout);
        $s = $ipp->printJob($pulseira);
        if ($s == "successfull-ok") {
            return TRUE;
        }
        return FALSE;
    }

}
