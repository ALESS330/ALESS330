<?php
global $contexto;

$checked = array();
$checked['pdf'] = "";
$checked['xls'] = "";
$checked['csv'] = "";
$checked['html'] = "";
$checked['printer'] = "";
if (isset($formatos)) {

    if (isset($formatos['printer'])) {
        $checked['printer'] = 'checked="checked"';
    }
    
    if (isset($formatos['pdf'])) {
        $checked['pdf'] = 'checked="checked"';
    }

    if (isset($formatos['csv'])) {
        $checked['csv'] = 'checked="checked"';
    }

    if (isset($formatos['xls'])) {
        $checked['xls'] = 'checked="checked"';
    }

    if (isset($formatos['html'])) {
        $checked['html'] = 'checked="checked"';
    }
}
?>

#{botoes}
<div class="fixed-action-btn">
    <a class="btn-floating btn-large" href="@{Relatorios->index()}">
        <i class="large material-icons">menu</i>
    </a>
    <ul>
        <li><a href="@{Relatorios->excluir(<?=$relatorio->id?>)}" class="btn-floating red bt-excluir"><i class="material-icons">delete</i></a></li>
        <li><a href="@{Relatorios->cadastro(<?=$relatorio->id?>)}" class="btn-floating yellow darken-1"><i class="material-icons">edit</i></a></li>
        <li><a href="@{Relatorios->gerar(<?=$relatorio->datasource.",".$relatorio->nome?>)}" class="btn-floating green"><i class="material-icons">remove_red_eye</i></a></li>
        <li><a href="@{Relatorios->index()}" class="btn-floating blue"><i class="material-icons">arrow_back</i></a></li>
    </ul>
</div>
#{/botoes}

<fieldset>
    <legend>Propriedades do Relatório</legend>
    <blockquote>
        <ul>
            <li>Nome: <strong><a href="@{Relatorios->gerar(<?= $datasource->nome ?>,<?= $relatorio->nome?>)}"><?= $relatorio->nome ?></a></strong></li>
            <li>Descrição: <strong><?= $relatorio->descricao ?></strong></li>
        </ul>
    </blockquote>
</fieldset>

