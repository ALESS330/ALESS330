<?php

class TipoDecorador extends Model {

    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.tipos_decoradores";
    }

    public function lista() {
        $sql = "
    select 
        *
    from 
        relatorios.tipos_decoradores
    order by 
        nome;
";
        $lista = $this->db->consulta($sql);
        return $lista;
    }

}
