<?php

/**
 * Description of Conector
 *
 * @author marcos
 */
class Conector {

    private $conexoes;

    function __construct() {
        $this->conexoes["relatorios"] = new PDO("pgsql:dbname=teste;user=teste;password=teste;host=200.129.232.47");
        $t = $this->conexoes["relatorios"]->setAttribute(PDO::ATTR_PERSISTENT, true);
        $sqlDatasources = "SELECT id, nome, conexao FROM relatorios.datasources order by id desc";
        $r = $this->conexoes["relatorios"]->prepare($sqlDatasources);
        if (!$r) {
            print_r($this->conexoes->errorInfo());
        }
        $result = $r->execute();
        $conexoesBanco = $r->fetchAll(PDO::FETCH_ASSOC);
        try {
            foreach ($conexoesBanco as $conexaoAtual) {
                $stringConexao = $conexaoAtual["conexao"];
                $nome = $conexaoAtual["nome"];
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
                }
            }
        } catch (PDOException $e) {
            echo "<pre>";
            echo "Erro de conexão:\n";
            print_r($e);
            echo "$stringConexao";
            die("</pre>");
        }
    }

    function getConexaoAGHU() {
        return $this->conexoes["aghu"];
    }

    function getConexaoSistema() {
        return $this->conexoes["relatorios"];
    }

    function getDados($sql, $conex) {
        $r = $conex->prepare($sql);
        $result = $r->execute();
        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
        return $linhas;
    }

    function getDadosSistema($sql) {
        return $this->getDados($sql, $this->conexoes["relatorios"]);
    }

    function getDadosAGHU($sql) {
        return $this->getDados($sql, $this->conexoes["aghu"]);
    }

    function getConexao($nome) {
        return $this->conexoes[$nome];
    }

}
