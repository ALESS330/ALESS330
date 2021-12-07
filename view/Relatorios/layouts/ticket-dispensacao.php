#{botoes}
<div class="fixed-action-btn no-print">
    <button class="btn-floating btn-large red" id="bt-imprimir"
        title="Imprimir">
        <i class="material-icons">local_printshop</i>
    </button>
</div>
#{/botoes}
<?php
    $paciente['nome'] = $dados[0]['nome_paciente'];
    $paciente['prontuario'] = $dados[0]['prontuario'];
    $paciente['unidade_funcional'] = $dados[0]['unidade_funcional'];
    $medicamentos = array_map(function($medicamento){
        $saida = array();
        $saida['medicamento'] = $medicamento['descricao_medicamento'];
        $saida['codigo_medicamento'] = $medicamento['codigo_medicamento'];
        $saida['qtde_24h'] = $medicamento['qtde_calc_sist_24h'];
        $saida['frequencia'] = $medicamento['frequencia'];
        $saida['tipo_frequencia'] = $medicamento['tipo_frequencia'];
        $saida['dose'] = $medicamento['dose'];
        $saida['unidade_medida'] = $medicamento['unidade_medida'];
        return $saida;
    }, $dados);

    //echo "<pre>"; print_r($medicamentos);
?>

<style>
    @media print {
            @page { 
                margin: 0; 
                size: 297mm 210mm;
            }
            body {
                margin-top: 10mm;
                margin-bottom: 10mm;
                font-size: 10pt;
            }

            div#pagina{
                padding: 4mm !important;
            }

            .no-print {
                display: none;
            }

            div#pagina>div.periodo{
                text-align: left;
                font-size: 8pt;
                border: solid 1px black !important;
                margin-left: 3px;
                margin-right: 3px;
                border-radius: 3px;
            }
            div#pagina>div.periodo table tbody tr td{
                padding: 1mm !important;
            }
            
            table tr:not(:last-child){
                border-bottom: solid 1px black !important;
            }
        }/* @media */ 

    div#pagina{
        display: grid;
        grid-template-columns: auto auto auto;
        padding: 10px;
    }

    div.texto-dispensar{
        font-size: 8pt;
    }

    div.texto-dispensar span{
        font-size: 9pt;
    }

    div#pagina>div.periodo{
        text-align: left;
        padding: 4px;
        border: solid 1px black;
        margin-left: 3px;
        margin-right: 3px;
        border-radius: 3px;
    }

    .concluido{
        background-color: #c8e6c9 ;
    }

    .pendente{
        background-color: #ffcdd2;
    }
</style>

<table id="tabela-medicamentos">
    <thead>
        <tr>
            <th>Medicamento</th>
            <th>Quantidade para 24h</th>
            <th>Frequencia</th>
            <th>Dose</th>
            <th title="Manhã" style="width: 75px;">🌅</th>
            <th title="Tarde" style="width: 75px;">🌤</th>
            <th title="Noite" style="width: 75px;">🌛</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<div id="pagina">
    <div id="manha" class="periodo">
        <strong>Período de dispensação: Manhã</strong>
        <div class="dados-paciente">
            <div class="nome-prontuario-paciente"></div>
            <div class="unidade-funcional"></div>
        </div>
        <table id="tb-manha">
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Quantidade</th>
                    <th>Frequência</th>
                    <th>Dose</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <div id="tarde" class="periodo">
        <strong>Período de dispensação: Tarde</strong>
        <div class="dados-paciente">
            <div class="nome-prontuario-paciente"></div>
            <div class="unidade-funcional"></div>
        </div>
        <table id="tb-tarde">
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Quantidade</th>
                    <th>Frequência</th>
                    <th>Dose</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>        
    </div>

    <div id="noite" class="periodo">
        <strong>Período de dispensação: Noite</strong>
        <div class="dados-paciente">
            <div class="nome-prontuario-paciente"></div>
            <div class="unidade-funcional"></div>
        </div>
        <table id="tb-noite">
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Quantidade</th>
                    <th>Frequência</th>
                    <th>Dose</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>


