#{scriptPagina}
<script type="text/javascript">
    $(document).ready(function () {
        $('select').material_select();
        //$("#data-relatorio").mask("99/99/9999");
    });

</script>
#{/scriptPagina}

#{botoes}

  <div class="fixed-action-btn">
    <a class="btn-floating btn-large" href="@{Relatorios->propriedades(<?= $parametro->relatorio_id?>)}">
      <i class="large material-icons">arrow_back</i>
    </a>
</div>
#{/botoes}


<form class="form-horizontal" rol="form" id="form-cadastro-convenio" action="@{Parametros->salvar()}" method="POST" >

    <div class="row">
        <div class="input-field col s12">
            <input type="text" required class="form-control data" id="parametro-nome" name="parametro[nome]" value="<?= $parametro->nome ?>">
            <label for="parametro-nome">Nome</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input type="text" required class="form-control data" id="parametro-descricao" name="parametro[descricao]" value="<?= $parametro->descricao ?>">
            <label for="parametro-descricao">Descrição</label>
        </div>
    </div>
    
    <div class="row">
        <div class="input-field col s12">
            <select id="parametro-relatorio" name="parametro[relatorio_id]">
                <option value="" >Selecione o Relatório</option>

                <?php
                $optionGrp = $relatorios[0]->nome_datasource;
                echo "<optgroup label=\"$optionGrp\">\n";
                foreach ($relatorios as $relatorio) {
                    if ($optionGrp != $relatorio->nome_datasource) {
                        $optionGrp = $relatorio->nome_datasource;
                        echo "</optgroup>\n<optgroup label=\"$optionGrp\">";
                    }
                    $selected = "";
                    if ($parametro->relatorio_id == $relatorio->id) {
                        $selected = "selected";
                    }
                    ?>
                    <option value="<?php echo $relatorio->id; ?>" <?php echo $selected ?>><?php echo $relatorio->nome; ?> </option>
                <?php } //foreach ?>
            </select>
            <label for="parametro-relatorio">Relatório</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input type="text" required class="form-control data" id="parametro-valor-padrao" name="parametro[valor_padrao]" value="<?= $parametro->valor_padrao ?>">
            <label for="parametro-valor-padrao">Valor padrão</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <button class="btn btn-primary" type="submit" value="Cadastrar">Salvar</button>
        </div>
    </div>
</form>