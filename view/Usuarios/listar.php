#{botoes}
<div class="fixed-action-btn">
    <a href="@{Usuarios->cadastro()}" class="btn-floating btn-large waves-effect waves-light red" title="Cadastrar novo Usuário">
        <i class="mdi-content-add"></i></a>
</div>
#{/botoes}

<div class="table-responsive">
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pessoa</th>
                <th>Username</th>
                <th>Ação</th>
            </tr>
        </thead>
        <?php foreach ($usuarios as $usuario) { ?>
            <tr>
                <td> <?php echo $usuario->id; ?> </td>
                <td> <?php echo $usuario->pessoa_nome; ?> </td>
                <td> <?php echo $usuario->username; ?> </td>
                <td><a class="btn btn-default indigo" href="@{Usuarios->cadastro()}" id="<?= $usuario->id ?>"aria-hidden="true" >
                       <i class="mdi-editor-mode-edit glyphicon glyphicon-edit"></i></a>
                    <a class="btn btn-default btn-excluir red glyphicon glyphicon-remove btn-excluir" alt="excluir" href="<?= $usuario->id; ?>">
                        <i class="mdi-action-delete"></i></a></td>
            </tr> 
        <?php } ?>
    </table>

<!--    <div>
        <a href= '@{usuarios->cadastro")?>' class='btn btn-primary'>Cadastrar</a>
    </div>-->

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
            console.log(this);
            id = $(this).attr("href");
            console.log(id);
            $('#myModal').modal({
            });
        });
    });
</script>
#{/scriptPagina}