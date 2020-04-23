<?php

class Rotulo extends Model {

    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.rotulos";
    }
}
