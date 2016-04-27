<?php

require_once dirname(dirname(dirname(__FILE__))) . '/classes/Model.php';

class Sistemas extends Model {
    
    public function listar(){
        
        $sql = "select * From public.sistemas order by nome";
        $lista = $this->db->consulta($sql);
        return $lista;
        
    }
    

    
}
