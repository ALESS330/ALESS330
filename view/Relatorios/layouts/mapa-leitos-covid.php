#{botoes}
<div class="fixed-action-btn no-print">
    <a class="btn-floating btn-large red" id="bt-pdf" title="Exportar como PDF">
        <i class="material-icons">picture_as_pdf</i>
    </a>
</div>
#{/botoes}

<?php
$tabela = $unidades = array();
$todasClassesSituacoes = "";
$resumo = array();

global $escondeBusca;
$escondeBusca = true;
$j = 0;
date_default_timezone_set("America/Campo_Grande");
$horaGerado = date('d-m-Y_H:i:s');
$horaGeradoLegivel = date('d/m/Y à\s H:i:s');

$pago_e_cia[20] = true; 
$pago_e_cia[27] = true;
$pago_e_cia[32] = true;
$pago_e_cia[46] = true;

$total_pago_e_cia = 0;
$normal_pago = 0;
$excedente_pago_e_cia = 0;

$codigoUFAtual = $dados[0]['codigo_unidade_funcional'];

$leitosObservadosBerco = ["0001A", "0001B", "0001C", "0001D", "0009A", "0009B", "0009C", "0009D", "0010A", "0010B", "0010C", "0010D"];
$leitosObservadosIsolamentoRespiratorio = ["0063C", "0063D", "0064G", "0065I", "0065J", "0050A", "0051A","0004A", "0005A", "0006A"];

/*
  0 - DESOCUPADO
  10 - BLOQUEIO FAMILIARES
  14 - BLOQUEIO ACOMPANHANTE
  16 - OCUPADO
  21 - LIMPEZA
  22 - MANUTENCAO
  23 - INFECCAO
  24 - BLOQUEIO ADMINISTRATIVO
  25 - DESATIVADO
  29 - TECNICO
  30 - PATOLOGIA
  31 - RESERVADO
  32 - ALOCACAO TEMPORARIA
  33 - BLOQUEIO RADIATIVO
  34 - PERTENCES PACIENTE
  35 - RESERVADO CIRURGIA ELETIVA
  36 - VAGA AUTORIZADA CRLD
  37 - RESERVADO ALTA UTI
  38 - DIALISE PERITONEAL INTERMITENTE - DPI
  39 - ISOLAMENTO DE CONTATO
  40 - ISOLAMENTO RESPIRATÓRIO
  50 - BLOQUEIO MÉDICO
  60 - LEITO LIBERADO POR ALTA
 */
$situacaoMostrarNome = [0, 22, 24, 50, 31, 35, 36, 37];

$observacoes[3]['leito'] = "* O Leito é um berço";
$observacoes[3]['isolamento-respiratorio'] = "** Leito de isolamento respiratório</br>\n";
$observacoes[11]['isolamento-respiratorio'] = "** Leito de isolamento respiratório</br>\n";
$observacoes[12]['isolamento-respiratorio'] = "** Leito de isolamento respiratório</br>\n";
$observacoes[13]['isolamento-respiratorio'] = "** Leito de isolamento respiratório</br>\n";
$observacoes[16]['isolamento-respiratorio'] = "** Leito de isolamento respiratório</br>\n";

$situacoesCovid['descartado'] = "Descartado";
$situacoesCovid['suspeito'] = "Suspeito";
$situacoesCovid['confirmado'] = "Confirmado";

$classesCovid['descartado'] = "green darken-3 white-text";
$classesCovid['suspeito'] = "yellow darken-3 white-text";
$classesCovid['confirmado'] = "red darken-3 white-text";

const textaoSituacao = 'OCUPADO <small>(exceto PAGO, PAGO COVID, CO e PSA)</small>';

$resumo['covid']['confirmado'] = 0;
$resumo['covid']['suspeito'] = 0;
$resumo['covid']['descartado'] = 0;

