<?php

class RelatorioFormato extends Model {

    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.relatorio_formato";
    }
}
