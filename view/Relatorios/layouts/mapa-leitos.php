<?php
//$jsonDadosTabela = json_encode($dados);
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

    table tbody tr td{
        border-right: solid 1px silver;
        border-left: solid 1px silver;
    }
    table > tbody > tr{
        background-color: white;
    }
    table > tbody > tr.par {
        background-color: #f2f2f2 !important; 
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

    table tbody tr td.situacao {
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

    table td:not(.quebravel){
        /* white-space: nowrap /**/
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
        width: 372px;
    }

    li.search{
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
    }    

</style>
<div class="titulo">
    <span id="alerta-need-update" title="Pode ser necessário atualizar a página a fim de visualizar as informações mais recentes.">Atenção! Dados carregados a mais de 60 segundos!</span>
    <strong>Mapa de Leitos</strong>
</div>
<div class="cards">
    <div class="row">
        <div class="col s6">
            <fieldset>
                <legend>Filtros</legend>
                <div>
                    <form>
                        <div class="row">
                            <div class="input-field">
                                <select id="unidades-funcionais" multiple>
                                </select>
                                <label for="unidades-funcionais">Unidade Funcional</label>                
                            </div>                    
                        </div>
                        <div class="row">
                            <div class="input-field">
                                <select id="situacao-leitos" multiple>
                                </select>
                                <label for="situacao-leitos">Situação do Leito</label>                
                            </div>                    
                        </div>

                        <div class="row right">
                            <button type="button" id="botao-limpar" class="btn waves-effect grey lighten-2 " style="color: black">Limpar</button>
                            <button type="button" id="botao-filtrar" class="btn primary waves-effect ">Aplicar</button>
                        </div>

                    </form>
                </div>
            </fieldset>
        </div>

        <div class="col s3">
            <fieldset>
                <legend>Leitos <span id="total-linhas"></span></legend>
                <div id="grafico-leitos">

                </div>
            </fieldset>
        </div>
        <div class="col s3">
            <fieldset>
                <legend>Tipo</legend>
                <div id="grafico-tipo-leitos">

                </div>
            </fieldset>
        </div>
    </div>
</div>

<div class="content">
    <div class="corpo">
        <fieldset>
            <table class="bordered responsive-table" style="display: none">
                <thead>
                    <tr>
                        <th colspan="4" rowspan="2" class="mesclada">Paciente</th>
                        <th colspan="12" class="mesclada">Internação</th>
                    </tr>
                    <tr class="titulo">
                        <th colspan="3">Leito</th>
                        <th colspan="2">Clínica</th>
                        <th colspan="2">Procedimento</th>
                        <th rowspan="2">Data</th>
                        <th rowspan="2">Média de Permanência</th>
                        <th rowspan="2">Dias Int.</th>
                        <th rowspan="2">Dias à maior</th>
                        <th rowspan="2">Previsão de Alta</th>                        
                    </tr>
                    <tr>
                        <th>Prontuário</th>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Idade</th>
                        <th>Número</th>
                        <th>Situação</th>
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th>Unidade Funcional</th>
                        <th>Código</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $listaUnidadesFuncionais = array();
                    $listaSituacoes = array();
                    $i = 0;
                    foreach ($dados as $linha) {
                        /*
                        echo "<pre>";
                        print_r($linha);
                        echo "</pre>";
                        die("OK");
// */
                        if ($i % 2 === 0) {
                            $parImpar = " par ";
                        } else {
                            $parImpar = " impar ";
                        }
                        $i++;
                        foreach ($linha as $campo => $valor) {
                            $$campo = $valor == NULL ? "" : $valor;
                        }
                        $MAX_LETRAS = 30;
                        $listaUnidadesFuncionais[] = $unidade_funcional;
                        //$unidadesFuncionais[$unidade_funcional] = is_numeric($unidadesFuncionais[$unidade_funcional]) ? $unidadesFuncionais[$unidade_funcional] + 1 : 1;
                        //$situacoes[$situacao_leito] = is_numeric($situacoes[$situacao_leito]) ? $situacoes[$situacao_leito] + 1 : 1;
                        $listaSituacoes[] = $situacao_leito;
                        $nome = strlen($nome) > $MAX_LETRAS ? substr($nome, 0, $MAX_LETRAS - 3) . "..." : $nome;
                        $procedimento = strlen($procedimento) > $MAX_LETRAS ? substr($procedimento, 0, $MAX_LETRAS - 3) . "..." : $procedimento;
                        $uf = strlen($unidade_funcional) > $MAX_LETRAS ? substr($unidade_funcional, 0, $MAX_LETRAS - 3) . "..." : $unidade_funcional;
                        $dias_a_maior = $dias_internados ?? 0 - $dias_media_permanencia ?? 0;
                        echo "        <tr class=\"visivel $parImpar\">\n";
                        echo "            <td>$prontuario</td>\n";
                        echo "            <td class=\"quebravel\" title=\"$nome\">$nome</td>\n";
                        echo "            <td>$sexo</td>\n";
                        echo "            <td>$idade</td>\n";
                        echo "            <td>$leito</td>\n";
                        echo "            <td class=\"situacao\"><span class=\"" . strtolower($situacao_leito) . "\">$situacao_leito</span></td>\n";
                        echo "            <td class=\"tipo\">$tipo_leito</td>\n";
                        echo "            <td>$clinica</td>\n";
                        echo "            <td title=\"$unidade_funcional\" class=\"uf\">$uf</td>\n";
                        echo "            <td>$codigo_procedimento</td>\n";
                        echo "            <td title=\"$procedimento\">$procedimento</td>\n";
                        echo "            <td>$data_internacao</td>";
                        echo "            <td>$dias_media_permanencia</td>\n";
                        echo "            <td>$dias_internados</td>\n";
                        echo "            <td>$dias_a_maior</td>";
                        echo "            <td>$data_previsao_alta</td>";
                        echo "        </tr>\n";
                    } //foreach ($dados)
                    $listaSituacoes = array_unique($listaSituacoes);
                    $listaUnidadesFuncionais = array_unique($listaUnidadesFuncionais);
                    sort($listaSituacoes);
                    sort($listaUnidadesFuncionais);
                    ?>
                </tbody>
            </table>
        </fieldset>
    </div>
</div>

<div id="botao-topo" class="fixed-action-btn">
    <a class="btn-floating btn-large <?php
    global $corSistema;
    echo $corSistema
    ?>">
        <i class="large material-icons">file_upload</i>
    </a>
</div>

#{scriptPagina}
<script type="text/javascript" src="/relator/view/Relatorios/layouts/mapa-leitos.js"></script>
<script type="text/javascript" src="/static/highcharts/code/highcharts.js"></script>
<script type="text/javascript" src="/static/tablesorter/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
<?php
echo '        var unidadesFuncionais = ' . json_encode($listaUnidadesFuncionais) . ";\n";
echo '        var situacaosLeitos = ' . json_encode($listaSituacoes) . ";\n";
echo '        var situacoes = ' . json_encode($listaSituacoes) . "; \n";
?>
    $(document).ready(function () {
        var $optionsUnidadesFuncionais = "<option value=\"todos\">Todos</option>\n";
        for (var uf in unidadesFuncionais) {
            $optionsUnidadesFuncionais += "<option value=\"" + unidadesFuncionais[uf] + "\">" + unidadesFuncionais[uf] + "</option>\n";
        }

        var $optionsSituacoesLeito = "<option value=\"todos\">Todos</option>\n";
        for (var sl in situacaosLeitos) {
            $optionsSituacoesLeito += "<option value=\"" + situacaosLeitos[sl] + "\">" + situacaosLeitos[sl] + "</option>\n";
        }

        $("#unidades-funcionais").html($optionsUnidadesFuncionais);
        $("#situacao-leitos").html($optionsSituacoesLeito);
        $("#unidades-funcionais").val("todos");
        $("#situacao-leitos").val("todos");
        $("select").material_select();

        $("#botao-filtrar").click(function () {
            $("select").material_select();
            var $series = new Array();
            var $seriesTipo = new Array();

            valUF = $("#unidades-funcionais").val();
            valSituacao = $("#situacao-leitos").val();
            filtros = {
                uf: valUF,
                situacao: valSituacao
            };
            //esconde a tabela
            $("table").fadeOut();
            $("table tbody tr").removeClass("par impar visivel").fadeOut();
            //adicionar classe 'visivel-{filtro}' para cada célula filtrada
            for (var filtro in filtros) {
                console.log("Filtro... " + filtro);
                for (var i in filtros[filtro]) {
                    console.log("    - i: " + i);
                    valorFiltroAtual = filtros[filtro][i];
                    console.log("    valorFiltroAtual: (" + filtro + ") => " + valorFiltroAtual);
                    if (valorFiltroAtual === "todos") {
                        $("." + filtro).closest("tr").addClass("visivel-" + filtro);
                    } else {
                        $("." + filtro)
                                .filter(function () {
                                    return $(this).text().indexOf(valorFiltroAtual) === 0;
                                })
                                .closest("tr")
                                .addClass("visivel-" + filtro);
                    }
                }
            } // for var filtro

            $totalLinhas = $(".visivel-uf.visivel-situacao").length;
            $("#total-linhas").text(
                    $totalLinhas = 0 ? " - Nenhum registro" : ($totalLinhas === 1 ? (" - 1 registro") : (" - " + $totalLinhas + " registros"))
                    );
            $(".visivel-uf.visivel-situacao").addClass("visivel").removeClass("visivel-uf visivel-situacao");

            $filtrados = {};
            $tipos = {};

            $(".visivel").each(function (i, e) {
                //faz a contagem do total de linhas em cada situação
                $(this).find(".situacao").each(function (i, e) {
                    $nomeSituacao = $(this).text();
                    //se for o primeiro encontrado para a situação atual
                    if (typeof $filtrados[$nomeSituacao] === "undefined") {
                        $filtrados[$nomeSituacao] = 1;
                    } else {
                        $filtrados[$nomeSituacao] = $filtrados[$nomeSituacao] + 1;
                    }
                });

                //faz a contagem de cada tipo de leito
                $(this).find(".tipo").each(function (i, e) {
                    $nomeTipo = $(this).text();
                    //se for o primeiro tipo encontrado
                    if (typeof $tipos[$nomeTipo] === "undefined") {
                        $tipos[$nomeTipo] = 1;
                    } else {
                        $tipos[$nomeTipo] = $tipos[$nomeTipo] + 1;
                    }
                }); // final da contegem de tipos
            }); // $(".visivel").each()

            for (var f in $filtrados) {
                $classe = ("serie-" + f).toLowerCase();
                $series.push({
                    name: f,
                    y: $filtrados[f],
                    className: $classe
                })
            }

            for (var t in $tipos){
                $classe = ("tipo-" + t).toLowerCase();
                $seriesTipo.push({
                    name: t,
                    y: $tipos[t],
                    className: $classe
                })
            }
            $("table").fadeIn();
            if ($("table tbody tr.visivel").length === 0) {
                $("table tbody").append("<tr><td colspan=\"14\"><span class=\"info-span\">Nenhum registro encontrado!</span></td></tr>");
            } else {
                $("table tbody tr.visivel").fadeIn();
            } // else 
            $(".visivel").each(function (i) {
                if (i % 2 === 0) {
                    $(this).addClass("par");
                } else {
                    $(this).addClass("impar");
                }
            });
            //constriur gráficos
            Highcharts.chart('grafico-leitos', {

                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: null
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        //showInLegend: true,
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                        name: 'Situação',
                        colorByPoint: true,
                        data: $series //Dados
                    }]
            }); // gráfico leitos

            //gráfico tipo leitos
            Highcharts.chart('grafico-tipo-leitos', {

                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: null
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        //showInLegend: true,
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                        name: 'Tipo',
                        colorByPoint: true,
                        data: $seriesTipo //Dados
                    }]
            });


            //fim gráficos
        }); // #botao-filtrar.click()

        $("#botao-limpar").click(function () {
            $("#unidades-funcionais").val("todos");
            $("#situacao-leitos").val("todos");
            $("select").material_select();
            $("#botao-filtrar").click();
        });

        $("table").tablesorter({
            headers: {
                0: {sorter: false},
                1: {sorter: false},
                2: {sorter: false},
                3: {sorter: false},
                4: {sorter: false}
            }
        });
        $("#botao-topo").click(function () {
            $('html, body').animate({scrollTop: 0}, 1000);
        });
        $("fieldset").animate({"opacity": "1"});
        window.setTimeout(function () {
            $("#alerta-need-update").fadeIn();
        }, 60000);
        $("#botao-limpar").click();
        $(window).scroll(function () {
            if ($(this).scrollTop() > $("table").position().top) {
                $("#botao-topo").fadeIn();
            } else {
                $("#botao-topo").fadeOut();
            }
        });
    });

</script>
#{/scriptPagina}
