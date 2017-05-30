<?php

$_CONTROLE = 'Relatorios';
$_ROTULO = 'Relatórios';

class Relatorios extends Controller {

    function index() {
        parent::render();
    }

    //TODO resolver de maneira que os parametros sejam definidos externamenta
    function lista() {
        $pagina = $_SESSION["parametros"]["pagina"];
        $busca = $_SESSION["parametros"]["busca"];
        $relatorio = new Relatorio();
        $relatorios = $relatorio->lista($pagina, $busca);
        $dados['relatorios'] = $relatorios;
        parent::json($dados);
    }

    function cadastro() {
        $id = isset($_SESSION["parametros"]["id"]) ? $_SESSION["parametros"]["id"] : NULL;
        $dados = array();
        if ($id) {
            $relatorio = new Relatorio();
            $dados['relatorioAtual'] = $relatorio->get($id);
        }
        $datasource = new Datasource();
        $datasources = $datasource->lista();
        $dados['datasources'] = $datasources;
        parent::render($dados);
    }

    function salvar() {
        $relatorio = new Relatorio();
        $dadosRelatorio = $_POST['relatorio'];
        $sucesso = $relatorio->salvar($dadosRelatorio);
        if ($sucesso) {
            $_SESSION['mensagem']['sucesso'] = "Relatório criado com sucesso.";
            parent::go2("Relatorios->index()");
        }
    }

    function gerar($datasource, $nomeRelatorio) {
        $r = new Relatorio();
        $relatorio = $r->selectByEquals("nome", $nomeRelatorio);
        $usuario = $_SESSION['user'];
        if ($r->checarAcesso($usuario->id_local, $relatorio[0]->id) !== TRUE) {
            $_SESSION['mensagem']['erro'] = "Acesso não autorizado a este formulário.";
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

}