<ul class="collapsible">

    <li> <!-- Categorias -->
        <div class="collapsible-header">
            <i class="material-icons">style</i>Categorias do relatório
        </div>
        <div class="collapsible-body">
            <div class="col s12">
                <form action="@{Relatorios->salvarCategoria(<?=$relatorio->id?>,<?=$categoria->id?>)}" role="form" method="POST" >
                    <div class="row">
                        <div class="input-field">
                            <?php foreach($categorias as $categoria){
                                $categorias = json_decode($relatorio->categorias);
                                ?>
                            <p>
                                <label for="checkbox-categoria-<?=$categoria->id?>">
                                    <input class="ck-categoria"
                                        type="checkbox" name="formatos[printer]" 
                                        value="<?=$categoria->id?>" 
                                        <?= array_search($categoria->nome, $categorias) !== false? "checked" : "" ?>
                                        id="checkbox-categoria-<?=$categoria->id?>" />
                                    <span><?=$categoria->nome?></span>
                                </label>
                            </p>
                            <?php } ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </li> <!-- Categorias -->
    <li> <!-- Formatos -->
        <div class="collapsible-header">
            <i class="material-icons">insert_drive_file</i>Formatos do relatório
        </div>
        <div class="collapsible-body">
            <div class="col s12">
                <form action="@{Relatorios->salvarFormatos(<?=$relatorio->id?>)}" role="form" method="POST" >
                    <input type="hidden" name="relatorio[id]" value="<?= $relatorio->id ?>" />
                    <div class="row">
                        <div class="input-field">
                            <p>
                                <label for="checkbox-printer">
                                    <input type="checkbox" name="formatos[printer]" value="printer" id="checkbox-printer" <?= $checked['printer'] ?>/>
                                    <span>Impressora</span>
                                </label>
                            </p>
                            <p>
                                <label for="checkbox-csv">
                                    <input type="checkbox" name="formatos[csv]" value="csv" id="checkbox-csv" <?= $checked['csv'] ?>/>
                                    <span>CSV</span>
                                </label>
                            </p>
                            <p>
                                <label for="checkbox-pdf">
                                    <input type="checkbox" name="formatos[pdf]" value="pdf" id="checkbox-pdf" <?= $checked['pdf'] ?>/>
                                    <span>PDF</span>
                                </label>
                            </p>
                            <p>
                                <label for="checkbox-xls">
                                    <input type="checkbox" name="formatos[xls]" value="xls" id="checkbox-xls" <?= $checked['xls'] ?>/>
                                    <span>XLS</span>
                                </label>
                            </p>
                            <p>
                                <label for="checkbox-html">
                                    <input type="checkbox" name="formatos[html]" value="html" id="checkbox-html" <?= $checked['html'] ?>/>
                                    <span>HTML</span>
                                </label>
                            </p>                           
                        </div>
                    </div>
                    <div>
                        <div class="input-field">
                            <button class="btn btn-primary" type="submit" >Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </li> <!-- Formatos -->
    <li> <!--Grupos de Acesso-->
        <div class="collapsible-header active">
            <i class="material-icons">group</i>Grupos de Acesso
        </div>    
        <div class="collapsible-body">
            <?php if (count($gruposRelatorio) > 0) { ?>
                <table>
                    <thead>
                        <tr>
                            <th colspan="2"><p>Lista de grupos associados a este relatório: </p></th>
                        </tr>
                        <tr>
                            <th>Grupo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gruposRelatorio as $grupo) { ?>
                            <tr>
                                <td><a href="@{Grupos->ver(<?= $grupo->id ?>)}"><?= $grupo->nome ?></a></td>
                                <td>
                                    <a href="@{Relatorios->removeGrupo(<?= "$relatorio->id,$grupo->id" ?>)}" class="bt-excluir">
                                        <i class="material-icons">delete</i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>                     
                    </tbody>
                </table>
                <?php
            } /* if */ else {
                echo "<p>Nenhum grupo associado ao relatório</p>";
            }
            ?>
            <table class="striped">
                <thead>
                    <tr>
                        <th colspan="2">
                            <p>Grupos Disponíveis</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($grupos as $grupo) { ?>
                        <tr>
                            <td><?= $grupo->nome ?></td>
                            <td style="text-align: left">
                                <a href="@{Relatorios->associaGrupo(<?= "$relatorio->id,$grupo->id" ?>)}"
                                   title="Associar este relatório ao grupo <?= $grupo->nome ?> ">
                                    <i class="material-icons">add</i>
                                </a>
                            </td>
                        </tr>
                    <?php } // foreach?> 
                </tbody>
            </table>            
        </div>
    </li> <!-- Grupos de Acesso -->

    <?php if ($relatorio->parametrizado) { ?>    
        <li> <!-- Tela de Parâmetros -->
            <div class="collapsible-header"><i class="material-icons">place</i>Tela de Parâmetros</div>
            <div class="collapsible-body">
                <form action="@{Relatorios->salvarTelaParametros(<?= $relatorio->id ?>)}" class="form-horizontal" rol="form" id="form-consulta-parametros" method="POST" >
                    <input type="hidden" name="tela[relatorio_id]" value="<?= $relatorio->id ?>">
                    <?php
                    if (isset($telaParametros->id)) {
                        echo '<input type="hidden" name="tela[id]" value="' . $telaParametros->id . '">';
                    }
                    ?>
                    <div class="row">
                        <div class="input-field col s12">
                            <select name="tela[formulario_id]">
                                <option value="">Selecione a tela de parâmetros</option>
                                <?php
                                foreach ($telas as $tela) {
                                    $selected = ""; 
                                    if(isset($telaParametros)){
                                        $selected = $tela->id === $telaParametros->formulario_id  ? " selected " : " ";
                                    }
                                    echo "<option value='$tela->id' $selected>$tela->nome</option>";
                                }
                                ?>
                            </select>
                            <label>Tela de Parâmetros</label>
                        </div>
                    </div>                
                    <div class="row">
                        <div class="input-field col s12">
                            <button class="btn btn-primary" type="submit" value="Cadastrar">Salvar</button>
                        </div>
                    </div>      
                </form>
            </div>
        </li><!-- Tela de parâmetros-->
    <?php } //if parametrizado  ?>
        <li> <!-- Decoradores -->
        <div class="collapsible-header">
            <i class="material-icons">compare_arrows</i>Decoradores
        </div>
        <div class="collapsible-body">
            <div class="col s12">
                <form action="@{Relatorios->salvarDecoradores(<?=$relatorio->id?>)}" role="form" method="POST" >
                    <input type="hidden" name="relatorio[id]" value="<?= $relatorio->id ?>" />
                    <div class="row">
                        <table>
                            <thead>
                                <th>Campo</th>
                                <th>Tipo decorador</th>
                                <th>Parâmetro</th>
                                <th>Ordem</th>
                                <th>Ativo</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php 
                                if($decoradores){
                                    foreach($decoradores as $decorador){?>
                                <tr>
                                    <input type="hidden" name="decoradores[<?=$decorador->id?>][id]" value="<?=$decorador->id?>" />
                                    <td>
                                        <div class="input-field inline">
                                          <input type="text" value="<?= $decorador->nome_campo ?>" name="decoradores[<?=$decorador->id?>][nome_campo]">
                                        </div>                                        
                                    </td>
                                    <td>
                                        <select name="decoradores[<?=$decorador->id?>][tipo_decorador_id]">
                                        <?php foreach($tipos_decoradores as $tipo){
                                            $tipoSelected = $tipo->id == $decorador->tipo_decorador_id ? ' selected ' : '';
                                            echo "<option $tipoSelected value='$tipo->id'>$tipo->nome</option>\n";
                                        }//foreach tipos?>
                                        </select>                                            
                                    </td>
                                    <td>
                                        <div class="input-field inline">
                                          <input type="text" value="<?= $decorador->parametro ?>" name="decoradores[<?=$decorador->id?>][parametro]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-field inline">
                                          <input type="text" value="<?=$decorador->ordem?>" name="decoradores[<?=$decorador->id?>][ordem]">
                                        </div>                                        
                                    </td>
                                    <td>
                                        <p>
                                          <label>
                                              <input type="checkbox" name="decoradores[<?=$decorador->id?>][ativo]" value="true" 
                                                     <?php echo $decorador->ativo ? 'checked' : '' ?>/>
                                              <span>&nbsp;</span>
                                          </label>
                                        </p>
                                    </td>
                                    <td>
                                        <div class="acoes">
                                            <a class="bt-excluir" href="#"><i class="material-icons">delete</i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php }//foreach
                                } //if?>
                                <tr>
                                    <td>
                                        <div class="input-field inline">
                                          <input type="text" value="" name="novoDecorador[nome_campo]">
                                        </div>                                        
                                    </td>
                                    <td>
                                        <select name="novoDecorador[tipo_decorador_id]">
                                            <option value="">Escolha um tipo de decorador</option>
                                        <?php foreach($tipos_decoradores as $tipo){
                                            echo "<option value='$tipo->id'>$tipo->nome</option>\n";
                                        }//foreach tipos?>
                                        </select>                                            
                                    </td>
                                    <td>
                                        <div class="input-field inline">
                                          <input type="text" name="novoDecorador[parametro]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-field inline">
                                          <input type="text" name="novoDecorador[ordem]">
                                        </div>                                        
                                    </td>
                                    <td>
                                        <p>
                                          <label>
                                              <input type="checkbox" name="novoDecorador[ativo]" value="true" />
                                              <span>&nbsp;</span>
                                          </label>
                                        </p>
                                    </td>
                                    <td>
                                        <div class="acoes">
                                            <a class="" href="#"><i class="material-icons">info</i></a>
                                        </div>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="input-field">
                            <button class="btn btn-primary" type="submit" >Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </li> <!-- decoradores -->
    
    <li> <!-- Composições -->
        <div class="collapsible-header">
            <i class="material-icons">input</i>Composições
        </div>
        <div class="collapsible-body">
            <div class="col s12">
                <?php if ($composicao ?? false){ ?>
                <h5>Composição atual</h5>
                <blockquote>
                    <ul>
                        <li><strong>#: </strong><?= $composicao->id?></li>
                        <li><strong>Campo de identificação principal: </strong><?= $composicao->campo_identificador_principal?></li>
                        <li><strong>Relatório componente: </strong><?= $composicao->nome?></li>
                        <li><strong>Campo de identificação componente: </strong><?= $composicao->campo_identificador_componente?></li>
                        <li><strong>Obrigatória: </strong><?= $composicao->obrigatoria ? 'Sim' : 'Não'?></li>
                    </ul>
                </blockquote>
                
                <form action="@{Relatorios->excluirComposicao(<?=$relatorio->id.",".$composicao->id?>)}">
                    <div class="row"> 
                        <div class="col s12">
                            <button type="submit" class="btn red bt-excluir">Excluir composição</button>
                        </div>
                    </div>                    
                </form>
                <?php } else { ?>
                <form action="@{Relatorios->salvarComposicao(<?=$relatorio->id?>)}" role="form" method="POST" >
                    <input type="hidden" name="composicao[relatorio_principal_id]" value="<?= $relatorio->id ?>" />
                    <div class="row">
                        <div class="col s12">
                            <select name="composicao[tipo_composicao_id]">
                                <option value="">Selecione o tipo de coposição</option>
                                <?php foreach ($tipos_composicoes as $tc) {
                                    echo "<option value='$tc->id'>$tc->titulo ($tc->descricao)</option>\n";
                                }?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field">
                                <input id="campo-identificador-principal" name="composicao[campo_identificador_principal]" tipo="text" required />
                                <label class="active" for="campo-identificador-principal">Campo identificar no relatório principal</label>
                                <span class="helper-text">O nome do campo no relatório principal que identifica cada registro para composição</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <select name="composicao[relatorio_componente_id]">
                                <option value="">Selecione o relatório componente</option>
                                <?php foreach ($listaRelatorios as $lr) {
                                    if($lr->id == $relatorio->id){
                                        continue;
                                    }
                                    echo "<option value='$lr->id'>$lr->nome ($lr->descricao)</option>\n";
                                }?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field">
                                <input id="campo-identificador-componente" name="composicao[campo_identificador_componente]" tipo="text" required />
                                <label class="active" for="campo-identificador-componente">Campo identificar no relatório coponente</label>
                                <span class="helper-text">O nome do campo no relatório coponente que identifica cada registro para composição</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="composicao-obrigatoria">
                            <input type="checkbox" class="form-control" id="composicao-obrigatoria" name="composicao[obrigatoria]" value="true" >
                            <span>Obrigatória</span>
                        </label>
                        </div>
                    </div>
                    <div>
                        <div class="input-field">
                            <button class="btn btn-primary" type="submit" >Salvar</button>
                        </div>
                    </div>
                </form>
                <?php } ?>
            </div>
        </div>
    </li> <!-- decoradores -->
</ul>

#{scriptPagina}
<script>
  $(document).ready(function(){
    const urls = new Array(2);
    urls[true] = "<?=$contexto?>/relatorio/<?=$relatorio->id?>/categoria/:id/salvar";
    urls[false] = "<?=$contexto?>/relatorio/<?=$relatorio->id?>/categoria/:id/remover";
    
    $(".ck-categoria").on('click', function(e){
      const $amIChecked = $(this).prop("checked");
      const $myValue = $(this).val();
      const $url = urls[$amIChecked].replace(":id", + $myValue);
      alerta = "Erro na requisição! Atualize a página para verificar se esta foi bem sucedida.";      
      fetch($url)
        .then(function(resposta){
          if(resposta.ok){
            return resposta.json().then(retorno => {
              if(retorno.sucesso){
                M.toast({html: retorno.sucesso});
              }else{
                M.toast({html: retorno.erro});
              }
            });
          }else{
            alert(alerta);
          }
        })
        .catch(function(){
          alert(alerta);
        })
    });
  });
</script>
#{/scriptPagina}