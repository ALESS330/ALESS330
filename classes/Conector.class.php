<?php

/**
 * Description of Conector
 *
 * @author marcos
 */
class Conector
{

    private $conexoes;
    private $erros;

    function __construct()
    {
        global $db;
        $this->conexoes["relatorios"] = new PDO("pgsql:dbname=" . $db['database'] . ";user=" . $db['user'] . ";password=" . $db['password'] . ";host=" . $db['server']);
        $t = $this->conexoes["relatorios"]->setAttribute(PDO::ATTR_PERSISTENT, true);
        $sqlDatasources = "SELECT id, nome, conexao FROM relatorios.datasources WHERE ativo = TRUE order by id desc";
        $r = $this->conexoes["relatorios"]->prepare($sqlDatasources);
        if (!$r) {
            print_r($this->conexoes->errorInfo());
        }
        $result = $r->execute();
        $conexoesBanco = $r->fetchAll(PDO::FETCH_ASSOC);
        $serverTried = "- -";
        try {
            foreach ($conexoesBanco as $conexaoAtual) {
                $stringConexao = $conexaoAtual["conexao"];
                $nome = $conexaoAtual["nome"];
                $serverTried = $nome;
                if (strpos($stringConexao, "mysql:") === 0) {
                    $dados = array();
                    preg_match("/;user=(.*?);/", $stringConexao, $dados);
                    $user = $dados[1];
                    $stringConexao = str_replace($dados[0], ";", $stringConexao);
                    preg_match("/;password=(.*?);/", $stringConexao, $dados);
                    $pass = $dados[1];
                    $stringConexao = str_replace($dados[0], ";", $stringConexao);
                    $this->conexoes[$nome] = new PDO($stringConexao, $user, $pass);
                    $this->conexoes[$nome]->query("SET NAMES utf8");
                } else {
                    $this->conexoes[$nome] = new PDO($stringConexao);
                } // else
            } // foreach
        } catch (PDOException $e) {
            echo "Erro de conexão com $serverTried";
            // $this->erros[] = "Erro de conexão com $serverTried";
        }
    }

    function getConexaoAGHU()
    {
        return $this->conexoes["aghu"];
    }

    function getConexaoSistema()
    {
        return $this->conexoes["relatorios"];
    }

    function getDados($sql, $conex)
    {
        try {
            $r = $conex->prepare($sql);
            $result = $r->execute();
            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);

            //se não veio nenhuma linha, é preciso extrair os nomes das colunas de outra maneira
            if (count($linhas) == 0) {
                //descobrir quantas colunas
                $nCols = $r->columnCount();
                $vazio = array();
                //se nenhum, é pq teve erro do banco de dados (falta campo, conexão etc)
                if ($nCols == 0) {
                    throw new Exception("Erro na busca dos campos");
                }
                //iterando pelas colunas existentes ...
                foreach (range(0, $nCols - 1) as $column_index) {
                    $columnMeta = $r->getColumnMeta($column_index)['name'];
                    //... e construindo um array para isso
                    $vazio[0][$columnMeta] = null;
                }
                return $vazio;
            }
        } catch (Exception $ex) {
            die("Conexão não efetuada $conex. (" . $ex->getMessage . ")");
        }
        return $linhas;
    }

    function getDadosSistema($sql)
    {
        return $this->getDados($sql, $this->conexoes["relatorios"]);
    }

    function getDadosAGHU($sql)
    {
        return $this->getDados($sql, $this->conexoes["aghu"]);
    }

    function getConexao($nome)
    {
        if (isset($this->conexoes[$nome])) {
            return $this->conexoes[$nome];
        }
        $oDatasource = new Datasource();
        $datasource = $oDatasource->selectBy(array("nome" => $nome))[0];
        throw new Exception("Conexão inexistente ou inativa para '$datasource->descricao' ($nome)");
    }
}