foreach ($dados as $i => $linha) {
    
    //abaixo, verifico se esta linha é de unidade diferente da anterior
    //nesse caso, reinicio o contador da unidade (j)
    if ($codigoUFAtual !== $linha['codigo_unidade_funcional']) {
        $j = 0;
        $codigoUFAtual = $linha['codigo_unidade_funcional'];
    }

    $resumo['tipo'][$linha['tipo_leito']] = isset($resumo['tipo'][$linha['tipo_leito']]) ? $resumo['tipo'][$linha['tipo_leito']] + 1 : 1;
    $resumo['situacao'][$linha['situacao_leito']] = isset($resumo['situacao'][$linha['situacao_leito']]) ? $resumo['situacao'][$linha['situacao_leito']] + 1 : 1;
    $resumo['covid'][$linha['situacao_covid']] = isset($resumo['covid'][$linha['situacao_covid']]) ? $resumo['covid'][$linha['situacao_covid']] + 1 : 1;
    
    //abaixo, verifico se esta unidade está dentre aquelas que são 
    //monitoradas para separação de contagem (pago_e_cia)
    if($pago_e_cia[$codigoUFAtual] ?? false){
        //abaixo, aumento o contador desse resumo
        $total_pago_e_cia += 1;
        if($linha['tipo_leito'] == 'EXCEDENTE'){
            //aqui, incremento o excedente das unidades que estão sendo
            //separadas das outras
            $excedente_pago_e_cia +=1;        
        }else{
            $normal_pago++;
        }
        //aqui, estou criando e/ou atualizando a linha de resumo desta situação
        $resumo['situacao'][textaoSituacao] = isset($resumo['situacao'][textaoSituacao]) ? $resumo['situacao'][textaoSituacao]+1 : 1;
    }
    
    foreach ($linha as $campo => $valor) {
        $tabela[$linha['codigo_unidade_funcional']][$j][$campo] = $valor;
    }//foreach linha
    $j++;
}//foreach dados


$total = $resumo['situacao']['OCUPADO'];
$excedente = $resumo['tipo']['EXCEDENTE'];
$normal = $total - $excedente; 
$total_sem_pagoecia = $total - $total_pago_e_cia;
$ativos_sem_pagoecia = $normal - $normal_pago;
$excedente_sem_pagoecia = $excedente - $excedente_pago_e_cia;
$totalAtivo = count($dados) - $excedente;

/*
if ((strpos($situacao, "OCUPADO") !== FALSE) && (strpos($situacao, "DESOCUPADO") === FALSE)) {
    $excedente = $resumo['tipo']['EXCEDENTE'];
       
       echo "<li class='$class'>$situacao: <span>$total [Leitos Ativos: $normal | Excedente: $excedente]</span></li>";
       echo "<li class='$class'>OCUPADO <small>(exceto PAGO, PAGO COVID, CO e PSA): </small><span>$total_sem_pagoecia  [Leitos Ativos: $ativos_sem_pagoecia| Excedente: $excedente_sem_pagoecia]</span></li>";
   }}
                       }
 *   */ 

$ocupados = $resumo['situacao']['OCUPADO'];
$ocupadosExcetoPagoCia = $resumo['situacao'][textaoSituacao];
$resumo['situacao']['OCUPADO'] = "<span>$ocupados [Leitos Ativos :$normal | Excedente: $excedente]</span>";
$resumo['situacao'][textaoSituacao] = "<span>$total_sem_pagoecia [Leitos Ativos: $ativos_sem_pagoecia| Excedente: $excedente_sem_pagoecia]</span>";
$excedentes = "";
unset($resumo['covid']['']);
$coluna = array();

$coluna2[0] = "Confirmados: " . $resumo['covid']['confirmado'] ?? 0;
$coluna2[1] = "Suspeitos: "   . $resumo['covid']['suspeito'] ?? 0;
$coluna2[2] = "Descartados: " . $resumo['covid']['descartado'] ?? 0; 

