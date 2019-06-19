<?php

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
        <i class="large material-icons">arrow_back</i>
    </a>
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
                                    $selected = $tela->id == $telaParametros->id ? " selected " : " ";
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
</ul>

#{scriptPagina}
<script type="text/javascript">
    $(document).ready(function () {

        $("select").material_select();

    });

</script>
#{/scriptPagina}