<?php

class TipoComposicao extends Model {

    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.tipos_composicoes";
    }

    public function lista() {
        $sql = "
    select 
        *
    from 
        relatorios.tipos_composicoes
    order by 
        nome;
";
        $lista = $this->db->consulta($sql);
        return $lista;
    }

}