$vars = get_defined_vars();
//echo "<pre>"; print_r($vars); exit(0); 
?>
<div  id="conteudo-mapa">

    <style>

        .container{
            width: 98%;
            max-width: 100%;
            margin: 1%;
        }
        .fixed-action-btn{
            bottom: 64px !important;
        }

        .fixed-action-btn a{
            box-shadow: rgba(255,255,255,1) 0px 1px 3px !important;
        }

        div.corpo{
            width: 100%;
            padding: 0;
        }
        table:not(#tb-resumo){
            font-size: 9pt;
            width: 100%;
        }
        table:not(#tb-resumo) thead th {
            padding: 1px  5px;
            border: solid 1px silver;
            text-align: center;
        }

        table:not(#tb-resumo) thead th.titulo-tabela{
            font-family: Arial;
            font-size: 12pt !important;
            padding: 8px;
            text-align: left;
        }

        table:not(#tb-resumo) tbody tr td{
            border-right: solid 1px silver;
            border-left: solid 1px silver;
        }
        table:not(#tb-resumo) tbody tr:nth-child(2n-1){
            background-color: #f0f0f0;
        }

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
        table:not(#tb-resumo) tbody tr td:not(.texto-esquerdo){
            text-align: center;
        }

        table:not(#tb-resumo) tbody td.truncate{
            width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        nav{
            z-index: 1000 !important;
        }
        .container .row{
            margin-left: 0;
            margin-right: 0;
        }

        .remover-linha i, .desocupar-leito i{
            width: 20px !important;
            height: 20px !important;
            font-size: 20px !important;
            border-radius: 15px;
            color: white;
        }

        div.splash-aguardar{
            width: 100%;
            height: 100%;
            background-color: #222222;
            position: fixed;
            top: 0;
            left: 0;
        }

        div.splash-aguardar h1{
            font-family: Arial;
            font-size: 30pt;
            text-align: center;
            padding-top: 100px;
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

        table:not(#tb-resumo) tbody tr:hover td div.acoes-pagina{
            opacity: 1;
        }

        .titulo-relatorio{
            font-size: 14pt;
        }

        tr.linha-conferida{
            background-color: #ddffdd !important;
        }

        tr.linha-conferida .acoes-pagina{
            display: none;
        }
        tr.linha-conferida .acoes-conferida{
            display: block;
        }

        div.acoes-conferida{
            display: none;
        }

        label.conferido{
            display: block;
            width: 18px;
            margin: 0 auto;
            padding: 0px;
        }

        #progresso{
           position: fixed;
           top: 64px;
           left: 0px;
           height: 2px;
           width: 100%;
           background-color: red;
        }
        
        @media print{
            .no-print{
                display: none !important;
            }
            table ul{  
                font-size: 8pt !important;
            }
            
            ul, li{
                list-style: none !important;
            }
            
            p.titulo-relatorio{
                margin-bottom: 5mm !important;
            }
            
            #tb-resumo tbody tr{
                font-size: 8pt !important;
            }
            
            #tb-resumo thead{
                font-size: 10pt !important;
            }
            
            #tb-resumo{
                margin-top: 5mm !important;
            }
        }
    </style>
    <div class="content">
        <div class="corpo">
            <fieldset>
                <p class="center titulo-relatorio" style="text-align: center; font-size: 16pt; font-weight: bold">Mapa de Leitos - Hospital Universitário da UFGD</p>
                <p style="font-size: 8pt; margin: 5px;">Relatório gerado em: <span id="hora-gerado"><?= $horaGeradoLegivel ?></span></p>
                <table id="tb-resumo">
                    <thead>
                        <tr>
                            <th colspan="2" style="text-align: left">Total de leitos ativos: <?=$totalAtivo?></th>
                        </tr>
                        <tr>
                            <th colspan="2" style="text-align: left">Total de pacientes: <span class="ocupado"><?= $resumo['situacao']['OCUPADO'] ?></span></th>
                        </tr>
                        <tr>
                            <th>Situação dos leitos:</th>
                            <th>COVID 19:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ocupados = $resumo['situacao']['OCUPADO'];
                        $i = 0;
                        foreach ($resumo['situacao'] as $situacao => $total) {
                            $class = mb_strtolower(str_replace(" ", "_", $situacao));
                            $todasClassesSituacoes .= " $class";
                            $textoColuna1 = $situacao . ": <span>$total</span>";
                            $textoColuna2 = isset($coluna2[$i]) ? $coluna2[$i] : "";
                            $i++;
                            ?>
                        <tr class="linha-resumo">
                            <td class="<?=$class?>" style="text-align: left"><?=$textoColuna1?></td>
                            <td class=""><?=$textoColuna2?></td>
                        </tr>
                            
                        <?php }
                        ?>
                    </tbody>
                </table>
            </fieldset>

            <fieldset style="margin-top: 8mm">
