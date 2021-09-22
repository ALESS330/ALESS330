<form class="form-horizontal" rol="form" id="form-cadastro-categoria" action="@{Categorias->salvar()}" method="POST" >
    
    <?php if (isset($categoria) && isset($categoria->id)) { ?>
        <input type="hidden" name="categoria[id]" value="<?= $categoria->id ?>">
    <?php } ?>
    
    
    <div class="row">
        <div class="input-field col s12">
            <input type="text" required class="form-control data" id="categoria-nome" 
                   name="categoria[nome]" value="<?= $categoria->nome ?? ""?>" />
            <label>Nome</label>
        </div>
    </div>
        
    
    <div class="row">
        <div class="input-field col s12">
            <!--problemas com waves-effect-->
            <button class="btn btn-primary" type="submit" value="Cadastrar">Salvar</button>
            <a href="@{Categorias->index()}" class="btn btn-danger bt-excluir">Cancelar</a>
        </div>
    </div>
</form>