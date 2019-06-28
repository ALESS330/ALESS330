<?php

class Datasource extends Model {

    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.datasources";
    }

    public function lista() {
        $sql = 
"SELECT 
    *
FROM 
    relatorios.datasources
ORDER BY
    nome";
        $lista = $this->db->consulta($sql);
        return $lista;
    }

}
