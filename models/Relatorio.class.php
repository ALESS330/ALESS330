<?php

$_CONTROLE = 'Relatorio';
$_ROTULO = 'Relatório';

class Relatorio extends Model {
    
    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.relatorios";
    }

    function get($relatorioId) {
        $sql = "
SELECT 
    r.*
    , d.nome datasource
FROM 
    relatorios.relatorios r 
    JOIN relatorios.datasources d on r.datasource_id = d.id
WHERE 
    r.id = $relatorioId
";
        $l = $this->db->consulta($sql);
        if (count($l) != 1) {
            return false;
        }
        return $l[0];
    }

    public function getGrupos($relatorioId) {
        $rg = new RelatorioGrupo();
        $grupo = new Grupo();
        $listaRG = $rg->selectBy(array("relatorio_id" => $relatorioId));
        $grupos = array();
        if ($listaRG) {
            foreach ($listaRG as $relatorioGrupo) {
                $oGrupo = new Grupo;
                $g = $oGrupo->get($relatorioGrupo->grupo_id);
                $grupos[] = $grupo->get($relatorioGrupo->grupo_id);
            }//foreach
        }//if
        return $grupos;
    }

    public function getFormatos($relatorioId) {
        $rf = new RelatorioFormato();
        return $rf->selectBy(array("relatorio_id" => $relatorioId));
    }

    public function getDecoradores($relatorioId) {
        $d = new Decorador();
        return $d->decoradores($relatorioId);
    }

    public function listaGruposPossiveis($relatorioId) {
        $sql = "
select distinct
    g.*
from
    public.grupos g
    left join public.sistemas s ON g.sistema_id = s.id
    left join relatorios.relatorio_grupo rg ON g.id = rg.grupo_id
where true
    and (s.nome_unico = 'relator' OR s.id is null)
    and g.id not in (select grupo_administrador_id from public.grupos_admins)
    and g.id not in (select grupo_id from relatorios.relatorio_grupo where relatorio_id = $relatorioId)
";
        return $this->db->consulta($sql);
    }

    public function listaTodos() {
        $sql = "
select 
    d.nome nome_datasource
    ,r.*
from
    relatorios.relatorios r
    inner join relatorios.datasources d on r.datasource_id = d.id
    left join relatorios.categorias_relatorios cr on r.id = cr.relatorio_id
    left join relatorios.categorias c on c.id = cr.categoria_id
order by
    d.nome,
    r.nome    
";
        return $this->db->consulta($sql);
    }

    public function listaInicial($usuario) {
        $u = $usuario->getUsuario();
        $username = false;
        if ($u) {
            $username = $u->username;
        }
        if (!$username) {
            $sql = "
SELECT 
    d.nome nome_datasource
    , 'publico' grupo
    , r.* 
FROM
    relatorios.relatorios r
    INNER JOIN relatorios.datasources d ON r.datasource_id = d.id
WHERE
    r.publico = TRUE
";
        } else {
            $sql = "
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
    AND r.ativo = TRUE
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
        }
        return $this->db->consulta($sql);
    }

    public function getTelaParametros($relatorioId) {
        $relatorioTela = new RelatorioTela();
        $rt = $relatorioTela->selectBy(array('relatorio_id' => $relatorioId));
        if (count($rt) === 1) {
            return $rt[0];
        }
        return NULL;
    }

    public function salvarTelaParametros($tela) {
        $objTP = new RelatorioTela();
        if (isset($tela['id'])) {
            $objTP->deleta($tela['id']);
            unset($tela['id']);            
        }
        if(isset($tela['formulario_id']) && $tela['formulario_id']){
            $objTP->salvar($tela);
        }
        
    }

    public function pagina($pagina, $busca) {
        $busca = str_replace(" ", "%", urldecode($busca));
        $start = ($pagina - 1) * $this->NUMERO_LINHAS;
        $mostrarInativos = "";
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
    (r.nome ILIKE '%$busca%' OR 
    r.descricao ILIKE '%$busca%' OR 
    d.nome ILIKE '%$busca%')
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

    public function checarAcesso($relatorioId, $login) {
        $rg = new RelatorioGrupo();
        $g = new Grupo();
        $u = new Usuario();
        $r = $this->get($relatorioId);
        if (isset($_SESSION['login'])) {
            $usuario = $u->buscaPorLogin($login);
            if ($g->isUserInGroup($login, "developer-relator", 'relator')) {
                return true;
            }
        }

        $relatorioGrupo = $rg->selectByEquals("relatorio_id", $relatorioId);
        if ($r->publico) {
            return TRUE;
        }

        if ($relatorioGrupo === NULL && $r->publico == FALSE) {
            throw new Exception("Relatório restrito sem grupos definidos");
        }

        $listaGrupos = array();
        foreach ($relatorioGrupo as $i => $linhaRG) {
            $listaGrupos[] = $g->selectByEquals("id", $linhaRG->grupo_id)[0];
        }

        if (!isset($login) || $login === FALSE || $login == NULL) {
            return FALSE;
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
    }

// function checarAcesso

    public function salvarFormatos($relatorioId, $formatos) {
        $rf = new RelatorioFormato();
        $sql = "DELETE FROM relatorios.relatorio_formato WHERE relatorio_id = $relatorioId";
        $r = $this->db->executa($sql);
        if (!$formatos) {
            return TRUE;
        }
        foreach ($formatos as $value) {
            $novoRF['relatorio_id'] = $relatorioId;
            $novoRF['formato'] = $value;
            $r = $rf->salvar($novoRF);
        }
        return TRUE;
    }

    public function checaFormato($relatorioId, $formato) {
        $sql = "SELECT count(id)::integer = 1 as suporta FROM relatorios.relatorio_formato WHERE relatorio_id = $relatorioId and formato ='$formato'";
        return $this->db->consulta($sql)[0];
    }

    public function getDatasource($idRelatorio) {
        $oDatasource = new Datasource();
        $oRelatorio = new Relatorio();
        return $oDatasource->get($oRelatorio->get($idRelatorio)->datasource_id);
    }

    function listaAtivos() {
        $sql = 
"
select 
    r.id 
    , r.nome
    , r.descricao
from 
    relatorios.relatorios r 
    join relatorios.datasources d on r.datasource_id = d.id
where true 
    and r.ativo = true 
    and d.ativo = true 
order by 
    r.nome
";
        return $this->db->consulta($sql);
    }

    function getComposicao($relatorioId) {
        $oCamposicao = new Composicao();
        return $oCamposicao->getByRelatorioPrincipalId($relatorioId);
    }

}

// classe
