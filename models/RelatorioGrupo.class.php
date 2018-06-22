<?php

class RelatorioGrupo extends Model {

    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.relatorio_grupo";
    }

    function busca($relatorioId, $grupoId){
        $sql = "SELECT * FROM relatorios.relatorio_grupo WHERE relatorio_id = $relatorioId AND grupo_id = $grupoId";
        return $this->db->consulta($sql)[0];
    }
}
