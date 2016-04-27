<?php

$_CONTROLE = 'Relatorio';
$_ROTULO = 'Relatório';

class Relatorio extends Model {

    public function get($idRelatorio) {
        $sql = "SELECT * FROM relatorios.relatorios WHERE id = $idRelatorio";
        return $this->db->consulta($sql)[0];
    }

    public function lista($pagina, $busca) {
        if (!$busca) {
            $busca = "";
        }
        $busca = urldecode($busca);
        $busca = str_replace(" ", "%", $busca);
        $start = ($pagina - 1) * $this->NUMERO_LINHAS;
        $sql = "SELECT \n"
                . "    r.id, \n"
                . "    r.nome, \n"
                . "    r.descricao, \n"
                . "    d.nome as datasource \n"
                . "FROM \n"
                . "    relatorios.relatorios r INNER JOIN \n"
                . "    relatorios.datasources d ON r.datasource_id = d.id \n"
                . "WHERE \n"
                . "    r.nome ILIKE '%$busca%' OR \n"
                . "    r.descricao ILIKE '%$busca%' OR \n"
                . "    d.nome ILIKE '%$busca%' \n"
                . "ORDER BY \n"
                . "    r.nome \n"
                . "OFFSET $start \n"
                . "LIMIT $this->NUMERO_LINHAS\n";
        $lista = $this->db->consulta($sql);
        return $lista;
    }

    function salvar($relatorio) {
        $nome = $relatorio['nome'];
        $descricao = $relatorio['descricao'];
        $codigo_sql = ($relatorio['sql']);
        $tipo = $relatorio['tipo'];
        $datasource_id = $relatorio['datasource'];
        $coluna_grupo = $relatorio['coluna_grupo'] ?: "NULL";
        $relatorio_pai_id = $relatorio['pai'] ?: "NULL";

        $codigo_sql = preg_replace("[']", "''", $codigo_sql);
        $sql = "";
        if (isset($relatorio["id"])) {
            $id = $relatorio["id"];
            $sql = "UPDATE relatorios.relatorios SET\n"
                    . "   nome = '$nome', \n"
                    . "   codigo_sql = '$codigo_sql', \n"
                    . "   descricao = '$descricao', \n"
                    . "   tipo = '$tipo', \n"
                    . "   datasource_id = $datasource_id, \n"
                    . "   coluna_grupo = '$coluna_grupo', \n"
                    . "   relatorio_pai_id = $relatorio_pai_id \n"
                    . "WHERE \n"
                    . "    id = $id";
        } else {
            $sql = "INSERT INTO relatorios.relatorios \n"
                    . "    (nome, codigo_sql, descricao, \n"
                    . "     tipo, datasource_id, coluna_grupo, \n"
                    . "     relatorio_pai_id) VALUES ( \n"
                    . "     '$nome', '$codigo_sql', '$descricao', \n"
                    . "     '$tipo', $datasource_id, $coluna_grupo, \n"
                    . "     $relatorio_pai_id)";
        }
        return $this->db->executa($sql);
    }

}
