<?php global $corBasicaSistema;?>
#{botoes}
<div class="fixed-action-btn">
    <a  href="@{Relatorios->novo()}" class="btn-floating btn-large waves-effect waves-light red" id="btn-novo" title="Criar novo relatório">
        <i class="material-icons">add</i></a>
</div>
#{/botoes}

<style type="text/css">
    table tbody tr td div .btn{
        padding: 0 10px !important;
    }
    
    td.descricao-relatorio{
        overflow: hidden;
        text-overflow: ellipsis;
    }

    tr.linha-vazia{
        border: none;
    }
</style>

<div class="table-responsive">
    <table class="highlight" id="tabela-relatorios">
        <thead>
            <tr>
                <span id="totalizador" style="display: none" class="badge blue white-text">%d registros de %d</span>
            </tr>
            <tr>
                <th style="width: 5%"></th>
                <th style="width: 5%"></th>
                <th style="width: 40%">Descrição</th>
                <th style="width: 15%">Nome</th>
                <th style="width: 15%">Categoria</th>
                <th style="width: 10%">Datasource</th>
                <th style="width: 5%">Ativo</th>
                <th style="width: 5%"></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" style="text-align: right;">
                    <ul class="pagination" id="paginador"></ul>
                </td>
            </tr>
        </tfoot>        
    </table>

</div>

<script type="text/x-jsrender" id="linhas-vazias-tmpl">
<tr class="linha-vazia">
  <td colspan="8"></td>
</tr>
</script>

<script type="text/x-jsrender" id="tabela-relatorios-tmpl">
<tr>
 <td>{{:numeroLinha}}</td>
 <td><i class="material-icons">{{:icone}}</i></td>
 <td class="descricao-relatorio">{{:descricao}}</td>
 <td title="{{:descricao}}">
        <a href="/relator/relatorio/{{:datasource}}/{{:nome}}">{{:nome}}</a>
 </td>
 <td>{{:categorias}}</td>
 <td>{{:datasource}}</td>
 <td>{{if ativo}}Sim{{else}}Não{{/if}}</td>
  <td style="width: 100px">
        <div class="acoes right">        
            <a href="/relator/relatorio/{{:id}}/propriedades" title="Propriedades"><i class="material-icons">settings</i></a>
            <a href="/relator/relatorio/{{:id}}" title="Editar"><i class="material-icons">edit</i></a>
            <a href="/relator/relatorio/{{:id}}/excluir" class="bt-excluir" title="Excluir"><i class="material-icons">delete</i></a>
        </div>
  </td>
</tr>
</script>

<script type="text/x-jsrender" id="paginador-relatorios-tmpl">
    <li class="waves-effect pagina" ><a href="#">{{:numeroPagina}}</a></li>
</script>

#{scriptPagina}
<!-- script src = "/base-z/assets/js/TabelaAjax.js" type = "text/javascript"></script -->
<script type="text/javascript">
    $(document).ready(function () {
        const listaRelatorios = <?= json_encode($relatorios)?>;
        console.log(listaRelatorios);
        const tabela = $("#tabela-relatorios");
        const numeroLinhas = 10;
        const totalPaginas = Math.ceil(listaRelatorios.length / numeroLinhas);
        const paginas = new Array();

        for(i=0; i< totalPaginas; i++){
            paginas.push({numeroPagina: i+1});
        }
        const links = $("#paginador-relatorios-tmpl").render(paginas);
        $("#paginador").append(links);

        $("#paginador").on('click', 'li', function(e){
            const numeroPagina = $(this).text();
            $(this).closest("ul").find("li").removeClass("active <?= $corBasicaSistema ?>");
            $(this).addClass("active <?= $corBasicaSistema?>");
            const inicio = (numeroPagina - 1) * numeroLinhas;
            const fim = numeroPagina*numeroLinhas;
            pagina = listaRelatorios.slice(inicio, fim)
                .map((linha, i) =>{
                    numero = inicio + i + 1;
                    return Object.assign({numeroLinha: numero}, linha);
                })
            
            linhas = $("#tabela-relatorios-tmpl").render(pagina);
            tabela.find("tbody").empty().append(linhas);
            if(pagina.length < numeroLinhas){
                const vazias = new Array((numeroLinhas-pagina.length)).fill({}, pagina.length)
                $linhasVazias = $("#linhas-vazias-tmpl").render(vazias);
                tabela.find("tbody").append($linhasVazias);
            }
        });

        $(".pagina").eq(0).click();
    });
</script>
#{/scriptPagina}