<?php
$tabela = $unidades = array();
global $escondeBusca;
$escondeBusca = true;
$j = 0;
$codigoUFAtual = $dados[0]['codigo_unidade_funcional'];
foreach ($dados as $i => $linha) {
    if ($codigoUFAtual !== $linha['codigo_unidade_funcional']) {
        $j = 0;
        $codigoUFAtual = $linha['codigo_unidade_funcional'];
    }
    foreach ($linha as $campo => $valor) {
        $tabela[$linha['codigo_unidade_funcional']][$j][$campo] = $valor;
        $unidades[$linha['codigo_unidade_funcional']]['nome'] = $linha['unidade_funcional'];
    }//foreach linha
    $j++;
}//foreach dados
?>

<style>

    .container{
        width: 98%;
        max-width: 100%;
        margin: 1%;
    }
    .fixed-action-btn{
        display: none;
        bottom: 64px !important;
    }

    .fixed-action-btn a{
        box-shadow: rgba(255,255,255,1) 0px 1px 3px !important;
    }

    div.corpo{
        width: 100%;
        padding: 0;
    }
    table{
        font-size: 9pt;
        width: 100%;
    }
    table thead th {
        padding: 1px  5px;
        border: solid 1px silver;
        text-align: center;
    }

    table thead th.titulo-tabela{
        font-family: Arial;
        font-size: 12pt;
        padding: 8px;
        text-align: left;
    }

    table tbody tr td{
        border-right: solid 1px silver;
        border-left: solid 1px silver;
    }
    table tbody tr:nth-child(2n-1){
        background-color: #f0f0f0;
    }
    /*    table > tbody > tr.par {
            background-color: #f1f1f1 !important; 
        }*/

    div.titulo{
        text-align: center;
        width: 100%;
        padding: 4px;
        background-color: #f2f2f2;
    }

    div.titulo strong{
        font-size: 24pt;
    }

    fieldset > legend{
        font-size: 16pt;
    }
    table tbody tr td:not(.left){
        text-align: center;
    }

    table tbody tr td.situacao span {
        padding: 5px;
        border-radius: 3px;
    }
    table tbody tr td.situacao span.ocupado{
        background-color: red !important;
        color: white;
    }
    table tbody tr td.situacao span.desocupado{
        background-color: green !important;
        color: white;
    }   
    table tbody tr td.situacao span.limpeza{
        background-color: lightblue !important;
        color: black;
    }   
    table tbody tr td.situacao span.reservado{
        background-color: darkblue !important;
        color: white;
    }   
    table tbody tr td.situacao span.patologia{
        background-color: #FF69B4 !important;
        color: black;
    } 
    table tbody tr td.situacao span.vaga{
        background-color: #ffc107 !important;
        color: black;
    }     
    table tbody tr td.situacao span.manutencao{
        background-color: black !important;
        color: yellow;
    }

    table tbody tr td.situacao span.isolamento{
        background-color: #ffc107 !important;
        color: black;
    }

    table td:not(.quebravel){
        /* white-space: nowrap /**/
    }

    table tbody td.truncate{
        width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cards div fieldset{
        opacity: 0;
    }

    .serie-ocupado{ fill: red; }
    .serie-desocupado{ fill: green; }
    .serie-limpeza{ fill: lightblue }
    .serie-reservado{ fill: darkblue; }
    .serie-patologia{ fill: #FF69B4; }
    .serie-vaga{ fill: #FFC107; }
    .serie-manutencao { fill: black}

    #grafico-leitos, #grafico-tipo-leitos{
        /* width: 50%; */
        height: 244px;
    }

    nav{
        z-index: 1000 !important;
    }
    .container .row{
        margin-left: 0;
        margin-right: 0;
    }

    #alerta-need-update{
        position: absolute;
        display: block;
        right: 20px;
        top: 110px;
        background-color: #d50000;
        color: white;
        padding: 6px;
        border-radius: 4px;
        font-weight: bold;
        display: none;
        overflow: hidden;
        height: 32px;
        width: 75px;
        transition-delay: 0.0s;
        transition-duration: 0.25s;
        transition-property: width;
        transition-timing-function: ease-in;
    }

    #alerta-need-update:hover{
        width: 500px;
    }

    /*    li.search{
            display: none;
        }
    
        .cards .row .col:first-child {
            padding-left: 0;
        }
    
        .cards .row .col:last-child {
            padding-right: 0;
        }
    
        .header:after{
            content: "swap_vert";
            font-family: "Material Icons";
        }
        .headerSortUp:after{
            content: "arrow_drop_down" !important;
            font-family: "Material Icons";
        }
    
        .headerSortDown:after{
            content: "arrow_drop_up" !important;
            font-family: "Material Icons";
        }    */

    .remover-linha i, .desocupar-leito i{
        width: 20px !important;
        height: 20px !important;
        font-size: 20px !important;
        border-radius: 15px;
        color: white;
    }
    
    .remover-linha{
        background-color: #b71c1c;
    }
    
    .desocupar-leito{
        background-color: #004d40;
    }
    
    td div.acoes-pagina a {
        padding-top: 6px;
        width: 32px !important;
        height: 32px !important;
        display: inline-block;
        border-radius: 16px;
    }
    
    div.acoes-pagina{
        opacity: 0.05;
        transition-property: opacity;
        transition-duration: 0.5s;        
    }
    
    table tbody tr:hover td div.acoes-pagina{
        opacity: 1;
    }
