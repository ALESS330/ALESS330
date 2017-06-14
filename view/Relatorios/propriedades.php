<fieldset>
    <legend>Propriedades do Relatório</legend>
    <blockquote>
        <ul>
            <li>Nome: <strong><?= $relatorio->nome ?></strong></li>
            <li>Descrição: <strong><?= $relatorio->descricao ?></strong></li>
            <li></li>
        </ul>
    </blockquote>
</fieldset>

<fieldset>
    <legend>Grupos de Aceso</legend>
    <div>
        <p>Lista de grupos associados a este relatório: </p>
        <ul>
            <?php foreach ($gruposRelatorio as $grupo) {  ?>
            <li><a href="@{Grupos->ver(<?=$grupo->id?>)}"><?= $grupo->nome ?></a></li>
            <?php } ?>
        </ul>
    </div>
</fieldset>