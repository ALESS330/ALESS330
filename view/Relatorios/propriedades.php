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
    <legend>Grupos de Acesso</legend>
    <div>
        <?php if (count($gruposRelatorio) > 0){ ?>
        <p>Lista de grupos associados a este relatório: </p>
        <ul>
            <?php foreach ($gruposRelatorio as $grupo) {  ?>
            <li><a href="@{Grupos->ver(<?=$grupo->id?>)}"><?= $grupo->nome ?></a></li>
            <?php } ?>
        </ul>
        <?php } //if
        else{
            echo "<p>Nenhum grupo associado ao relatório</p>";
        }?>
    </div>
</fieldset>

<?php if ($relatorio->parametrizado) {?>
<fieldset>
    <legend>Parâmetros</legend>
    <div>
        <?php if (count($parametros) > 0) { ?>
        <p>Lista de parâmetros do relatório: </p>
        <ul>
            <?php foreach ($parametros as $parametro) {  ?>
            <li><a href="@{Parametros->ver(<?=$parametro->id?>)}"><?= $parametro->nome ?></a> - <?= $parametro->descricao ?></li>
            <?php } ?>
        </ul>
        <?php }//if count($parametros) ?>
        
    </div>
</fieldset>
<?php } //if (parametrizado) ?>