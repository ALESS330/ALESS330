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
</style>

<div class="table-responsive">
    <table class="highlight" id="tabela-relatorios">
        <thead>
            <tr>
                <span id="totalizador" style="display: none" class="badge blue white-text">%d registros de %d</span>
            </tr>
            <tr>
                <th style="width: 5%"></th>
                <th style="width: 60%">Descrição</th>
                <th style="width: 15%">Nome</th>
                <th style="width: 10%">Datasource</th>
                <th style="width: 5%">Ativo</th>
                <th style="width: 5%"></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>
<script type="text/x-jsrender" id="tabela-relatorios-tmpl">
<tr>
 <td><i class="material-icons">{{:icone}}</i></td>
 <td class="descricao-relatorio">{{:descricao}}</td>
    <td title="{{:descricao}}">
        <a href="/relator/relatorio/{{:datasource}}/{{:nome}}">{{:nome}}</a>
    </td>    
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
#{scriptPagina}
<script src = "/base-z/assets/js/TabelaAjax.js" type = "text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        TabelaAjax.initIndex("/relator/relatorios/:pagina/:busca", "#tabela-relatorios", "#tabela-relatorios-tmpl", 1);
    });
</script>
#{/scriptPagina}