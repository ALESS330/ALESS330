<form class="form-horizontal" rol="form" id="form-cadastro-convenio" action="@{Datasources->salvar()}" method="POST" >

    <div class="row">
        <div class="input-field col s12">
            <input type="text" required class="form-control data" id="datasource-nome" name="datasource[nome]">
            <label>Nome</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input type="text" required class="form-control data" id="datasource-conexao" name="datasource[]">
            <label for="data-convenio">Conexão</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <!--problemas com waves-effect-->
            <button class="btn btn-primary" type="submit" value="Cadastrar">Salvar</button>
            <a href="@{Datasources->index()}" class="btn btn-danger">Cancelar</a>
        </div>
    </div>
</form>