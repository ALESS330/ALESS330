#{botoes}
<div class="fixed-action-btn">
    <a  href="@{Relatorios->cadastro()}" class="btn-floating btn-large waves-effect waves-light red" id="btn-novo" title="Cadastrar novo Relatório">
        <i class="material-icons">add</i></a>
</div>
#{/botoes}

<div class="table-responsive">
    <table class="bordered highlight hoverable responsive-table"   id="tabela-relatorios">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Datasource</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    #{modal}
    Deseja realmente excluir esse registro?
    #{/modal}
</div>

#{scriptPagina}
<script src = "/relator/assets/js/Relatorios.js" type = "text/javascript">
</script>
<script type="text/javascript">

    $(document).ready(function () {
        Relatorios.initIndex();
    });


</script>
#{/scriptPagina}