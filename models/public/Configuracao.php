<?php
global $dbconf;

class Configuracao{
    
    private $model;

    public function __construct() {
        $this->db = new DB();
    }
    public function getConfiguracao($nome){
        $sql = "SELECT c.valor FROM\n"
             .  "     public.configuracoes c INNER JOIN \n"
             .  "     public.sistemas s ON s.id = c.sistema_id \n"
             .  "WHERE \n"
             .  "     s.nome_unico = 'ensino'\n"
             .  "     AND c.nome = '$nome'";
        $result = $this->db->consulta($sql);
        if($result){
            $config = $result[0]->valor;
            return $config;
        }else{
            throw new Exception("Configuração não encontrada: $nome");
        }
        
    }
    
}
