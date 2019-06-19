<?php

class RelatorioTela extends Model {

    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.relatorio_tela";
    }
    
    public function deleta($tela){
        if(isset($tela['formulario_id']) && $tela['formulario_id']){
            $sql = "DELETE FROM relatorios.relatorio_tela WHERE relatorio_id = " . $tela['relatorio_id'];
            $this->db->executa($sql);
        }
        return true;
    }
}
