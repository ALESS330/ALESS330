#{botoes}

  <div class="fixed-action-btn">
    <a class="btn-floating btn-large" href="@{Relatorios->index()}">
      <i class="large material-icons">arrow_back</i>
    </a>
</div>
#{/botoes}

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

<fieldset>
    <legend>Parâmetros</legend>
    <div>
        <p>Lista parâmetros do relatório: </p>
        <ul>
            <?php foreach ($parametros as $parametro) {  ?>
            <li><a href="@{Parametros->ver(<?=$parametro->id?>)}"><?= $parametro->nome ?></a></li>
            <?php } ?>
        </ul>
    </div>
</fieldset>