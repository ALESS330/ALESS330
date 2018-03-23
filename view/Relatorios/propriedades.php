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
    <legend>Tela de parâmetros</legend>
    <a href="#" class="right btn" title="Alterar"><i class="material-icons">edit</i></a>
    <div>
        <ul>
            <li><strong>Id: </strong><?= $telaParametros->id ?></li>
            <li><strong>Nome: </strong><?= $telaParametros->nome_formulario ?></li>
        </ul>
    </div>
</fieldset>
<?php } //if (parametrizado) ?>