<?php

class Composicao extends Model {

    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.composicoes";
    }

    public function listaTipoComposicao() {
        $sql = 
"SELECT 
    *
FROM 
    relatorios.datasources
ORDER BY
    nome";
        $lista = $this->db->consulta($sql);
        return $lista;
    }

    function getByRelatorioPrincipalId($relatorioId) {
$sql =
"
select 
	c.*
	, comp.nome 
	, d.nome datasource
from 
	relatorios.composicoes c
	join relatorios.relatorios comp on comp.id  = c.relatorio_componente_id 
	join relatorios.tipos_composicoes tc on tc.id = c.tipo_composicao_id 
	join relatorios.datasources d on d.id = comp.datasource_id 
where true 
	and c.relatorio_principal_id = $relatorioId
";
        $r = $this->db->consulta($sql);
        if(count($r) !== 1){
            return false;
        }
        return $r[0];  
    }

}