<?php
$listaSituacoes = array();
$contadorLinhas = 0;
$listaTipos = array();
$listaCovid = array();
foreach ($tabela as $i => $t) {
    ?>
                    <table cellspacing="0" cellpadding="0" class="bordered" style="margin-bottom: 25px;" id="mapa-tb-<?=$i?>">
                        <thead>
                            <tr>
                                <th class="remover"></th>
                                <th class="titulo-tabela texto-esquerdo" colspan="11">Unidade Funcional: <?= $t[0]['unidade_funcional'] ?></th>
                                <th class="remover"></th>
                            </tr>
                            <tr>
                                <th rowspan="2" class="mesclada remover">Conferido</th>
                                <th colspan="3">Leito</th>
                                <th colspan="4" class="mesclada">Paciente<br></th>
                                <th rowspan="2" class="mesclada">Município</th>
                                <th rowspan="2" class="mesclada">Data Int.</th>
                                <th rowspan="2" class="mesclada">Dias Int.</th>
                                <th rowspan="2" class="mesclada">COVID 19</th>
                                <th rowspan="2" class="mesclada remover" style="width: 100px;">Ações</th>
                            </tr>
                            <tr>
                                <th>Número</th>
                                <th>Situação</th>
                                <th>Tipo</th>
                                <th>Prontuário</th>
                                <th class="texto-esquerdo">Nome</th>
                                <th>Sexo</th>
                                <th>Idade</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php
    //$i = 0;
    foreach ($t as $indice => $linha) {
        $contadorLinhas++;
        //$i++;
        foreach ($linha as $campo => $valor) {
            $$campo = $valor == NULL ? "" : $valor;
        }
        $covid = FALSE;
        $classCovid = "";
        if(isset($situacao_covid)){
            if($situacao_covid !== ''){
                $covid = $situacoesCovid[$situacao_covid];
                $listaCovid[$i][$situacao_covid] = isset($listaCovid[$i][$situacao_covid]) ? $listaCovid[$i][$situacao_covid] + 1 : 1;
                $classCovid = $classesCovid[$situacao_covid];
            }
            unset($situacao_covid); 
        }
        $listaSituacoes[$i][$situacao_leito] = isset($listaSituacoes[$i][$situacao_leito]) ? $listaSituacoes[$i][$situacao_leito] + 1 : 1;
        $listaTipos[$i][$tipo_leito] = isset($listaTipos[$i][$tipo_leito]) ? $listaTipos[$i][$tipo_leito] + 1 : 1;
        
        //$nome = strlen($nome) > $MAX_LETRAS ? substr($nome, 0, $MAX_LETRAS - 3) . "..." : $nome;
        $dias_a_maior = $dias_internados ?? 0 - $dias_media_permanencia ?? 0;
        
        
        $textoIdade = "";
        if($idade_anos > 0){
            $textoIdade = $idade_anos;
        }else {
            if($idade_meses < 1){
                $textoIdade = ($idade_dias == 1 ? "1 dia" : "$idade_dias dias");
            }else{ 
                $textoIdade = ($idade_meses == 1 ? "1 mês" : "$idade_meses meses");
            }
        }
        if ($situacao_leito !== "OCUPADO") {
            $textoIdade  = "";
        }        
        $dadosCartaoSUS = '';
        if (array_search($linha['codigo_situacao'], $situacaoMostrarNome) || $situacao_leito == 'OCUPADO') {
            if($textoIdade ?? false){
                $dadosCartaoSUS = "<strong>CNS: " . ($cartao_sus ?: ' - ') . "</strong>";
            }
        } else {
            $nome = "";
        } 
        $municipio = $cidade;
        if (!$municipio && !$nome) {
            $municipio = "";
        }
        if (isset($observacoes[$i]['leito'])) {
            $leito = array_search(trim($leito), $leitosObservadosBerco) !== FALSE ? "$leito *" : $leito;
        }
        if (isset($observacoes[$i]['isolamento-respiratorio'])) {
            $leito = array_search(trim($leito), $leitosObservadosIsolamentoRespiratorio) !== FALSE ? "$leito **" : $leito;
        }
         
        $cSituacao = mb_strtolower(str_replace(" ", "_", $situacao_leito));
        $cTipo = mb_strtolower(str_replace(" ", "_", $tipo_leito));
        ?>
                                <tr id="<?= "linha-$contadorLinhas" ?>" class="<?php echo "$cSituacao $cTipo"; ?>">
                                    <td class="conferido remover">
                                        <label class="conferido">
                                            <input class="conferido" type="checkbox" id="conferido-<?= $contadorLinhas ?>" />
                                            <span></span>
                                        </label>
                                    </td>
                                    <td class="leito"><?= $leito ?></td>
                                    <td class='situacao'><?= $situacao_leito ?></td>
                                    <td class='tipo'><?= $tipo_leito ?></td>
                                    <td class="prontuario"><?= $prontuario ?></td>
                                    <td class="nome texto-esquerdo" style="text-align: left"><?= $nome ?><br><?= $dadosCartaoSUS?></strong></td>
                                    <td class="sexo"><?= $sexo ?></td>
                                    <td class="idade"><?= $textoIdade ?></td>
                                    <td class="municipio"><?= $municipio ?></td>
                                    <td class="data-internacao"><?= $data_internacao ?></td>
                                    <td class="dias-internados"><?= $dias_internados ?></td>
                                    <td class="covid">
                                        <?php if($covid) {?>
                                        <span class="badge <?= $classCovid ?>"><?= $covid ?></span>
                                        <?php } ?>
                                    </td>
                                    <td class="remover">
                                        <div class="acoes-pagina">
                                            <a href="#" title="Remover linha" class="remover-linha"><i class="material-icons">delete_sweep</i></a>
                                            <a href="#" title="Desocupar leito" class="desocupar-leito"><i class="material-icons">highlight_off</i></a>                                        
                                        </div>
                                        <div class="acoes-conferida"><small>Conferido</small></div>
                                    </td>
                                </tr>
                                <?php
                            } //foreach ($t)
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="total-geral" colspan="2"  style="border: 1px solid silver">
                                    <div>Leitos Operacionais: <span><?= count($tabela[$i]) ?></span></div>
                                    <?php
                                    if (isset($observacoes[$i])) {
                                        echo "<div>";
                                        foreach ($observacoes[$i] as $obs) {
                                            echo "<span>" . $obs . "</span></br>";
                                        }
                                        echo "</div>";
                                    }
                                    ?>
                                </td>
                                <td colspan="4" class="totais-situacoes" style="border: 1px solid silver">
                                    <ul>
                                        <?php
                                        foreach ($listaSituacoes[$i] as $situacao => $totalSituacao) {
                                            echo "<li>$situacao: $totalSituacao</li>\n";
                                        }//foreach
                                        ?>
                                    </ul>
                                </td>
                                <td colspan="3" class="totais-tipos" style="border: 1px solid silver">
                                    <ul>
                                        <?php
                                        foreach ($listaTipos[$i] as $tipo => $totalTipo) {
                                            if($tipo == 'NORMAL'){
                                                $tipo = 'Leitos Ativos';
                                            }
                                            echo "<li>$tipo: $totalTipo</li>\n";
                                        }//foreach
                                        ?>
                                    </ul>
                                </td>
                                <td colspan="4" class="totais-covid" style="border: 1px solid silver">
                                    <strong>Situação da COVID 19 na unidade</strong>
                                    <ul>
                                    <?php
                                        if(isset($listaCovid[$i])){
                                            foreach ($listaCovid[$i] as $situacaoCovid => $totalCovid) {
                                                echo "<li>". $situacoesCovid[$situacaoCovid ] . ": $totalCovid</li>\n";
                                        }   //foreach   
                                        }else {
                                            echo "<li>Nenhuma ocorrência</li>\n";
                                        }
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
</div>

<!-- div id="progresso">
    
</div -->

<div id="aguardar" style="display: none">
    <h1>Aguarde... O relatório está sendo gerado.</h1>
</div>

<form action="@{Relatorios->downloadHtmlAsPDF()}" id="hidden-form" style="display: none" method="POST" target="_blank">
    <input id="hidden-html" type="hidden" name="html" />
    <input type="hidden" name="titulo" value="Mapa de Leitos" />
    <input type="hidden" name="filename" value="MapaDeLeitos[<?= $horaGerado ?>].pdf" />
</form>

#{scriptPagina}
<script type="text/javascript">
    $todasClasses = "<?= $todasClassesSituacoes ?>";
    $interval = null;
    atualizaContagens = function ($tabela) {
        let situacoes = {};
        let tipos = {};
        $($tabela).find("tbody tr").each(function () {
            let situacao = $(this).find("td.situacao").text();
            let tipo = $(this).find("td.tipo").text();
            situacoes[situacao] = situacoes[situacao] ? situacoes[situacao] + 1 : 1;
            tipos[tipo] = tipos[tipo] ? tipos[tipo] + 1 : 1;
        });

        $("ul.resumo li").each(function () {
            $class = $(this).attr("class");
            $total = $("tr." + $class).length;
            if ($total === 0) {
                $(this).remove();
            } else {
                $(this).find("span").text($total);
            }
        });
        $excedente = $("tr.excedente").length;
        $ocupados = $("tr.ocupado").length
        $normal = $ocupados - $excedente;
        $("li.ocupado span").text(`${$ocupados} [Normal: ${$normal} | Excedente ${$excedente}]`);
        $("span.ocupado").text($ocupados);
        $optionsSituacoes = "";
        for (s in situacoes) {
            $optionsSituacoes += "<li>" + s + ": <span>" + situacoes[s] + "</span></li>\n";
        }
        $optionsTipos = "";
        for (t in tipos) {
            $optionsTipos += "<li>" + t + ": <span>" + tipos[t] + "</span></li>\n";
        }

        $totalLinhas = $tabela.find("tbody tr").length;
        $ul = $($tabela).find("tfoot tr .totais-situacoes ul");
        $($tabela).find("tfoot tr .total-geral span").html($totalLinhas);
        $($tabela).find("tfoot tr .totais-tipos ul").html($optionsTipos);

        $rodape = $ul.empty().html($optionsSituacoes);
    }; //atualizarContagens

    $("label.conferido").on('change', function (e) {
        let $minhaLinha = $(this).closest("tr");
        let $meuCheck = $(this).find(":checkbox");
        let $meuCheckStatus = $meuCheck.prop("checked");
        if ($meuCheckStatus) {
            $minhaLinha.addClass("linha-conferida");
        } else {
            $minhaLinha.removeClass("linha-conferida");
        }
    });

    $(".remover-linha").on('click', function (e) {
        e.preventDefault();
        $tabela = $(this).closest("table");
        if (!confirm("Deseja realmente remover esta linha da listagem?")) {
            return false;
        }
        $linha = $(this).closest("tr");
        $(this).closest("tr").fadeOut({
            complete: function () {
                $linha.remove();
                atualizaContagens($tabela);
            }
        });
    }); //.remover-linha on click

    $(".desocupar-leito").on('click', function (e) {
        e.preventDefault();
        $tabela = $(this).closest('table');
        if (!confirm("Deseja realmente marcar esse leito como desocupado?")) {
            return false;
        }
        $linha = $(this).closest("tr");
        $linha.removeClass($todasClasses).addClass("desocupado");
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
    $i = 0;


    $("#bt-pdf").on('click', function (e) {
        $(".remover").remove();
        e.preventDefault();
        $interval = window.setInterval(function () {
            $i++;
            if ($i >= 20) {
                window.clearInterval($interval);
            }
            console.log("Buscado... ", new Date().toLocaleString());
            fetch("/relator/relatorios/gerado/aghu/mapa-leitos")
                    .then(function (response) {
                        response.json().then(function (gerado) {
                            if (gerado) {
                                window.clearInterval($interval);
                                location.reload();
                            }
                        });
                    })
        }, 300);
//        fetch("/relator/relatorios/gerado/aghu/mapa-leitos")
//        .then(function(response){
//            response.json().then(function(gerado){
//                if(!gerado["aghu/mapa-leitos"]){
//                }
//            })//resonse then
//        }//then
//        );
        $(".content").fadeOut();
        $("#aguardar").fadeIn();
        $(".titulo-tabela").attr("colspan", "11");
        $html = $(".content").html();
        $("#hidden-html").val($html);
        $("#hidden-form").submit();

    });
</script>
#{/scriptPagina}