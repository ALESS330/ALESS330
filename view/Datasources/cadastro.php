#{scriptPagina}
<script type="text/javascript">
    $(document).ready(function () {
        $('select').material_select();
        $("#data-convenio").mask("99/99/9999");
    });

    $("#data-convenio").blur(function () {
        $("[for='data-convenio']").removeClass("active");
    });

</script>
#{/scriptPagina}

<form class="form-horizontal" rol="form" id="form-cadastro-convenio" action="@{Convenios->salvar()}" method="POST" >

    <div class="row">
        <div class="input-field col s12">
            <select name="convenio[instituicao]" id="instituicao-convenio" required>
                <option value="" disabled selected>Selecione o tipo da instituiçao</option>
                <?php
                foreach ($instituicoes as $instituicao) {
                    ?>
                    <option value="<?php echo $instituicao->id; ?>"><?php echo $instituicao->nome_fantasia; ?> </option>
                <?php } ?>
            </select>
            <label>Instituição</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input type="text" required class="form-control data" id="data-convenio" name="convenio[data]">
            <label for="data-convenio">Data do Convenio</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <!--problemas com waves-effect-->
            <button class="btn btn-primary" type="submit" value="Cadastrar">Salvar</button>
            <a href="@{Convenios->listar()}" class="btn btn-danger">Cancelar</a>
        </div>
    </div>
</form>