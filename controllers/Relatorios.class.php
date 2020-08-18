<?php

$_CONTROLE = 'Relatorios';
$_ROTULO = 'Administração dos Relatórios';

require_once dirname(dirname(dirname(__FILE__))) . "/formularios/models/Formulario.class.php";
require_once dirname(dirname(dirname(__FILE__))) . "/formularios/models/RestricaoFormulario.class.php";
require_once dirname(dirname(dirname(__FILE__))) . "/formularios/utils/GeradorFormulario.class.php";

class Relatorios extends Controller {

    private $relatorio;  
    private $construtor;
    private $composicao;
    
    public function __construct() {
        parent::__construct();
        $this->relatorio = new Relatorio();
        $this->construtor = new ConstrutorRelatorios();
        $this->composicao = new Composicao();
        $this->setObjeto($this->relatorio);
    }

    function index() {
        $this->render();
    }
    
    function gerado($datasource, $nomeRelatorio){
        if(isset($_SESSION['gerado']["$datasource/$nomeRelatorio"])){
            $dados['gerado'] = $_SESSION['gerado']["$datasource/$nomeRelatorio"];
            unset($_SESSION['gerado']["$datasource/$nomeRelatorio"]);
        }else{
            $dados['gerado']["$datasource/$nomeRelatorio"] = false;
        }
        $this->json($dados);
    }

    function pagina($pagina = 1, $busca = " ") {
        $this->json($this->relatorio->pagina($pagina, $busca));
    }

    function propriedades($idRelatorio) {
        $relatorio = $this->buscaOuNulo($idRelatorio);
        $dados['relatorio'] = $relatorio;
        $dados['listaRelatorios'] = $this->relatorio->listaAtivos();
        $dados['datasource'] = $this->relatorio->getDatasource($idRelatorio);
        $dados['gruposRelatorio'] = $this->relatorio->getGrupos($idRelatorio);
        $dados['grupos'] = $this->relatorio->listaGruposPossiveis($relatorio->id);
        $lFormatos = $this->relatorio->getFormatos($relatorio->id);
        $formatos = array();
        foreach ($lFormatos as $value) {
            $formatos[$value->formato] = TRUE;
        }
        $dados['formatos'] = $formatos;
        $dados['decoradores'] = $this->relatorio->getDecoradores($idRelatorio);
        $oTipoDecorador = new TipoDecorador();
        $oTipoComposicao = new TipoComposicao();
        $dados['tipos_decoradores'] = $oTipoDecorador->lista();
        $dados['tipos_composicoes'] = $oTipoComposicao->lista();
        $dados['composicao'] = $this->relatorio->getComposicao($relatorio->id);
        if ($relatorio->parametrizado) {
            $tp = $this->relatorio->getTelaParametros($idRelatorio);
            $objFormulario = new Formulario();
            if ($tp) {
                $f = $objFormulario->get($tp->formulario_id);
            } else {
                $f = NULL;
            }
            $dados['telaParametros'] = $tp;
            $dados['telas'] = $objFormulario->listaTelas();
        }
        $this->render($dados);
    }

    function salvarFormatos($relatorioId) {
        $formatos = isset($_POST['formatos']) ? $_POST['formatos'] : NULL;
        $this->relatorio->salvarFormatos($relatorioId, $formatos);
        $this->mensagemSucesso("Formatos salvos com suscesso");
        $this->go2("Relatorios->propriedades($relatorioId)");
    }

    function salvarDecoradores($relatorioId) {
        $relatorio = $this->buscaOuNulo($relatorioId);
        $oDecorador = new Decorador();
        $decoradores = $_POST['decoradores'] ?? array();
        $novoDecorador = $_POST['novoDecorador'] ?? false;
        try {
            $this->relatorio->getConex()->transaction();
            $decorador['relatorio_id'] = $relatorio->id;
            foreach ($decoradores as $i => $decorador) {
                $decorador['id'] = $i;
                if (!isset($decorador['ativo'])) {
                    $decorador['ativo'] = false;
                }//if
                $oDecorador->salvar($decorador);
            }//foreach
            if ($novoDecorador['nome_campo'] && $novoDecorador['parametro'] && $novoDecorador['tipo_decorador_id'] && $novoDecorador['ordem']) {
                $novoDecorador['ativo'] = isset($novoDecorador['ativo']) ? $novoDecorador['ativo'] : false;
                $novoDecorador['relatorio_id'] = $relatorio->id;
                $id = $oDecorador->salvar($novoDecorador);
            }//if
            $this->relatorio->getConex()->commit();
        } catch (Exception $e) {
            $this->relatorio->getConex()->rollback();
            $this->erro("Relatorios->propriedades($relatorioId)", "Erro ao salvar ($e->getMessage())");
        }//catch
        $msgSalvo = $id ? "Decorador " . $novoDecorador['nome_campo'] . "salvo com sucesso #$id" : '';
        $this->sucesso("Relatorios->propriedades($relatorioId)", "Decoradores salvos com sucesso. $msgSalvo");
    }