</style>
<div class="titulo">
    <span id="alerta-need-update" title="Pode ser necessário atualizar a página a fim de visualizar as informações mais recentes.">Atenção! Dados carregados a mais de 60 segundos!</span>
    <strong>Mapa de Leitos</strong>
</div>

<div class="content">
    <div class="corpo">
        <fieldset>
            <?php
            $listaSituacoes = array();
            $contadorLinhas = 0;
            $listaTipos = array();
            foreach ($tabela as $i => $t) {
                ?>
                <table class="bordered" style="margin-bottom: 25px;">
                    <thead>
                        <tr>
                            <th class="titulo-tabela" colspan="11">Unidade Funcional: <?= $t[0]['unidade_funcional'] ?></th>
                        </tr>
                        <tr>
                            <th colspan="3">Leito</th>
                            <th colspan="4" class="mesclada">Paciente</th>
                            <th rowspan="2" class="mesclada">Município</th>
                            <th rowspan="2" class="mesclada">Data</th>
                            <th rowspan="2" class="mesclada">Dias Int.</th>
                            <th rowspan="2" class="mesclada" style="width: 100px;">Ações</th>
                        </tr>
                        <tr>
                            <th>Número</th>
                            <th>Situação</th>
                            <th>Tipo</th>
                            <th>Prontuário</th>
                            <th>Nome</th>
                            <th>Sexo</th>
                            <th>Idade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $listaUnidadesFuncionais = array();
                        //$i = 0;
                        foreach ($t as $indice => $linha) {
                            $contadorLinhas++;
                            //$i++;
                            foreach ($linha as $campo => $valor) {
                                $$campo = $valor == NULL ? "" : $valor;
                            }
                            $listaUnidadesFuncionais[] = $unidade_funcional;
                            //$unidadesFuncionais[$unidade_funcional] = is_numeric($unidadesFuncionais[$unidade_funcional]) ? $unidadesFuncionais[$unidade_funcional] + 1 : 1;
                            //$situacoes[$situacao_leito] = is_numeric($situacoes[$situacao_leito]) ? $situacoes[$situacao_leito] + 1 : 1;
                            $listaSituacoes[$i][$situacao_leito] = isset($listaSituacoes[$i][$situacao_leito]) ? $listaSituacoes[$i][$situacao_leito] + 1 : 1;
                            $listaTipos[$i][$tipo_leito] = isset($listaTipos[$i][$tipo_leito]) ? $listaTipos[$i][$tipo_leito] + 1 : 1;
                            //$nome = strlen($nome) > $MAX_LETRAS ? substr($nome, 0, $MAX_LETRAS - 3) . "..." : $nome;
                            $dias_a_maior = $dias_internados ?? 0 - $dias_media_permanencia ?? 0;
                            if (!$idade && $nome) {
                                $idade = "0";
                            }
                            $municipio = $cidade;
                            if (!$municipio && !$nome) {
                                $municipio = "";
                            }
                            ?>
                            <tr id="<?= "linha-$contadorLinhas" ?>">
                                <td class="leito"><?= $leito ?></td>
                                <td class='situacao'><?= $situacao_leito ?></td>
                                <td class='tipo'><?= $tipo_leito ?></td>
                                <td class="prontuario"><?= $prontuario ?></td>
                                <td class="nome"><?= $nome ?></td>
                                <td class="sexo"><?= $sexo ?></td>
                                <td class="idade"><?= $idade ?></td>
                                <td class="municipio"><?= $municipio ?></td>
                                <td class="data-internacao"><?= $data_internacao ?></td>
                                <td class="dias-internados"><?= $dias_internados ?></td>
                                <td>
                                    <div class="acoes-pagina">
                                        <a href="#" title="Remover linha" class="remover-linha"><i class="material-icons">delete_sweep</i></a>
                                        <a href="#" title="Desocupar leito" class="desocupar-leito"><i class="material-icons">highlight_off</i></a>                                        
                                    </div>
                                </td>
                            </tr>
                            <?php
                        } //foreach ($t)
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="total-geral" colspan="2">Total de registros: <span><?= count($tabela[$i]) ?></span></td>
                            <td colspan="5" class="totais-situacoes">
                                <ul>
                                    <?php
                                    foreach ($listaSituacoes[$i] as $situacao => $totalSituacao) {
                                        echo "<li>$situacao: $totalSituacao</li>\n";
                                    }//foreach
                                    ?>
                                </ul>
                            </td>
                            <td colspan="4" class="totais-tipos">
                                <ul>
                                    <?php
                                    foreach ($listaTipos[$i] as $tipo => $totalTipo) {
                                        echo "<li>$tipo: $totalTipo</li>\n";
                                    }//foreach
                                    ?>
                                </ul>
                            </td>                            
                        </tr>
                    </tfoot>
                </table>
            <?php } //foreach  ?>
        </fieldset>
    </div>
