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
        $dadosRelatorio = $this->getEstruturaRelatorio($nome)[0];        
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
        $dadosRelatorio = $this->getEstruturaRelatorio($nome)[0];
        $layout = $sisbase . "/view/Relatorios/layouts/$nome.php";
        $colunaGrupo = $dadosRelatorio["coluna_grupo"];
        $nomeFilho = $dadosRelatorio["nome_filho"];
        $dados = $this->getDados($nome, $datasource);
        if(count($dados)==0){
            return NULL;
        }
        if (file_exists($layout)) {
            //$r significa relatório
            $r = $this->layout($layout, $dados);
        } else {
            $r = $this->relatorio($dados, $dadosRelatorio['tipo'], $colunaGrupo, $nomeFilho);
        }
        return $r;
    }

    public function getEstruturaRelatorio($nome) {
        $sqlRelatorio = "
SELECT 
    r.id relatorio_id
    , r.codigo_sql
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
            $sql = str_replace('$'.$nome, $valor, $sql);
        }
        return $sql;
    }

    public function layout($layout, $dados){
        ob_start();
        require_once $layout;
        $c = ob_get_clean();
        return $c;
    }
}