<script type="text/x-jsrender" id="tabela-medicamentos-tmpl">
<tr class="pendente">
    <td>{{:medicamento}}
        <input type="hidden" value="{{:codigo_medicamento}}" />
    </td>
    <td>
        <div class="quantidade">{{:qtde_24h}}</div> 
        <div class="texto-dispensar">A dispensar: <span class='qtde-restante'>{{:qtde_24h}}</span>
        </div>
    </td>
    <td>{{:frequencia}} {{:tipo_frequencia}}</td>
    <td>{{:dose}} {{:unidade_medida}}</td>
    <td>
        <p title="Quantidade de {{:medicamento}} no ticket da Manhã">
        <label>
            <input type="number" min="0" max="{{:qtde_24h}}" class="qtde-manha quantidade"/>
            <span></span>
        </label>
        </p>
    </td>
    <td>    
        <p title="Quantidade de {{:medicamento}} no ticket da Tarde">
        <label>
            <input type="number" min="0" max="{{:qtde_24h}}" class="qtde-tarde quantidade"/>
            <span></span>
        </label>
        </p>        
    </td>
    <td>            
        <p title="Quantidade de {{:medicamento}} no ticket da Noite">
        <label>
            <input type="number" min="0" max="{{:qtde_24h}}" class="qtde-noite quantidade"/>
            <span></span>
        </label>
        </p>        
    </td>
</tr>
</script>

<script type="text/x-jsrender" id="tabela-periodo-tmpl">
<tr>
    <td>{{:medicamento}}</td>
    <td>{{:quantidade}}</td>
    <td>{{:frequencia}} {{:tipo_frequencia}}</td>
    <td>{{:dose}}</td>
</tr>
</script>

#{scriptPagina}
<script type="text/javascript"> 
    
    const periodos = {
            manha: {}
            , tarde: {}
            , noite: {}
        };

    $(document).ready(function(){

        function makeTickets(){
            Object.entries(periodos)
                  .map(function(elemento){
                        medicamentosPeriodo = Object.entries(elemento[1]).map(function(medicamento){
                            return medicamento[1];
                        });
                    const linhas = $("#tabela-periodo-tmpl").render(medicamentosPeriodo);
                    const periodo = elemento[0];
                    const seletorTabela = `#tb-${periodo} tbody`;
                    $(seletorTabela).empty().append(linhas);
            });//map (elemento)
        }

        const paciente = <?= json_encode($paciente)?>;
        const medicamentos = <?= json_encode($medicamentos)?>;

        const linhas = $("#tabela-medicamentos-tmpl").render(medicamentos);
        
        $("#tabela-medicamentos tbody").append(linhas);

        $(".nome-prontuario-paciente").html(`${paciente.prontuario} - ${paciente.nome}`);
        $(".unidade-funcional").html(paciente.unidade_funcional);

        $("#bt-imprimir").on('click', function(){
            makeTickets();
            $("#tabela-medicamentos").hide();
            window.print();
        });

        $("table").on("input", "input.quantidade", function(e){
            const estaLinha = $(this).closest("tr");
            const esteCodigoMedicamento = estaLinha.find(":hidden").val();
            const esteMedicamento = estaLinha.find("td").eq(0).text().trim();
            const estaQuantidade = estaLinha.find("td").eq(1).find(".quantidade").text().trim();
            const spanDisponivel = estaLinha.find("td").eq(1).find(".qtde-restante")

            const estaManha = estaLinha.find(".qtde-manha")
            const estaTarde = estaLinha.find(".qtde-tarde")
            const estaNoite = estaLinha.find(".qtde-noite")

            const estaFrequencia = estaLinha.find("td").eq(2).text().trim();
            const estaDose = estaLinha.find("td").eq(3).text().trim();

            let totalJaUsado = +estaManha.val() + +estaTarde.val() + +estaNoite.val()
            let estaQuantidadeDisponivel = estaQuantidade - totalJaUsado
            
            if(totalJaUsado == estaQuantidade){
                estaLinha.addClass("concluido").removeClass("pendente")
            }else{
                estaLinha.addClass("pendente").removeClass("concluido")
            }

            const manha = $(this).hasClass("qtde-manha");
            const tarde = $(this).hasClass("qtde-tarde");
            const noite = $(this).hasClass("qtde-noite");

            estaQuantidadeSelecionada = $(this).val();
            spanDisponivel.text(estaQuantidadeDisponivel)

            const medicamentoSelecionado = {
                medicamento : esteMedicamento
                , quantidade : estaQuantidadeSelecionada
                , frequencia : estaFrequencia
                , dose : estaDose
            }
            const removendo = estaQuantidadeSelecionada == 0;
            var alvo = {}; 

            if(manha){
                alvo = periodos.manha;
            }
            if(tarde){
                alvo = periodos.tarde;
            }
            if (noite){
                alvo = periodos.noite;
            }

            if(removendo){
                delete alvo[esteCodigoMedicamento];
            }else{
                alvo[esteCodigoMedicamento] = medicamentoSelecionado;
            }
            if (estaQuantidadeDisponivel <= 0){
                e.preventDefault();
                makeTickets();
            }else{
                makeTickets();
            }
            
        });//evento input dos elementos de numero

        $(":checkbox").click()

    });
</script>
#{/scriptPagina}