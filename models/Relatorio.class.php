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
        with categorias as (
            select
                r.id id_relatorio
                , array_remove(array_agg(c.nome),null) categorias_json 
            from 
                relatorios.relatorios r 
                left join relatorios.relatorio_categoria rc on rc.relatorio_id = r.id
                left join relatorios.categorias c on c.id = rc.categoria_id 
            group by r.id 
            )
            select 
                d.nome nome_datasource
                , array_to_json(c.categorias_json) categorias
                , r.*
            from
                relatorios.relatorios r
                inner join relatorios.datasources d on r.datasource_id = d.id
                left join categorias c on r.id = c.id_relatorio
            where r.id = $relatorioId                
            order by
                d.nome,
                r.nome
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
with categorias as (
    select
        r.id id_relatorio
        , array_remove(array_agg(c.nome),null) categorias_json 
    from 
        relatorios.relatorios r 
        left join relatorios.relatorio_categoria rc on rc.relatorio_id = r.id
        left join relatorios.categorias c on c.id = rc.categoria_id 
    group by r.id 
    )
    select 
        d.nome nome_datasource
        , array_to_json(c.categorias_json) categorias
        , r.*
    from
        relatorios.relatorios r
        inner join relatorios.datasources d on r.datasource_id = d.id
        left join categorias c on r.id = c.id_relatorio
    order by
        d.nome,
        r.nome
";
        return $this->db->consulta($sql);
    }

    public function listaInicial($usuario) {
        $criterioIntersection = "";
        $criterioUser = "";
        $fromUsuarios ="";
        $criterioPublico = "";
        $u = $usuario->getUsuario();
        if($u->username ?? false){
            if(!$usuario->isDeveloper()){
                $criterioUser = "and u.username = 'cleber.toda@ebserh.gov.br'";
                $criterioIntersection ="and (
                    gr.grupos_relatorio_array && gu.grupos_usuario_array or (r.publico)
                )";
                $fromUsuarios = ", grupos_usuario gu ";
            }
        }else {
            //sem usuários logados, aparecem relatórios públicos que estejam ativos
            $criterioUser = "";
            $criterioPublico = " and r.publico = true";
        }
        
$sql = "
with 
  categorias as (
	select distinct 
	  r.id id_relatorio
	  , array_remove(array_agg(c.nome),null) categorias_json 
	from 
	  relatorios.relatorios r 
	  left join relatorios.relatorio_categoria rc on rc.relatorio_id = r.id
	  left join relatorios.categorias c on c.id = rc.categoria_id 
	group by r.id 
  )
  , grupos_relatorio as (
    select distinct 
      r.id id_relatorio
      , array_remove(array_agg(g.nome),null) grupos_relatorio_array 
    from 
      relatorios.relatorios r 
      left join relatorios.relatorio_grupo rg on rg.relatorio_id = r.id
      left join public.grupos g on g.id = rg.grupo_id
    where true
    group by r.id
  )
  , grupos_usuario as (
    select 
      array_remove(array_agg(g.nome),null) grupos_usuario_array 
      , u.username 
    from 
      public.grupos g 
      join public.usuario_grupo ug on ug.grupo_id = g.id 
      join public.usuarios u on u.id = ug.usuario_id 
      left join public.sistemas s on s.id = g.sistema_id 
    where true 
      and (s.nome_unico = 'relator' or s.id is null)
      $criterioUser -- aqui vão os critérios de usuário
    group by u.username 
  )
  select
    d.nome nome_datasource
    , array_to_json(c.categorias_json) categorias
    , r.id
    , r.nome
    , r.icone
    , r.descricao
    , array_to_json(gr.grupos_relatorio_array) grupos_relatorio
from
    relatorios.relatorios r
    inner join relatorios.datasources d on r.datasource_id = d.id
    left join categorias c on c.id_relatorio = r.id 
    left join grupos_relatorio gr on gr.id_relatorio = r.id
    $fromUsuarios -- aqui vai o 'from' usuarios
where true 
    and r.ativo = true
    $criterioPublico --aqui filtra os públicos
    $criterioIntersection -- aqui vai a intersection
order by
    r.nome
";
        $lista = $this->db->consulta($sql);
        return $lista;
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
