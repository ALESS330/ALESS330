<?php

class RelatorioGrupo extends Model {

    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.relatorio_grupo";
    }

}
