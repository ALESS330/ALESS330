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
        if ($dadosRelatorio[0]['parametrizado'] == true) {
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
        global $sisbase;
        $dadosRelatorio = $this->getEstruturaRelatorio($nome);
        $layout = $sisbase . "/view/Relatorios/layouts/$nome.php";
        $colunaGrupo = $dadosRelatorio[0]["coluna_grupo"];
        $nomeFilho = $dadosRelatorio[0]["nome_filho"];
        $dados = $this->getDados($nome, $datasource);
        if (file_exists($layout)) {
            //$r significa relatório
            $r = $this->layout($layout, $dados);
        } else {
            $r = $this->relatorio($dados, $dadosRelatorio[0]['tipo'], $colunaGrupo, $nomeFilho);
        }
        return $r;
    }

    public function getEstruturaRelatorio($nome) {
        $sqlRelatorio = "
SELECT 
    r.codigo_sql
    ,r.nome as nome_relatorio
    ,r.descricao
    ,r.tipo
    ,d.nome nome_datasource
    ,d.id as id_datasource
    ,r.coluna_grupo
    ,rfilho.nome as nome_filho
    ,r.parametrizado
FROM
    relatorios.relatorios r INNER JOIN
    relatorios.datasources d ON r.datasource_id = d.id LEFT JOIN
    relatorios.relatorios rfilho ON r.id = rfilho.relatorio_pai_id
WHERE r.nome = '$nome'";
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

        unset($parametros['__ANONIMOS__']);
        foreach ($parametros as $nome => $valor) {
            $$nome = $valor;
        }
        eval('$s="' . $sql.'";');
        return $s;
    }

    public function layout($layout, $dados){
        ob_start();
        require_once $layout;
        $c = ob_get_clean();
        return $c;
    }
}
