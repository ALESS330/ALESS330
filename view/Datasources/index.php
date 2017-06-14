#{botoes}
<div class="fixed-action-btn">
    <a  href="@{Datasources->cadastro()}" class="btn-floating btn-large waves-effect waves-light red" title="Cadastrar novo Datasource">
        <i class="material-icons">add</i></a>
</div>
#{/botoes}

<div class="table-responsive">
    <table class="bordered highlight hoverable responsive-table" id="tabela-datasources">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Coneo</th>
                <th>Ação</th>
            </tr>
        </thead>
        <?php foreach ($datasources as $datasource) { ?>
            <tr>
                <td> <?php echo $datasource->nome; ?> </td>
                <td> <?php echo $datasource->conexao; ?> </td>
                <td>
                    <div class="acoes">
                        <a href="/relator/datasource/<?= $datasource->id?>" id="<?= $datasource->id ?>" class="btn indigo darken-3 waves-effect waves-light glyphicon glyphicon-edit" aria-hidden="true" >
                           <i class="material-icons">edit</i>
                        </a>
                        <a class="btn btn-excluir red darken-3 waves-effect waves-light glyphicon glyphicon-edit" alt="Excluir" href="<?= $datasource->id; ?>"> 
                            <i class="material-icons">delete</i></a>
                    </div>
                </td>
            </tr> 
        <?php } ?>
    </table>

    #{modal}
    Deseja realmente excluir esse registro?
    #{/modal}
</div>

#{scriptPagina}



<script type="text/javascript">
    $(document).ready(function () {
        var id = null;
        $("td").on('click', '.btn-excluir', function (e) {
            e.preventDefault();
            id = $(this).attr("href");
            $('#modal').openModal();
        });
    });
</script>
#{/scriptPagina}