<?php

$_CONTROLE = 'Relatorios';
$_ROTULO = 'Administração dos Relatórios';

require_once dirname(dirname(dirname(__FILE__))) . "/formularios/models/Formulario.class.php";
require_once dirname(dirname(dirname(__FILE__))) . "/formularios/utils/GeradorFormulario.class.php";

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
        $relatorio = $this->buscaOuNulo($idRelatorio);
        $objRelatorio = new Relatorio();
        $dados['relatorio'] = $relatorio;
        $dados['datasource'] = $objRelatorio->getDatasource($idRelatorio);
        $dados['gruposRelatorio'] = $this->relatorio->getGrupos($idRelatorio);
        $dados['grupos'] = $objRelatorio->listaGruposPossiveis($relatorio->id);
        $lFormatos = $objRelatorio->getFormatos($relatorio->id);
        $formatos = array();
        foreach ($lFormatos as $key => $value) {
            $formatos[$value->formato] = TRUE;
        }
        $dados['formatos'] = $formatos;
        if ($relatorio->parametrizado) {
            $tp = $this->relatorio->getTelaParametros($idRelatorio);
            $objFormulario = new Formulario();
            if ($tp) {
                $f = $objFormulario->get($tp[0]->formulario_id);
            } else {
                $f = NULL;
            }
            $dados['telaParametros'] = $f;
            $dados['telas'] = $objFormulario->listaTelas();
        }
        $this->render($dados);
    }

    function salvarFormatos($relatorioId) {
        $formatos = $_POST['formatos'];
        $this->relatorio->salvarFormatos($relatorioId, $formatos);
        $this->mensagemSucesso("Formatos salvos com suscesso");
        $this->go2("Relatorios->propriedades($relatorioId)");
    }

    function salvarTelaParametros($relatorioId) {
        $tela = $_POST['tela'];
        $this->relatorio->salvarTelaParametros($tela);
        $this->mensagemSucesso("Tela de Parâmetros associada com sucesso");
        parent::go2("Relatorios->propriedades($relatorioId)");
    }

    function associaGrupo($relatorioId, $grupoId) {
        $objRG = new RelatorioGrupo();
        $dadosRG['grupo_id'] = $grupoId;
        $dadosRG['relatorio_id'] = $relatorioId;
        $resultadoRG = $objRG->salvar($dadosRG);
        $this->mensagemSucesso("Relatório #$relatorioId associado ao grupo #$grupoId com sucesso.");
        $this->go2("Relatorios->propriedades($relatorioId)");
    }

    function removeGrupo($relatorioId, $grupoId) {
        $objRG = new RelatorioGrupo();
        $dadosRG = $objRG->busca($relatorioId, $grupoId);
        $objRG->deleta($dadosRG->id);
        $this->mensagemSucesso("Relatório #$relatorioId removido do grupo #$grupoId com sucesso.");
        $this->go2("Relatorios->propriedades($relatorioId)");
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
        $dadosRelatorio['parametrizado'] = isset($dadosRelatorio['parametrizado']) ? $dadosRelatorio['parametrizado'] : FALSE;
        $dadosRelatorio['publico'] = (($dadosRelatorio['publico'] ?? FALSE) == true) ? true : false;
        $dadosRelatorio['ativo'] = (($dadosRelatorio['ativo'] ?? FALSE) == true) ? true : false;
        if (isset($dadosRelatorio['id'])) {
            $id = $dadosRelatorio['id'];
        } else {
            $id = FALSE;
        }
        $novoId = $this->relatorio->salvar($dadosRelatorio);
        $relatorioId = $id ?: $novoId;

        $this->mensagemSucesso("Relatório salvo com sucesso.");
        if ($dadosRelatorio['parametrizado'] && $dadosRelatorio['parametrizado'] == TRUE) {
            parent::go2("Relatorios->propriedades($relatorioId)");
        } else {
            parent::go2("Relatorios->index()");
        }
    }

    function gerar($datasource, $nomeRelatorio) {
        global $_ROTULO;
        $_ROTULO = "Relatório";
        $relatorio = $this->relatorio->selectByEquals("nome", $nomeRelatorio)[0];
        if (!$relatorio->publico) {
            if ($this->relatorio->checarAcesso($relatorio->id, $_SESSION['login'] ?? NULL) !== TRUE) {
                $this->mensagemInfo("Acesso não autorizado a este relatório.");
                $this->go2("Application->index");
                exit();
            }
        }

        $parametros = count($_GET);
        if ($relatorio->parametrizado && !$parametros) {
            $_SESSION['action'] = $this->router->link("Relatorios->gerar($datasource,$nomeRelatorio)"); //$router
            $rt = new RelatorioTela();
            $_tela = $rt->getBy(array("relatorio_id" => $relatorio->id));
            if (!isset($_tela[0])) {
                throw new Exception("Impossível buscar tela de parâmetros.", 5);
            }
            $tela = $_tela[0];
            $formulario = new Formulario();
            $_f = $formulario->getBy(array("id" => $tela->formulario_id));
            $f = $_f[0];
            global $corSistema;
            $_SESSION['corEmprestada'] = $corSistema;
            $_SESSION['tituloEmprestado'] = $_ROTULO;
            parent::go2("/formularios/tela-relatorio/$f->nome");
        }
        $objRelatorio = new Relatorio();
        $lFormatos = $objRelatorio->getFormatos($relatorio->id);
        if (count($lFormatos) == 1) {
            if ($lFormatos[0]->formato === "pdf") {
                $this->forcaDownload('pdf', $datasource, $nomeRelatorio, $parametros);
            }
            if ($lFormatos[0]->formato === "csv") {
                $this->forcaDownload("csv", $datasource, $nomeRelatorio, $parametros);
            }
        }

        $construtor = new ConstrutorRelatorios();
        $data['relatorio'] = $construtor->getRelatorio($nomeRelatorio, $datasource);
        if (!$data['relatorio']) {
            $dados = array();
            $dados['mensagem'] = "Dados não encontrados. Verifique os parâmetros";
            $erro = new Erro();
            $erro->generico($dados);
            //$this->go2("Erro->generico");
        } else {
            //unset($_SESSION['mensagem']['info']);
        }
        $data['estrutura'] = $construtor->getEstruturaRelatorio($nomeRelatorio);
        $imprimir = isset($_GET['imprimir']) ? $_GET['imprimir'] : "";
        $impressora = isset($_GET['impressora']) ? $_GET['impressora'] : "";
        $u = explode("&imprimir=", $_SERVER['REQUEST_URI'])[0];
        if ($imprimir) {
            if (!$impressora) {
                $this->mensagemAlerta("Selecione a impressora");
            } else {
                $r = $this->toPulseira($datasource, $nomeRelatorio, $impressora);
                if ($r) {
                    $this->mensagemSucesso("Relatório impresso com sucesso!");
                } else {
                    $s = $_SESSION['erro-pulseira'];
                    unset($_SESSION['erro-pulseira']);
                    $this->mensagemErro("Falha ao imprimir o relatório! ($s)");
                }
            }
            $this->go2("$u");
        }
        parent::render($data);
    }

    private function forcaDownload($formato, $datasource, $nomeRelatorio, $parametros = NULL) {
        $nome = "";
        if($parametros){
            $p = $_SESSION['parametros'];
            unset($p['__ANONIMOS__']);
            unset($p['telaId']);
            unset($p['formularioId']);
            $nome = $nomeRelatorio."[" . implode("_", $p) . "])";
        }else{
            $nome = "$nomeRelatorio";
        }
        if ($formato === "csv") {
            $csv = $this->gerarCsv($datasource, $nomeRelatorio, $parametros);
            header("Content-Description: File Transfer"); 
            header("Content-Type: application/octet-stream"); 
            header("Content-Disposition: attachment; filename=$nome.csv"); 
            echo $csv;
            exit(0);
        }
        if ($formato === "pdf") {
            return $this->gerarPdf($datasource, $nomeRelatorio, "$nome.pdf");
        }
        
    }

    function gerarPdf($datasource, $nomeRelatorio, $nomePDFDownload = NULL) {
        $data = array();
        global $sisbase, $filename;
        $filename = $nomePDFDownload;        
        $construtor = new ConstrutorRelatorios();
        $data['html'] = $construtor->getRelatorio($nomeRelatorio, $datasource);
        $estrutura = $construtor->getEstruturaRelatorio($nomeRelatorio)[0];
        $data['nome'] = $estrutura['nome_relatorio'];
        $data['descricao'] = $estrutura['descricao'];
        ini_set("max_execution_time", 90);
        $layout = "Relatorios/layouts/$nomeRelatorio";
        $arquivoLayout = "$sisbase/view/$layout.php";
        if(file_exists($arquivoLayout)){
            $this->renderPDFview($layout, $data, NULL);
        }
        $this->renderPDF($data);
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

    function gerarCsv($datasource, $nomeRelatorio, $parametros = NULL) {
        $construtor = new ConstrutorRelatorios();
        $estrutura = $construtor->getEstruturaRelatorio($nomeRelatorio)[0];
        $suportaCSV = $this->relatorio->checaFormato($estrutura['relatorio_id'], 'csv')->suporta;
        if (!$suportaCSV) {
            throw new Exception("Formato CSV não suportado para esse relatório.", 8);
        }
        $data = array();
        $data['dados'] = $construtor->getDadosRaw($nomeRelatorio, $datasource);
        $data['tipo'] = $estrutura['tipo'];
        $data['coluna_grupo'] = $estrutura['coluna_grupo'];
        $data['nome_relatorio'] = $nomeRelatorio;
        return $this->renderCsv($data);
    }

    private function toPulseira($datasource, $nomeRelatorio, $impressora) {
        $impressora = "/printers/$impressora";
        $construtor = new ConstrutorRelatorios();
        $dados = $construtor->getDados($nomeRelatorio, $datasource);
        require_once dirname(__FILE__) . '/../classes/lib/print-ipp/PrintIPP.php';
        require_once dirname(__FILE__) . '/../classes/lib/zplimg/image2zpl.inc.php';
        require_once dirname(__FILE__) . '/../classes/lib/phpqrcode/qrlib.php';

        $pulseira = new stdClass();
        foreach ($dados[0] as $nome => $valor) {
            $pulseira->$nome = $valor;
        }

        date_default_timezone_set('America/Campo_Grande');
        $data_impressao = date("Y/m/d H:i:s");
        $user_impressao = "";
        $pulseira_id = "";
        rand(1000000, 9000000);
        $str_qrcode = "PRONTUARIO: $pulseira->prontuario
NOME: $pulseira->nome
NOME_MAE: $pulseira->nome_mae
DATA_NASC: $pulseira->data_nascimento
($data_impressao|$user_impressao|#$pulseira_id)";

        $arquivoQr = "./qr$pulseira->prontuario.png";
        QRCode::png($str_qrcode, $arquivoQr, QR_ECLEVEL_L, 4);
        $input = file_get_contents($arquivoQr);
        $qrcodezebra = wbmp_to_zpl($input, "qr$pulseira->prontuario");
        $nomeQRZebra = substr($qrcodezebra, 3, (strlen("qr" . $pulseira->prontuario) - 1));

        $ipp = new PrintIPP();
        $ipp->setHost('10.18.0.38');
        $ipp->setPrinterURI($impressora);
        $ipp->setMimeMediaType("application/vnd.cups-raw");

        require_once dirname("..") . "/view/Relatorios/layouts/$nomeRelatorio.prn.php";

        $ipp->setData($layout);
        $s = $ipp->printJob();
        if ($s == "successfull-ok") {
            return TRUE;
        }
        $_SESSION['erro-pulseira'] = $s;
        return FALSE;
    }

}
