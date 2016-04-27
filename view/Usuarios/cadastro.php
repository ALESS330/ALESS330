#{scriptPagina}
<script type="text/javascript">
    $(document).ready(function () {

        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
            '.chosen-select-width': {width: "95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }

        $('#form-cadastro-usuario').submit(function () {

            var senha = $("#senha-usuario").val();
            var confSenha = $("#confirmaSenha-usuario").val();

            if (senha === confSenha) {

                $("#div-senha").removeClass('has-error');
                $("#div-confSenha").removeClass('has-error');
                return true;
            } else {
                $("#div-senha").addClass('has-error');
                $("#div-confSenha").addClass('has-error');
                return false;

            }
        });

    });
</script>
#{/scriptPagina}
<form class="form-horizontal"  rol="form"  id="form-cadastro-usuario" action="<?= $router->link('usuarios->salvar') ?>" method="POST" >

    <input class="form-control" type="hidden" name="usuario[id]" value="<?= (isset($usu[0]->id) ? $usu[0]->id : '') ?>">

    <div class="row">
        <div class="input-field col s12 form-group">
            <input class="form-control" type="text" name="usuario[username]" id="username-usuario" value="<?= (isset($usu[0]->username) ? $usu[0]->username : '') ?>"required>
            <label class="col-md-2 control-label" for="username-usuario">Nome de usuário</label>
        </div>
    </div>

    <div class="row">
        <div id="div-senha" class="input-field col s12 form-group">
            <input class="form-control" type="password" name="usuario[senha]" id="senha-usuario" value="<?= (isset($usu[0]->senha) ? $usu[0]->senha : '') ?>" required>
            <label class="col-md-2 control-label" for="senha-usuario">Senha</label>
        </div>
    </div>

    <div class="row">
        <div id="div-confSenha" class="input-field col s12 form-group">
            <input class="form-control" type="password" name="usuario[confirmaSenha]" id="confirmaSenha-usuario" value="<?= (isset($usu[0]->senha) ? $usu[0]->senha : '') ?>" required>
            <label class="col-md-2 control-label" for="confirmaSenha-usuario">Confirmar senha</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12 form-group">
            <select  class="chosen-select" data-placeholder="Buscar pessoa" name="usuario[pessoaId]" id="pessoaId-usuario" required>
                <option value="" disabled selected>Selecione a pessoa</option>
                <?php
                foreach ($pessoas as $pessoa) {
                    if ($pessoa->id == $usu[0]->pessoa_id) {
                        $selecionado = "selected";
                    } else {
                        $selecionado = '';
                    }
                    ?>
                    <option value="<?= $pessoa->id ?>" <?= $selecionado ?> > <?= $pessoa->nome ?></option>

                <?php } ?>
            </select>
            <label class="col-md-2 control-label" for="pessoaId-usuario">Buscar pessoa</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12 form-group">
            <button class="btn btn-primary" type="submit" value="Cadastrar" >Salvar</button>
            <a href="@{usuarios->listar()}" class="btn btn-danger">Cancelar </a> 
        </div>
    </div>
</form> 

<?php
if (isset($usu[0]->id)) {
    ?>
    <hr>
    <!-- GRUPOS -->
    <form class="navbar-form "  rol="form"  id="form-grupo-usuario" action="<?= $router->link('usuarios->cadastro') . "?id=" . $usu[0]->id ?>" method="POST" >

        <input  type="hidden" name="grupoInclusao[username]" id="username-grupoInclusao"  value="<?= $usu[0]->username ?>" required>
        <h2 class="text-center">Grupo(s)</h2>
        <div class="form-group">
            <label class="col-md-5 control-label" for="grupoId-inclusao">Grupo:</label>
            <div class ="input-group">
                <select class="chosen-select form-control" tabindex="2" data-placeholder="Buscar o grupo" name="grupoInclusao[grupoId]"  id="grupoId-inclusao" required>
                    <option value="">Selecione um grupo</option>
                    <?php foreach ($grupos as $grupo) { ?>
                        <option value="<?= $grupo->id ?>" > <?= $grupo->nome ?></option>

                    <?php } ?>
                </select>   

                <button class="btn btn-success" type="submit" value="Cadastrar" >Adicionar</button>

            </div>
        </div>
    </form>
    <br>

    <div class="table-responsive">
        <table class="table table-hover table-condensed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Grupo</th>    
                    <th>Ação</th>
                </tr>
            </thead>
            <?php foreach ($gruposUsuario as $grupoUsuario) { ?>
                <tr>
                    <td> <?= $grupoUsuario->idgrupo; ?> </td>
                    <td> <?= $grupoUsuario->nome; ?> </td>
                    <td><a href="@{usuarios->cadastro()}" id=<?= $usu[0]->id ?>&idRelGrupo=<?= $grupoUsuario->id ?>"aria-hidden="true" alt='excluir' ><i class="glyphicon glyphicon-remove btn-excluir"></i></a></td>
                </tr> 
            <?php } ?>

        </table>   
    </div>


    <hr>
    <!-- FUNCIONALIDADES -->
    <form class="navbar-form" rol="form" id="form-funcionalidade-usuario" action="<?= $router->link('usuarios->cadastro') . "?id=" . $usu[0]->id ?>" method="POST" >
        <h2 class="text-center">Funcionalidade(s)</h2>
        <input  type="hidden" name="funcionalidadeInclusao[username]" id="username-funcionalidadeInclusao"  value="<?= $usu[0]->username ?>" required>

        <div class="row">
            <div class="input-field col s12 form-group">
                <div class ="input-group">
                    <select class="chosen-select form-control" tabindex="2" data-placeholder="Buscar a funcionalidade" name="funcionalidadeInclusao[funcionalidadeId]" id="funcionalidadeId-inclusao" required>
                        <option value="" selected disabled>Selecione uma funciona funcionalidade</option>
                        <?php foreach ($funcionalidades as $funcionalidade) { ?>
                            <option value="<?= $funcionalidade->id ?>" > <?= $funcionalidade->descricao ?></option>

                        <?php } ?>
                    </select>
                    <label class="col-md-5 control-label" for="grupoId-inclusao">Funcionalidade</label>
                    <button class="btn btn-default btn-success" type="submit" value="Cadastrar">Adicionar</button>
                </div>
            </div>
    </form>
    <br>

    <div class="table-responsive">
        <table class="table table-hover table-condensed">
            <thead>
            <tr>
                <th>ID</th>
                <th>Funcionalidade</th> 
                <th>Descrição</th>
                <th>Ação</th>
            </tr>
            </thead>
            <?php foreach ($funcionalidadesUsuario as $funcionalidade) { ?>
                <tr>
                    <td> <?= $funcionalidade->id; ?> </td>
                    <td> <?= $funcionalidade->funcionalidade; ?> </td>
                    <td> <?= $funcionalidade->descricao; ?>
                    <td><a href="@{usuarios->cadastro()}" id=<?= $usu[0]->id ?>&idRelFuncionalidade=<?= $funcionalidade->id_rel ?>"aria-hidden="true" alt='excluir' ><i class="glyphicon glyphicon-remove btn-excluir"></i></a></td>
                </tr> 
            <?php } ?>

        </table>   
    </div>

<?php } ?>