</div>


#{scriptPagina}
<script type="text/javascript">

    atualizaContagens = function ($tabela) {
        let situacoes = {};
        let tipos = {};
        $($tabela).find("tbody tr").each(function () {
            let situacao = $(this).find("td.situacao").text();
            let tipo = $(this).find("td.tipo").text();
            situacoes[situacao] = situacoes[situacao] ? situacoes[situacao] + 1 : 1;
            tipos[tipo] = tipos[tipo] ? tipos[tipo] + 1 : 1;
        });
        $optionsSituacoes = "";
        for(s in situacoes){
            $optionsSituacoes += "<li>" + s + ": <span>" + situacoes[s] + "</span></li>\n";
        }
        $optionsTipos = "";
        for(t in tipos){
            $optionsTipos += "<li>" + t + ": <span>" + tipos[t] + "</span></li>\n";
        }
        
        $totalLinhas = $tabela.find("tbody tr").length;
        $ul = $($tabela).find("tfoot tr .totais-situacoes ul");
        $($tabela).find("tfoot tr .total-geral span").html($totalLinhas);
        $($tabela).find("tfoot tr .totais-tipos ul").html($optionsTipos);
        
        $rodape =  $ul.empty().html($optionsSituacoes);
    }; //atualizarContagens

    $(".remover-linha").on('click', function (e) {
        e.preventDefault();
        $tabela = $(this).closest("table");
        if (!confirm("Deseja realmente remover esta linha da listagem?")) {
            return false;
        }
        $linha = $(this).closest("tr");
        $(this).closest("tr").fadeOut({
            complete: function(){
                $linha.remove();
                atualizaContagens($tabela);                
            }
        });
    }); //.remover-linha on click
    
    $(".desocupar-leito").on('click', function(e){
        e.preventDefault();
        $tabela = $(this).closest('table');
        if(!confirm("Deseja realmente marcar esse leito como desocupado?")){
            return false;
        }
        $linha = $(this).closest("tr");
        $linha.find(".prontuario").html("");
        $linha.find(".nome").html("");
        $linha.find(".sexo").html("");
        $linha.find(".idade").html("");
        $linha.find(".municipio").html("");        
        $linha.find(".dias-internados").html("");
        $linha.find(".data-internacao").html("");
        $linha.find(".situacao").html("DESOCUPADO");
        
        atualizaContagens($tabela);
    }); //.desocupar-leito
</script>
#{/scriptPagina}