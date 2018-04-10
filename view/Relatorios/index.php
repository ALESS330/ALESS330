#{botoes}
<div class="fixed-action-btn">
    <a  href="@{Relatorios->cadastro()}" class="btn-floating btn-large waves-effect waves-light red" id="btn-novo" title="Cadastrar novo Relatório">
        <i class="material-icons">add</i></a>
</div>
#{/botoes}

#{/scriptPagina}
<style type="text/css">
    table tbody tr td div .btn{
        padding: 0 10px !important;
    }
</style>

<div class="table-responsive">
    <table class="bordered highlight hoverable responsive-table"   id="tabela-relatorios">
        <thead>
            <tr>
                <span  id="totalizador" style="display: none" class="badge blue white-text">%d registros de %d</span>
            </tr>
            <tr>
                <th></th>
                <th>Descrição</th>
                <th>Nome</th>
                <th>Datasource</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    #{modal}
    Deseja realmente excluir esse registro?
    #{/modal}
</div>
<script type="text/x-jsrender" id="tabela-relatorios-tmpl">
<tr>
 <td><i class="material-icons">{{:icone}}</i></td>
    <td>{{:descricao}}</td>
    <td title="{{:descricao}}">
        <a href="/relator/relatorio/{{:datasource}}/{{:nome}}">{{:nome}}</a>
    </td>    
    <td>{{:datasource}}</td>
    <td>
        <div class="acoes right">        
            <a href="/relator/relatorio/{{:id}}/propriedades" title="Propriedades"><i class="material-icons">settings</i></a>
            <a href="/relator/relatorio/{{:id}}" title="Editar"><i class="material-icons">edit</i></a>
            <a href="/relator/relatorio/{{:id}}/excluir" class="bt-excluir" title="Excluir"><i class="material-icons">delete</i></a>
        </div>
    </td>
</tr>
</script>
#{scriptPagina}
<script src = "/base/assets/js/TabelaAjax.js" type = "text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        TabelaAjax.initIndex("/relator/relatorios/:pagina/:busca", "#tabela-relatorios", "#tabela-relatorios-tmpl", 1);
    });
</script>
#{/scriptPagina}