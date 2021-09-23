<?php
global $corSistemaRGB, $escondeBusca;
$grupoAtual = "";
$coresIcones = array();
$escondeBusca = true;
?>
<style>
    .lista-relatorios{   
        display: flex;  
        flex-wrap: wrap;
        justify-content: space-around;
        margin-top: 18px;
        /*        margin: 18px 25px 18px 43px !important;*/
    }
 
    .lista-relatorios .relatorio{
        display: inline-block;
        width: 300px;
        height: 80px;
        margin: 5px;
        border-radius: 5px;
        text-align: center;
        vertical-align: middle;
    }
    .lista-relatorios .relatorio .icone{
        width: 80px;
        height: 80px;
        background-color:  <?= $corSistemaRGB ?>;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        float: left;
        padding-top: 16px;
    }
    .lista-relatorios .relatorio .icone i{
        font-size: 48px;
    }

    .lista-relatorios .relatorio .descricao{
        width: 220px;
        height: 59px;
        border-bottom-right-radius: 5px;
        /*        float: left;*/
        padding: 2px;
        font-size: 12px;
        line-height: 30px;
        white-space: nowrap; 
        display: inline-block;
        overflow: hidden;
        text-overflow: ellipsis
    }
    .lista-relatorios .relatorio strong{
        height: 20px;
        width: 220px;
        display: inline-block;
        border-top-right-radius: 5px;
    }

    a .relatorio .icone i{
        color: white !important;
    }

    .titulo-relatorio {
        font-weight: bold;
    }
    .tabs .tab a{
        color: <?=$corSistemaRGB?> !important;
    }

    .tabs .tab a:hover {
        background-color:#eee;
        color:#000;
    } /*Text color on hover*/

    .tabs .tab a.active {
        background-color: white !important;
        color: <?=$corSistemaRGB?> !important;
    } /*Background and text color when a tab is active*/

    .tabs .indicator {
        background-color:#000;
    } /*Color of underline*/
</style>

<h5 class="titulo-relatorio">Lista de Relatórios</h5>
<div class="divider"></div>

<div class="row" id="abas">
    <div class="col s12">
        <ul class="tabs no-autoinit" id="titulos-abas"></ul>
    </div>
</div>

<script type="text/x-jsrender" id="titulo-aba-tmpl">
  <li class="tab col"><a class="{{:active}}" href="#{{:id}}">{{:categoria}}</a></li>
</script>

<script type="text/x-jsrender" id="conteudo-aba-tmpl">
    <div id="{{:id}}" class="s12 col lista-relatorios">
        {{:conteudo}}
    </div>
</script>

<script type="text/x-jsrender" id="link-relatorio-tmpl">
<a href="{{:link}}">
    <div class="relatorio card">
    <strong>{{:nome}}</strong>
    <div class="icone">
        <i class="material-icons">{{:icone}}</i>
    </div>
    <div class="descricao">
        <span title="{{:descricao}}">{{:descricao}}</span>
    </div>
    </div>
</a>
</script>

#{scriptPagina}
<script>
    $(document).ready(function(){
        const relatorios = <?= json_encode($listaRelatorios)?>;
        const titulosCategorias = new Array();
        const conteudosCategorias = new Array();
        let indice = 0;
        active = 'active'
        for(categoria of relatorios){
            indice++;
            nome = categoria.nome;
            if(nome == 'NAO_CATEGORIZADO'){
                nome = 'Não categorizado';
            }
            titulosCategorias.push({
                active : active
                , categoria: nome 
                , id : `categoria-${indice}` 
            });
            conteudosCategorias.push({
                conteudo: categoria.relatorios
                , id : `categoria-${indice}` 
            });
            active = '';
        }//for
        const titulos = $("#titulo-aba-tmpl").render(titulosCategorias);
        $("#titulos-abas").empty().append(titulos);
        const conteudosAbas = new Array();
        for(listaRelatorios of conteudosCategorias){
            const conteudoAbaAtual = $("#link-relatorio-tmpl").render(listaRelatorios.conteudo);
            conteudosAbas.push({
                conteudo: conteudoAbaAtual
                , id : listaRelatorios.id
            })
        }
        abas = $("#conteudo-aba-tmpl").render(conteudosAbas);
        $("#abas").append(abas)
        $("#abas ul li:first").addClass("active");
        $(".tabs").tabs();
    });
</script>
#{/scriptPagina}