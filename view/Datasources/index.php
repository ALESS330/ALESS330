#{botoes}
<div class="fixed-action-btn">
    <a  href="@{Datasources->cadastro()}" 
        class="btn-floating btn-large waves-effect waves-light red" 
        title="Cadastrar novo Datasource">
        <i class="material-icons">add</i></a>
</div>
#{/botoes}

<div class="table-responsive">
    <table class="highlight" id="tabela-datasources">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Conexão</th>
                <th>Descrição</th>                
                <th>Ativo</th>
                <th>Ação</th>
            </tr>
        </thead>
        <?php foreach ($datasources as $datasource) { ?>
            <tr>
                <td><?=$datasource->nome?> </td>
                <td><?=$datasource->conexao?> </td>
                <td><?=$datasource->descricao?> </td>
                <td><?=$datasource->ativo ? "Sim" : "Não" ?></td>
                <td>
                    <div class="acoes right">
                        <a href="/relator/datasource/<?= $datasource->id?>" id="<?= $datasource->id ?>"><i class="material-icons">edit</i></a>
                        <a class="bt-excluir" href="<?= $datasource->id; ?>" title="Excluir datasource"><i class="material-icons">delete</i></a>
                    </div>
                </td>
            </tr> 
        <?php } ?>
    </table>
</div>