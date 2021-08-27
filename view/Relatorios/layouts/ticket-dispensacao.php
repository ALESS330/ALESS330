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
    <td>
</tr>
</script>

#{scriptPagina}
<script type="text/javascript"> 
    $(document).ready(function(){
        const paciente = <?= json_encode($paciente)?>;
        const medicamentos = <?= json_encode($medicamentos)?>;

        const linhas = $("#tabela-medicamentos-tmpl").render(medicamentos);
        console.log(linhas);
        $("#tabela-medicamentos tbody").append(linhas);
    });
</script>
#{/scriptPagina}