<?php

class Datasource extends Model {

    public function lista() {
        $sql = "SELECT \n"
            . "    id, \n"
            . "    conexao, \n"
            . "    nome\n"
            . "FROM \n"
            . "    relatorios.datasources\n"
            . "ORDER BY \n"
            . "    nome";
        $lista = $this->db->consulta($sql);
        return $lista;
    }

}
