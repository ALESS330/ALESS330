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

    private function getDados($nome, $datasource) {
        $dadosRelatorio = $this->getEstruturaRelatorio($nome);
        $parametros = $_SESSION['parametros'];
        $sqlBanco = $dadosRelatorio[0]["codigo_sql"];
        $conexaoRelatorio = $this->conector->getConexao($datasource);
        if ($dadosRelatorio[0]['tipo'] == "filtro") {
            $sql = $this->processaParametros($parametros, $sqlBanco);
        } else {
            $sql = $sqlBanco;
        }
        $dados = $this->conector->getDados($sql, $conexaoRelatorio);

        if (count($dados) == 0) {
            throw new Exception("Relatório vazio: $nome");
        }
        return $dados;
    }

    function getRelatorio($nome, $datasource) {

        $dadosRelatorio = $this->getEstruturaRelatorio($nome);
        $colunaGrupo = $dadosRelatorio[0]["coluna_grupo"];
        $nomeFilho = $dadosRelatorio[0]["nome_filho"];
        $dados = $this->getDados($nome, $datasource);
        return $this->relatorio($dados, $dadosRelatorio[0]['tipo'], $colunaGrupo, $nomeFilho);
    }

    public function getEstruturaRelatorio($nome) {
        $sqlRelatorio = ""
                . "SELECT \n"
                . "    r.codigo_sql, \n"
                . "    r.nome as nome_relatorio, \n"
                . "    r.descricao, \n"
                . "    r.tipo, \n"
                . "    d.nome as nome_datasource, \n"
                . "    d.id as id_datasource, \n"
                . "    r.coluna_grupo, \n"
                . "    rfilho.nome as nome_filho \n"
                . "FROM \n"
                . "    relatorios.relatorios r INNER JOIN \n"
                . "    relatorios.datasources d ON r.datasource_id = d.id LEFT JOIN \n"
                . "    relatorios.relatorios rfilho ON r.id = rfilho.relatorio_pai_id \n"
                . "WHERE r.nome = '$nome'";
        $dadosRelatorio = $this->conector->getDadosSistema($sqlRelatorio);

        if (count($dadosRelatorio) == 0) {
            throw new Exception("Relatório Inexistente!");
        }

        return $dadosRelatorio;
    }

    public function getTituloRelatorio($nomeTitulo, $parametro) {
        $estruturaRelatorio = $this->getEstruturaRelatorio($nomeTitulo);
        $sql = str_replace(":parametro", $parametro, $estruturaRelatorio[0]["codigo_sql"]);
        $dados = $this->conector->getDados($sql, $this->conector->getConexao($estruturaRelatorio[0]["nome_datasource"]));
        return $dados[0]["titulo"];
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

        return;
        echo '<pre>';
        print_r($parametros);
        echo "\n-------------------------------\n-------------------------------\n";
        die($sql);
    }

}
