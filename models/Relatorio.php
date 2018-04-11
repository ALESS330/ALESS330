<?php

$_CONTROLE = 'Relatorio';
$_ROTULO = 'Relatório';

class Relatorio extends Model {

    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.relatorios";
    }

    public function getGrupos($relatorioId) {
        $rg = new RelatorioGrupo();
        $grupo = new Grupo();
        $listaRG = $rg->selectBy(array("relatorio_id" => $relatorioId));
        $grupos = array();
        if ($listaRG) {
            foreach ($listaRG as $relatorioGrupo) {
                $grupos[] = $grupo->get($relatorioGrupo->grupo_id);
            }//foreach
        }//if
        return $grupos;
    }
    
    public function listaTodos(){
        $sql = 
"
SELECT 
    d.nome nome_datasource
    ,r.*
FROM
    relatorios.relatorios r
    INNER JOIN relatorios.datasources d ON r.datasource_id = d.id
ORDER BY
    d.nome,
    r.nome    
";
        return $this->db->consulta($sql);
    }
    
    
    public function listaInicial($username){
        $sql = 
"
SELECT DISTINCT
    d.nome nome_datasource
    , g.nome grupo
    ,r.*
FROM
    relatorios.relatorios r
    INNER JOIN relatorios.datasources d ON r.datasource_id = d.id
    LEFT JOIN relatorios.relatorio_grupo rg ON rg.relatorio_id = r.id
    LEFT JOIN public.grupos g ON g.id = rg.grupo_id
    LEFT JOIN public.usuario_grupo ug ON ug.grupo_id = rg.grupo_id
    LEFT JOIN public.usuarios u ON u.id = ug.usuario_id
    -- Desenvolvedores
WHERE TRUE 
    AND (
	r.publico = TRUE 
	OR (u.username = '$username')
	OR (
		SELECT count(u.id) > 0
		FROM public.usuarios u 
		INNER JOIN public.usuario_grupo ug ON u.id = ug.usuario_id
		INNER JOIN public.grupos g ON g.id = ug.grupo_id
		WHERE g.nome = 'developer-relator' AND u.username = '$username'
		) -- ids devs
	) --devs
ORDER BY
    g.nome,
    r.nome    
";
        return $this->db->consulta($sql);
    }    
    
    public function getTelaParametros($relatorioId){
        $relatorioTela = new RelatorioTela();
        return  $relatorioTela->selectBy(array('relatorio_id'=> $relatorioId));
    }

    public function pagina($pagina, $busca) {
        $busca = str_replace(" ", "%", urldecode($busca));
        $start = ($pagina - 1) * $this->NUMERO_LINHAS;
        $sql = "
SELECT 
    r.id, 
    r.nome, 
    r.descricao, 
    r.icone,
    d.nome as datasource 
FROM 
    relatorios.relatorios r INNER JOIN 
    relatorios.datasources d ON r.datasource_id = d.id 
WHERE 
    r.nome ILIKE '%$busca%' OR 
    r.descricao ILIKE '%$busca%' OR 
    d.nome ILIKE '%$busca%' 
ORDER BY 
    r.descricao 
OFFSET $start 
LIMIT $this->NUMERO_LINHAS";
        $lista = $this->db->consulta($sql);
        $dados['linhas'] = $lista;
        $dados['totalTabela'] = $this->totalTabela();
        $dados['totalFiltro'] = $this->totalFiltro($busca);
        return $dados;
    }

    function totalFiltro($busca) {
        if (!$busca || $busca == "undefined") {
            $busca = "%";
        } else {
            $busca = "%" . str_replace(" ", "%", urldecode($busca)) . "%";
        }
        $busca = str_replace(" ", "%", urldecode($busca));
        $start = ($pagina - 1) * $this->NUMERO_LINHAS;
        $sql = " 
SELECT 
    count(r.id)
FROM 
    relatorios.relatorios r INNER JOIN 
    relatorios.datasources d ON r.datasource_id = d.id 
WHERE 
    r.nome ILIKE '%$busca%' OR 
    r.descricao ILIKE '%$busca%' OR 
    d.nome ILIKE '%$busca%'     
";
        $lista = $this->db->consulta($sql);
        return $lista[0]->count;
    }

    public function checarAcesso($relatorioId) {
        $rg = new RelatorioGrupo();
        $g = new Grupo();
        $u = new Usuario();
        $r = $this->get($relatorioId);
        $usuario = $u->buscaPorLogin($_SESSION['login']);
        $relatorioGrupo = $rg->selectByEquals("relatorio_id", $relatorioId);
        if ($r->publico || $g->isUserInGroup($_SESSION['login'], "developer-relator", 'relator')){
            return TRUE;
        }
        if($relatorioGrupo === NULL && $r->publico == FALSE){
            throw new Exception("Relatório restrito sem grupos definidos");
        }
        
        $listaGrupos = array();
        foreach ($relatorioGrupo as $i => $linhaRG) {
            $listaGrupos[] = $g->selectByEquals("id", $linhaRG->grupo_id)[0];
        }
        $isInGroup = FALSE;
        foreach ($listaGrupos as $grupo) {
            $thisGroup = $g->isUserInGroup($_SESSION['login'], $grupo->nome, 'relator');
            if ($thisGroup == TRUE) {
                $isInGroup = TRUE;
                break;
            }//if
        }//foreach 
        return $isInGroup;
    }// function checarAcesso
}// classe
