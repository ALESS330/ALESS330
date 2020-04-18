#{stylesPagina}
<link rel="stylesheet" href="/static/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="/static/codemirror/addon/hint/show-hint.css" />
<link rel="stylesheet" href="/static/codemirror/theme/monokai.css">

<style type="text/css">
    div.CodeMirror{
        height: auto !important;
        z-index: 2;
    }
    nav{
        z-index: 3;
    }
</style>
#{/stylesPagina}

<form class="form-horizontal" id="form-cadastro-relatorio" action="@{Relatorios->salvar()}" method="POST">

    <?php
    $checkedPublico = $checkedParametrizado = $datasourceAtual = $sql = $relatorio_pai = $coluna_grupo = $tipo = $nome = $descricao = "";

    if (isset($relatorioAtual) && $relatorioAtual) {
        $tipo = $relatorioAtual->tipo;
        $icone = $relatorioAtual->icone;
        $nome = $relatorioAtual->nome;
        $descricao = $relatorioAtual->descricao;
        $coluna_grupo = $relatorioAtual->coluna_grupo;
        $relatorio_pai = $relatorioAtual->relatorio_pai_id;
        $ativo = $relatorioAtual->ativo;
        $sql = $relatorioAtual->codigo_sql;
        $datasourceAtual = $relatorioAtual->datasource_id;
        $checkedParametrizado = $relatorioAtual->parametrizado ? "checked" : "";
        $checkedPublico = $relatorioAtual->publico ? "checked" : "";
        ?>
        <input type="hidden" name="relatorio[id]" value="<?php echo $relatorioAtual->id; ?>" />
    <?php } ?>
    <div class="row">
        <div class="input-field col s12">
            <select name="relatorio[datasource_id]" id="datasource-relatorio" required>
                <option value="">Selecione o Datasource</option>
                <?php
                foreach ($datasources as $datasource) {
                    $selected = "";
                    if ($datasourceAtual == $datasource->id) {
                        $selected = "selected";
                    }
                    ?>
                    <option value="<?= $datasource->id ?>" <?= $selected ?>><?= $datasource->nome; ?> </option>
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
                <option value="conjugado" <?php echo $tipo == 'conjugado' ? "selected" : ""; ?>>Conjugado</option>
                <option value="titulo-relatorio" <?php echo $tipo == 'titulo-relatorio' ? "selected" : ""; ?>>Título de outro relatório</option>
            </select>
            <label>Tipo do relatorio</label>
        </div>
    </div>

<!--    <div class="row">
        <div class="input-field col s12">
            <input type="text" class="form-control" id="coluna-grupo-relatorio" name="relatorio[coluna_grupo]" value="<?php echo $coluna_grupo; ?>">
            <label for="coluna-grupo-relatorio">Coluna grupo</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input type="text" class="form-control" id="coluna-grupo-relatorio" name="relatorio[relatorio_pai_id]" value="<?php echo $relatorio_pai; ?>">
            <label for="coluna-grupo-relatorio">Relatório Pai</label>
        </div>
    </div>-->

    <div class="row">
        <div class="input-field col s12">
            <textarea required id="codigo-sql-relatorio" class=".no-autoinit" name="relatorio[codigo_sql]"><?php echo $sql; ?></textarea>
            <label for="codigo-sql-relatorio">Código SQL</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input type="text" class="form-control" id="icone-relatorio" name="relatorio[icone]" value="<?= $icone ?? ""; ?>">
            <label for="icone-relatorio">Zícone</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <label for="relatorio-parametrizado">
                <input type="checkbox" class="form-control" id="relatorio-parametrizado" name="relatorio[parametrizado]" value="true" <?php echo $checkedParametrizado ?>>
                <span>Parametrizado</span>
            </label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <label for="relatorio-publico">
                <input type="checkbox" class="form-control" id="relatorio-publico" name="relatorio[publico]" value="true" <?php echo $checkedPublico ?>>
                <span>Público</span>
            </label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <div class="switch" style="height: 35px">
                <label>
                    Inativo
                    <input name="relatorio[ativo]" id="relatorio-ativo" type="checkbox" value="true" <?= $ativo ?? FALSE ? 'checked' : '' ?>>
                    <span class="lever"></span>
                    Ativo
                </label>
            </div>
            <label class="active">Estado</label>
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

#{scriptPagina}
<script type="text/javascript" src="/static/codemirror/lib/codemirror.js"></script>
<script type="text/javascript" src="/static/codemirror/mode/sql/sql.js"></script>
<script type="text/javascript" src="/static/codemirror/addon/edit/matchbrackets.js"></script>
<script type="text/javascript" src="/static/codemirror/addon/hint/sql-hint.js"></script>
<script type="text/javascript" src="/static/codemirror/addon/hint/show-hint.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        const editorTextArea = $('#codigo-sql-relatorio')[0];
        var editor = CodeMirror.fromTextArea(editorTextArea, {
            lineNumbers: true,
            theme: 'monokai',
            mode: 'text/x-pgsql',
            showHint: true,
            indentWithTabs: true,
            smartIndent: true,
            lineNumbers: true,
            matchBrackets: true,
            autofocus: true,
            extraKeys: {
                "Ctrl-Space": "autocomplete"
            }
        });
    });
</script>
#{/scriptPagina}