<?php

class Parametro extends Model {

    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.parametros";
    }

}
