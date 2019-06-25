#{stylesPagina}
<style>
    body{
        margin-top: 0!important;
    }
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

    .serie-ocupado{ fill: red; }
    .serie-desocupado{ fill: green; }
    .serie-limpeza{ fill: lightblue }
    .serie-reservado{ fill: darkblue; }
    .serie-patologia{ fill: #FF69B4; }
    .serie-vaga{ fill: #FFC107; }
    .serie-manutencao { fill: black}
    
    nav , div.chip, footer{
        display: none;
    }
    
    table{
        width: 100%;
        height: 100%;
    }
</style>

#{/stylesPagina}

<div class="titulo">
    <strong>Mapa de Leitos: <?= $dados[0]['unidade_funcional'] ?></strong>
</div>

<div class="content">
    <div class="corpo">
        <fieldset>
            <table class="bordered responsive-table">
                <thead>
                    <tr>
                        <th colspan="3">Leito</th>
                        <th colspan="4" class="mesclada">Paciente</th>
                        <th rowspan="2" class="mesclada">Município</th>
                        <!-- th>Clínica</th -->
                        <th rowspan="2" class="mesclada">Data</th>
                        <th rowspan="2" class="mesclada">Dias Int.</th>
                    </tr>
                    <tr>
                        <th>Número</th>
                        <th>Situação</th>
                        <th>Tipo</th>
                        <th>Prontuário</th>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Idade</th>
                        <!-- th>Unidade Funcional</th -->
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
                        if(!$idade && $nome){
                            $idade = "0";
                        }
                        $municipio = $cidade; 
                        if(!$municipio && !$nome){
                            $municipio = "";
                        }
                        echo "        <tr class=\"visivel $parImpar\">\n";
                        echo "            <td>$leito</td>\n";
                        echo "            <td class=\"situacao\"><span class=\"" . strtolower($situacao_leito) . "\">$situacao_leito</span></td>\n";
                        echo "            <td class=\"tipo\">$tipo_leito</td>\n";
                        echo "            <td>$prontuario</td>\n";
                        echo "            <td class=\"quebravel\" title=\"$nome\">$nome</td>\n";
                        echo "            <td>$sexo</td>\n";
                        echo "            <td>$idade</td>\n";
                        echo "            <td>$municipio</td>";
                        //echo "            <td>$clinica</td>\n";
                        //echo "            <td title=\"$unidade_funcional\" class=\"uf\">$uf</td>\n";
                        echo "            <td>$data_internacao</td>";
                        echo "            <td>$dias_internados</td>\n";
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

#{scriptPagina}
<script type="text/javascript">
    $(document).ready(function(){
        window.setTimeout(function(){
            window.location.reload(true);
        }, 60*1000)
    })
</script>
#{/scriptPagina}