<?php

class Categoria extends Model { 

    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.categorias";
    }

    public function listaTodas() {
        return $this->db->consulta(
"
select 
  *
from 
  relatorios.categorias
order by 
  nome
"

        );
    }

}
