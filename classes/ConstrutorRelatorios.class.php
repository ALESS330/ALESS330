<?php

/**
 * Description of Relatorios
 *
 * @author marcos
 */
class ConstrutorRelatorios {

    private $gerador;
    private $conector;

    public function __construct() {
        $this->gerador = new GeradorRelatorio();
        $this->conector = new Conector();
    }

    public function getDados($nome, $datasource) {
        $dadosRelatorio = $this->getEstruturaRelatorio($nome);
        $parametros = $_SESSION['parametros'];
        $sqlBanco = $dadosRelatorio["codigo_sql"];
        $conexaoRelatorio = $this->conector->getConexao($datasource);
        if ($dadosRelatorio['parametrizado'] == true) {
            $sql = $this->processaParametros($parametros, $sqlBanco);
        } else {
            $sql = $sqlBanco;
        }
        $dados = $this->conector->getDados($sql, $conexaoRelatorio);
        return $dados;
    }

    function getRelatorio($nome, $datasource) {
        global $sisbase;
        $estruturaRelatorio = $this->getEstruturaRelatorio($nome);
        //var_dump($dadosRelatorio); exit(0);
        $layout = $sisbase . "/view/Relatorios/layouts/$nome.php";
        $colunaGrupo = $estruturaRelatorio["coluna_grupo"];
        $nomeFilho = $estruturaRelatorio["nome_filho"];
        $dadosDesteRelatorio = $this->getDados($nome, $datasource);
        if ($estruturaRelatorio['tipo_composicao_id']) {
            switch ($estruturaRelatorio['nome_composicao']) {
                case 'anexacao':
                    $dadosCompostos = $this->anexaDados($dadosDesteRelatorio, $estruturaRelatorio);
                    break;
                case 'detalhamento':
                    $dadosCompostos = $this->detalhaDados($dadosDesteRelatorio, $estruturaRelatorio);
                    break;
                default:
                    throw new Exception("Tipo de composição não implementada");
                    break;
            }
            $dados = $dadosCompostos;
        } else {
            $dados = $dadosDesteRelatorio;
        }
        
        $totalLinhas = count($dados);
        if ($totalLinhas == 0) {
            return NULL;
        }

        $oDecorador = new Decorador();
        $decoradores = $oDecorador->decoradores($estruturaRelatorio['relatorio_id']);
        if ($decoradores) {
            $dadosDecorados = $oDecorador->decorar($dados, $decoradores);
        } else {
            $dadosDecorados = $dados;
        }
        if (file_exists($layout)) {
            //$r significa relatório
            $r = $this->layout($layout, $dadosDecorados);
            return $r;
        }

        $r = $this->relatorio($dadosDecorados, $estruturaRelatorio['tipo'], $colunaGrupo, $nomeFilho);
        return $r;
    }

    function anexaDados($dados, $estruturaPrincipal) {
        $nc = $estruturaPrincipal['nome_componente']; // nc significa nome do componente
        $ec = $this->getEstruturaRelatorio($nc); // ec significa estrutura do componente
        $identificadorPrincipal = $estruturaPrincipal['campo_identificador_principal'];
        $identificadorComponente = $estruturaPrincipal['campo_identificador_componente'];
        $dadosComponente = $this->getDados($nc, $ec['nome_datasource']);

        $dadosIndexadosComponente = array();
        foreach ($dadosComponente as $indiceComponente => $linhaComponente) {
            $dadosIndexadosComponente[$linhaComponente[$identificadorComponente]] = $linhaComponente;
        }
        
        $colunas = array_keys($dadosComponente[0]);
        $colunasArrayVazio = [];
        foreach ($colunas as $c) {
            $colunasArrayVazio[$c] = null;
        }
        $dadosCompletos = array();
        foreach ($dados as $iLinha => $linha) {
            foreach ($dadosComponente as $ic => $dc) {
                $valorIdentificadorAtual = $linha[$identificadorPrincipal];
                if(isset($dadosIndexadosComponente[$valorIdentificadorAtual])){
                    $linha += $dadosIndexadosComponente[$valorIdentificadorAtual];
                    unset($dadosIndexadosComponente[$valorIdentificadorAtual]);
                } else{
                    $linha += $colunasArrayVazio;
                }
            } //foreach $dadosComponente
            $dadosCompletos[] = $linha;
        }//foreach $linha 
        return $dadosCompletos;
    }

    public function getEstruturaRelatorio($nome) {
        $sqlRelatorio = "
select  
    r.id relatorio_id
    , r.codigo_sql
    , r.nome as nome_relatorio
    , r.descricao
    , r.tipo
    , d.nome nome_datasource
    , d.id as id_datasource
    , r.coluna_grupo
    , rfilho.nome as nome_filho
    , r.parametrizado
    , tc.nome nome_composicao
    , tc.descricao
    , c.*
    , rc.nome nome_componente
from 
    relatorios.relatorios r 
    join relatorios.datasources d ON r.datasource_id = d.id
    left join relatorios.relatorios rfilho ON r.id = rfilho.relatorio_pai_id
    left join relatorios.composicoes c on c.relatorio_principal_id = r.id 
    left join relatorios.tipos_composicoes tc on c.tipo_composicao_id = tc.id 
    left join relatorios.relatorios rc on rc.id = c.relatorio_componente_id 
where true 
	and r.nome = '$nome'";
        $dadosRelatorio = $this->conector->getDadosSistema($sqlRelatorio);

        if (count($dadosRelatorio) == 0) {
            throw new Exception("Relatório $nome inexistente!");
        }

        return $dadosRelatorio[0];
    }

    public function getTituloRelatorio($nomeTitulo, $parametro) {
        $estruturaRelatorio = $this->getEstruturaRelatorio($nomeTitulo);
        // /*
        echo "<pre>";
        echo "\nprint_r:\n";
        print_r($estruturaRelatorio);
        echo "\nvar_dump\n";
        var_dump($estruturaRelatorio);
        echo "</pre>";
        die("concluido...");
// */
        $sql = str_replace(":parametro", $parametro, $estruturaRelatorio["codigo_sql"]);
        $dados = $this->conector->getDados($sql, $this->conector->getConexao($estruturaRelatorio["nome_datasource"]));
        return $dados["titulo"];
    }

    private function relatorio($dados, $tipo, $colunaGrupo) {
        $tabela = "";
        if ($tipo == "simples") {
            $tabela .= $this->gerador->geraTabela($dados, NULL);
        }

        if ($tipo == "agrupado") {
            $tabela .= $this->gerador->geraTabelaGrupo($dados, $colunaGrupo);
        }

        return $tabela;
    }

    public function getDadosRaw($nome, $datasource) {
        return $this->getDados($nome, $datasource);
    }

    public function processaParametros($parametros, $sql) {
        unset($parametros['__ANONIMOS__']);
        foreach ($parametros as $nome => $valor) {
            $sql = str_replace('$' . $nome, $valor, $sql);
        }
        return $sql;
    }

    public function layout($layout, $dados) {
        ob_start();
        require_once $layout;
        $c = ob_get_clean();
        return $c;
    }

}
