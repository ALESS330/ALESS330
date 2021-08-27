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
    div#pagina{
        display: grid;
        grid-template-columns: auto auto auto;
        padding: 10px;
    }

    div#pagina>div.periodo{
        text-align: left;
        padding: 4px;
        border: solid 1px black;
        margin-left: 3px;
        margin-right: 3px;
        border-radius: 3px;
    }
</style>

<table id="tabela-medicamentos" class="striped highlight">
    <thead>
        <tr>
            <th>Medicamento</th>
            <th>Quantidade para 24h</th>
            <th>Frequencia</th>
            <th>Dose</th>
            <th title="Manhã">🌅</th>
            <th title="Tarde">🌤</th>
            <th title="Noite">🌛</th>
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
<tr>
    <td>{{:medicamento}}
        <input type="hidden" value="{{:codigo_medicamento}}" />
    </td>
    <td>{{:qtde_24h}}</td>
    <td>{{:frequencia}} {{:tipo_frequencia}}</td>
    <td>{{:dose}} {{:unidade_medida}}</td>
    <td>
        <p title="Exibir {{:medicamento}} no ticket da Manhã">
        <label>
            <input type="checkbox" class="ck-manha"/>
            <span></span>
        </label>
        </p>
    </td>
    <td>    
        <p title="Exibir {{:medicamento}} no ticket da Tarde">
        <label>
            <input type="checkbox" class="ck-tarde"/>
            <span></span>
        </label>
        </p>        
    </td>
    <td>            
        <p title="Exibir {{:medicamento}} no ticket da Noite">
        <label>
            <input type="checkbox" class="ck-noite"/>
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
        });

        $("table").on("click", ":checkbox", function(){
            const estaLinha = $(this).closest("tr");
            const esteCodigoMedicamento = estaLinha.find(":hidden").val();
            const esteMedicamento = estaLinha.find("td").eq(0).text().trim();
            const estaQuantidade = estaLinha.find("td").eq(1).text().trim();
            const estaFrequencia = estaLinha.find("td").eq(2).text().trim();
            const estaDose = estaLinha.find("td").eq(3).text().trim();
            const manha = $(this).hasClass("ck-manha");
            const tarde = $(this).hasClass("ck-tarde");
            const noite = $(this).hasClass("ck-noite");

            const medicamentoSelecionado = {
                medicamento : esteMedicamento
                , quantidade : estaQuantidade
                , frequencia : estaFrequencia
                , dose : estaDose
            }
            const removendo = !$(this).prop("checked");
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
            makeTickets();
        });//evento clique das checkboxes



    });
</script>
#{/scriptPagina}