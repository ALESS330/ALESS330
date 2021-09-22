#{botoes}
<div class="fixed-action-btn">
    <a  href="@{Categorias->cadastro()}" class="btn-floating btn-large waves-effect waves-light red" title="Cadastrar nova Categoria">
        <i class="material-icons">add</i></a>
</div>
#{/botoes}

<div class="table-responsive">
    <table class="highlight" id="tabela-categorias">
        <thead>
            <tr>
                <th>Nome</th>
            </tr>
        </thead>
        <?php foreach ($categorias as $categoria) { ?>
            <tr>
                <td><?=$categoria->nome?> </td>
                <td>
                    <div class="acoes right">
                        <a href="/relator/categoria/<?=$categoria->id?>" id="<?=$categoria->id ?>"><i class="material-icons">edit</i></a>
                        <a class="bt-excluir" href="<?=$categoria->id; ?>" title="Excluir categoria"><i class="material-icons">delete</i></a>
                    </div>
                </td>
            </tr> 
        <?php } ?>
    </table>
</div>