    function salvarTelaParametros($relatorioId) {
        $tela = $_POST['tela'];
        $this->relatorio->salvarTelaParametros($tela);
        $this->mensagemSucesso("Tela de Parâmetros associada com sucesso");
        $this->go2("Relatorios->propriedades($relatorioId)");
    }
    
    function salvarComposicao(){
        $dadosComposicao = $_POST['composicao'];
        $dadosComposicao['obrigatoria'] = isset($dadosComposicao['obrigadoria']) ? $dadosComposicao['obrigatoria'] : false;
        $this->composicao->salvar($dadosComposicao);
        $this->sucesso("Relatorios->propriedades(" . $dadosComposicao['relatorio_principal_id'] . ")", "Componente salvo com sucesso.");        
    }

    function excluirComposicao($relatorioId, $composicaoId){
        $relatorio = $this->buscaOuNulo($relatorioId);
        $this->composicao->deleta($composicaoId);
        $this->sucesso("Relatorios->propriedades($relatorioId)", "Componente para o relatório $relatorio->nome excluído com sucesso.");
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

    function novo(){
        $this->cadastro();
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
        $relatorio = $this->relatorio->selectByEquals("nome", $nomeRelatorio);
        if (count($relatorio) !== 1) {
            throw new Exception("Esse relatório não existe!");
        } else {
            $relatorio = $relatorio[0];
        }
        if (!$relatorio->ativo){
            throw new Exception("Relatório desativado. Procure o responsável pelas informações.");
        }
        
        $_SESSION['relatorioId'] = $relatorio->id;        
        if (!$relatorio->publico) {
            if (!isset($_SESSION['login'])) {
                $url = $_SESSION['PAGINA'] = $_SERVER['REQUEST_URI'];
                $a = new Acessos();
                $a->login($url);
            } else if ($this->relatorio->checarAcesso($relatorio->id, $_SESSION['login'] ?? NULL) !== TRUE) {
                $this->mensagemInfo("Acesso não autorizado a este relatório.");
                $this->go2("Appplication->index");
                exit();
            }//else if
        }//if (public)

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
            $this->go2("/formularios/tela-relatorio/$f->nome");
        }//if
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
        global $sisbase;
        $layout = $sisbase . "/view/Relatorios/layouts/$nomeRelatorio.php";
        $data['layout'] = false;
        if (file_exists($layout)) {
            $data['layout'] = true;
        }
        if (!$data['relatorio']) {
            $dados = array();
            $dados['mensagem'] = "Dados não encontrados. Verifique os parâmetros";
            $dados['debug'] = $_SESSION['sql_relatorio']; 
            unset($_SESSION['sql_relatorio']);
            $erro = new Erro();
            $erro->generico($dados);
            exit();
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
                if($nomeRelatorio === "etiquetas-farmacia"){
                    $r = $this->toEtiqueta($datasource, $nomeRelatorio, $impressora);
                    if($r){
                        $this->mensagemSucesso("Etiqueta impressa com sucesso!");
                    }else{
                        $s = $_SESSION['erro-etiqueta'];
                        unset($_SESSION['erro-etiqueta']);
                        $this->mensagemErro("Falha ao imprimir etiqueta! ($s)");
                    }//else
                }else{
                    $r = $this->toPulseira($datasource, $nomeRelatorio, $impressora);
                    if ($r) {
                        $this->mensagemSucesso("Relatório impresso com sucesso!");
                    } else {
                        $s = $_SESSION['erro-pulseira'];
                        unset($_SESSION['erro-pulseira']);
                        $this->mensagemErro("Falha ao imprimir o relatório! ($s)");
                    }//else
                }//else
            }//else
            $this->go2("$u");
        }
        $this->render($data);
    }//gerar

    private function forcaDownload($formato, $datasource, $nomeRelatorio, $parametros = NULL) {
        $nome = "";
        if ($parametros) {
            $p = $_SESSION['parametros'];
            unset($p['__ANONIMOS__']);
            unset($p['telaId']);
            unset($p['formularioId']);
            $nome = $nomeRelatorio . "[" . implode("_", $p) . "])";
        } else {
            $nome = "$nomeRelatorio";
        }
        if ($formato === "csv") {
            //$csv = $this->gerarCsv($datasource, $nomeRelatorio, $parametros);
//            header("Content-Description: File Transfer");
//            header("Content-Type: application/octet-stream");
//            header("Content-Disposition: attachment; filename=$nome.csv");
//            echo $csv;
//            exit(0);
            $this->gerarCsv($datasource, $nomeRelatorio, $parametros);
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
        $data['template'] = "relatorio-tmpl";
        $construtor = new ConstrutorRelatorios();
        $data['html'] = $construtor->getRelatorio($nomeRelatorio, $datasource);
        $estrutura = $construtor->getEstruturaRelatorio($nomeRelatorio)[0];
        $data['nome'] = $estrutura['nome_relatorio'];
        $data['descricao'] = $estrutura['descricao'];
        ini_set("max_execution_time", 90);
        $layout = "Relatorios/layouts/$nomeRelatorio";
        $arquivoLayout = "$sisbase/view/$layout.php";
        if (file_exists($arquivoLayout)) {
            $this->renderPDFview($layout, $data, NULL, 'template-pdf');
        }
        $this->renderPDF($data);
    }

    function downloadHtmlAsPDF() {
        $relatorioId = isset($_SESSION['relatorioId']) ? $_SESSION['relatorioId'] : FALSE;
        if (!$relatorioId) {
            throw new Exception("É necessário gerar o relatório antes.");
        }
        $relatorio = $this->buscaOuNulo($relatorioId);
        unset($_SESSION['relatorioId']);
        if ($this->relatorio->checarAcesso($relatorioId, $_SESSION['login'] ?? NULL) !== TRUE) {
            $this->mensagemInfo("Acesso não autorizado a este relatório.");
        }
        $dados['html'] = $_POST['html'];
        $dados['titulo'] = $_POST['titulo'] ?? "relatorio";
        $dados['filename'] = $_POST['filename'] ?? NULL;
        $_SESSION['gerado']["$relatorio->datasource/$relatorio->nome"] = true;
        $this->renderRawHtmlAsPDF($dados, 'relatorio-tmpl');
    }

    function printHTML(){
        $html = $_POST['html'];
        $this->downloadHtml($html);
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
        $estrutura = $construtor->getEstruturaRelatorio($nomeRelatorio);
        $suportaCSV = $this->relatorio->checaFormato($estrutura['relatorio_id'], 'csv')->suporta;
        if (!$suportaCSV) {
            throw new Exception("Formato CSV não suportado para esse relatório.", 8);
        }

        if ($parametros) {
            $p = $_SESSION['parametros'];
            unset($p['__ANONIMOS__']);
            unset($p['telaId']);
            unset($p['formularioId']);
            $nome = $nomeRelatorio . "[" . implode("_", $p) . "])";
        } else {
            $nome = "$nomeRelatorio";
        }
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=$nome.csv");
        $data = array();
        $data['dados'] = $construtor->getDadosRaw($nomeRelatorio, $datasource);
        $data['tipo'] = $estrutura['tipo'];
        $data['coluna_grupo'] = $estrutura['coluna_grupo'];
        $data['nome_relatorio'] = $nomeRelatorio;
        echo $this->renderCsv($data);
        exit(0);
    }

//gerarCsv

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

    private function toEtiqueta($datasource, $nomeRelatorio, $impressora) {
        error_reporting(E_ALL ^ E_DEPRECATED);
        $impressora = "/printers/$impressora";
        $construtor = new ConstrutorRelatorios();
        $dados = $construtor->getDados($nomeRelatorio, $datasource);
        
        $etiquetas = $dados;
        
//        for($i=1;$i<=3;$i++){
//            $nome = "etiqueta$i";
//            $$nome = new stdClass();
//            $$nome->prontuario = "";
//            $$nome->nome = "";
//            $$nome->nascimento = "";
//        }
//        
//        foreach ($dados as $i => $etiqueta){
//            $nome = "etiqueta" . ($i+1);
//            $$nome = new stdClass();
//            foreach ($etiqueta as $n => $valor){
//                $$nome->$n = $valor;
//            }
//        }
        
        require_once dirname(__FILE__) . '/../classes/lib/print-ipp/PrintIPP.php';
        require_once dirname(__FILE__) . '/../classes/lib/zplimg/image2zpl.inc.php';
        require_once dirname(__FILE__) . '/../classes/lib/phpqrcode/qrlib.php';

        $ipp = new PrintIPP();
        $ipp->setHost('10.18.0.38');
        $ipp->setPrinterURI($impressora);
        $ipp->setMimeMediaType("application/vnd.cups-raw");

        require_once dirname("..") . "/view/Relatorios/layouts/$nomeRelatorio.prn.php";

        $ipp->setData($layout);
        $s = $ipp->printJob();
        error_reporting(E_ALL);       
        if ($s == "successfull-ok") {
            return TRUE;
        }
        $_SESSION['erro-pulseira'] = $s;
        return FALSE;
    }    
}
