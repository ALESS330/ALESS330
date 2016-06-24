#{scriptPagina}
<script type="text/javascript">
    $(document).ready(function () {
        $('select').material_select();
        //$("#data-relatorio").mask("99/99/9999");
    });

</script>
#{/scriptPagina}

<form class="form-horizontal" rol="form" id="form-cadastro-relatorio" action="@{Relatorios->salvar()}" method="POST" >

    <?php
    $datasourceAtual = $sql = $relatorio_pai = $coluna_grupo = $tipo = $nome = $descricao = "";
    if (isset($relatorioAtual) && $relatorioAtual) {
        $tipo = $relatorioAtual->tipo;
        $nome = $relatorioAtual->nome;
        $descricao = $relatorioAtual->descricao;
        $coluna_grupo = $relatorioAtual->coluna_grupo;
        $relatorio_pai = $relatorioAtual->relatorio_pai_id;
        $sql = $relatorioAtual->codigo_sql;
        $datasourceAtual = $relatorioAtual->datasource_id;
        ?>
        <input type="hidden" name="relatorio[id]" value="<?php echo $relatorioAtual->id; ?>"/>
    <?php } ?>
    <div class="row">
        <div class="input-field col s12">
            <select name="relatorio[datasource]" id="datasource-relatorio" required>
                <option value="" >Selecione o Datasource</option>
                <?php
                foreach ($datasources as $datasource) {
                    $selected = "";
                    if ($datasourceAtual == $datasource->id) {
                        $selected = "selected";
                    }
                    ?>
                    <option value="<?php echo $datasource->id; ?>" <?php echo $selected ?>><?php echo $datasource->nome; ?> </option>
                <?php } ?>
            </select>
            <label>Datasource</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input type="text" required class="form-control data" id="data-relatorio" name="relatorio[nome]" value="<?php echo $nome; ?>">
            <label for="nome-relatorio">Nome</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input type="text" required class="form-control data" id="descricao-relatorio" name="relatorio[descricao]" value="<?php echo $descricao; ?>">
            <label for="nome-relatorio">Descrição</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <select name="relatorio[tipo]">
                <option>Selecione o tipo do relatório</option>
                <option value="simples" <?php echo $tipo == 'simples' ? "selected" : ""; ?>>Simples</option>
                <option value="agrupado" <?php echo $tipo == 'agrupado' ? "selected" : ""; ?>>Agrupado</option>
                <option value="titulo-relatorio" <?php echo $tipo == 'titulo-relatorio' ? "selected" : ""; ?>>Título de outro relatório</option>
            </select>
            <label>Tipo do relatorio</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input type="text" class="form-control" id="coluna-grupo-relatorio" name="relatorio[coluna_grupo]" value="<?php echo $coluna_grupo; ?>">
            <label for="coluna-grupo-relatorio">Coluna grupo</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input type="text" class="form-control" id="coluna-grupo-relatorio" name="relatorio[pai]" value="<?php echo $relatorio_pai; ?>">
            <label for="coluna-grupo-relatorio">Relatório Pai</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <textarea required class="materialize-textarea" id="codigo-sql-relatorio" name="relatorio[sql]"><?php echo $sql; ?></textarea>
            <label for="codigo-sql-relatorio">Código SQL</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <!--problemas com waves-effect-->
            <button class="btn btn-primary" type="submit" value="Cadastrar">Salvar</button>
            <a href="@{Relatorios->index()}" class="btn btn-danger">Cancelar</a>
        </div>
    </div>

</form>