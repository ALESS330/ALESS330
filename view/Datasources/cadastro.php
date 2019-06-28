<form class="form-horizontal" rol="form" id="form-cadastro-datasource" action="@{Datasources->salvar()}" method="POST" >
    
    <?php if ($datasource->id) { ?>
        <input type="hidden" name="datasource[id]" value="<?= $datasource->id ?>">
    <?php } ?>
    
    
    <div class="row">
        <div class="input-field col s12">
            <input type="text" required class="form-control data" id="datasource-nome" 
                   name="datasource[nome]" value="<?= $datasource->nome ?? ""?>" />
            <label>Nome</label>
        </div>
    </div>
        
    <div class="row">
        <div class="input-field col s12">
            <input type="text" required class="form-control data" id="datasource-descricao" 
                   name="datasource[descricao]" value="<?= $datasource->descricao ?? ""?>" />
            <label>Descrição</label>
        </div>
    </div>        

    <div class="row">
        <div class="input-field col s12">
            <input type="text" required class="form-control data" id="datasource-conexao"
                   name="datasource[conexao]" value="<?= $datasource->conexao ?? ""?>" />
            <label for="data-datasource">Conexão</label>
        </div>
    </div>
    
    <div class="switch" style="height: 35px">
        <label>
            Inativo
            <input name="datasource[ativo]" id="datasource-ativo" type="checkbox" value="true" <?= $datasource->ativo ?? FALSE ? 'checked' : '' ?>>
            <span class="lever"></span>
            Ativo
        </label>
    </div>
        
    <div class="row">
        <div class="input-field col s12">
            <!--problemas com waves-effect-->
            <button class="btn btn-primary" type="submit" value="Cadastrar">Salvar</button>
            <a href="@{Datasources->index()}" class="btn btn-danger">Cancelar</a>
        </div>
    </div>
</form>