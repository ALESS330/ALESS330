<?php
//$jsonDadosTabela = json_encode($dados);
?>
<style>
    table{
        font-size: 10pt;
        width: 100%;
    }
    table thead th {
        padding: 1px  5px;
        border: solid 1px silver;
        text-align: center;
    }
    .container{
        width: 98%;
        max-width: 100%;
        margin: 1%;
    }
    .fixed-action-btn{
        display: none;
    }
    div.corpo{
        width: 100%;
        padding: 0;
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

    .cards fieldset{
        /* height: 200px; */
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
    .serie-ocupado{ fill: red; }
    .serie-desocupado{ fill: green; }
    .serie-limpeza{ fill: lightblue }
    .serie-reservado{ fill: darkblue; }
    .serie-patologia{ fill: #FF69B4; }
    .serie-vaga{ fill: #FFC107; }
    .serie-manutencao { fill: black}

    #grafico-leitos{
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

</style>
<div class="titulo">
    <span id="alerta-need-update">Atenção! Dados carregados a mais de 60 segundos!</span>
    <strong>Mapa de Leitos</strong>
</div>
<div class="cards">
    <div class="row">
        <div class="col s6 filtros">
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

        <div class="col s6 leitos">
            <fieldset>
                <legend>Leitos <span id="total-linhas"></span></legend>
                <div id="grafico-leitos">

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
                        <th rowspan="2">Dias Previstos</th>
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
                    $i = 0;
                    foreach ($dados as $linha) {
                        if ($i % 2 === 0) {
                            $parImpar = " par ";
                        } else {
                            $parImpar = " impar ";
                        }
                        $i++;
                        foreach ($linha as $campo => $valor) {
                            $$campo = $valor == NULL ? " - " : $valor;
                        }
                        $unidadesFuncionais[$unidade_funcional] = is_numeric($unidadesFuncionais[$unidade_funcional]) ? $unidadesFuncionais[$unidade_funcional] + 1 : 1;
                        $situacoes[$situacao_leito] = is_numeric($situacoes[$situacao_leito]) ? $situacoes[$situacao_leito] + 1 : 1;
                        echo "        <tr class=\"visivel $parImpar\">\n";
                        echo "            <td>$prontuario_paciente</td>\n";
                        echo "            <td>$nome_paciente</td>\n";
                        echo "            <td>$sexo</td>\n";
                        echo "            <td>$idade</td>\n";
                        echo "            <td>$leito</td>\n";
                        echo "            <td class=\"situacao\"><span class=\"" . strtolower($situacao_leito) . "\">$situacao_leito</span></td>\n";
                        echo "            <td>$tipo_leito</td>\n";
                        echo "            <td>$clinica</td>\n";
                        echo "            <td class=\"uf\">$unidade_funcional</td>\n";
                        echo "            <td>$procedimento_codigo</td>\n";
                        echo "            <td>$procedimento_descricao</td>\n";
                        echo "            <td>$data_internacao</td>";
                        echo "            <td>$dias_media_permanencia</td>\n";
                        echo "            <td>$dias_previstos_internacao</td>\n";
                        echo "        </tr>\n";
                    } //foreach ($dados)
                    $listaSituacoes = array_keys($situacoes);
                    sort($listaSituacoes);
                    $listaUnidadesFuncionais = array_keys($unidadesFuncionais);
                    sort($listaUnidadesFuncionais);
                    ?>
                </tbody>
            </table>
        </fieldset>
    </div>
</div>

#{scriptPagina}
<script type="text/javascript" src="/relator/view/Relatorios/layouts/mapa-leitos.js"></script>
<script type="text/javascript" src="/static/highcharts/code/highcharts.js"></script>
<script type="text/javascript">
<?php
echo '        var unidadesFuncionais = ' . json_encode($listaUnidadesFuncionais) . ";\n";
echo '        var situacaosLeitos = ' . json_encode($listaSituacoes) . ";\n";
echo '        var situacoes = ' . json_encode($situacoes) . "; \n";
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
            var $series = new Array();
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

            $(".visivel").each(function (i, e) {
                $(this).find(".situacao").each(function (i, e) {
                    $nomeSituacao = $(this).text();
                    if (typeof $filtrados[$nomeSituacao] === "undefined") {
                        $filtrados[$nomeSituacao] = 1;
                    } else {
                        $filtrados[$nomeSituacao] = $filtrados[$nomeSituacao] + 1;
                    }
                });
            });
            for (var f in $filtrados) {
                $classe = ("serie-" + f).toLowerCase();
                $series.push({
                    name: f,
                    y: $filtrados[f],
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
            });

            //fim gráficos
        }); // #botao-aplicar.click()

        $("#botao-limpar").click(function () {
            $("#unidades-funcionais").val("todos");
            $("#situacao-leitos").val("todos");
            $("select").material_select();
            $("#botao-filtrar").click();
        });

        window.setTimeout(function () {
            $("#alerta-need-update").fadeIn();
        }, 60000);
        $("#botao-limpar").click();
    });

</script>
#{/scriptPagina}
