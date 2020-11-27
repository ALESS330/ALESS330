<?php 

    $classificacoes = array();
    $classificacoes[1] = 'Infecção Hospitalar (IRAS) – diagnosticada a partir de 48h de internação';
    $classificacoes[2] = 'Infecção da Comunidade – diagnosticada na admissão';
    $classificacoes[3] = 'Infecção Hospitalar de outro Hospital – paciente transferido de outro hospital';
    $classificacoes[4] = 'Infecção Transplacentária – acometimento intra-útero';
    $classificacoes[5] = 'Infecção Neonatal - IRAS Precoce – diagnóstico nas primeiras 48h de vida, com fator de risco materno para infecção';
    $classificacoes[6] = 'Infecção Neonatal - IRAS tardia – diagnóstico após 48h de vida';

    

    function resistenciasSelecionadas($valor){
        if($valor == '0,'){
            return [];
        }
        $resistencias = array();
        $resistencias[1] = 'Resistente à Oxacilina';
        $resistencias[2] = 'Resistente à Amicacina';
        $resistencias[4] = 'Resistente ao Cefepime';
        $resistencias[8] = 'Resistente ao Imipenem/Meropenem';
        $resistencias[16] = 'Resistente à Polimixina/Colistina';
        $resistencias[32] = 'Resistente à Vancomicina';
        $resistencias[64] = 'Resistente à Linezolida';
        $resistencias[128] = 'Não há resistência descrita'; 

        $valores = explode(",", $valor);
        $v = $valorinicial = array_shift($valores);
        $selecionados = array();
        foreach ($resistencias as $valorResistencia => $r) {
            if($v > $valorResistencia){
                $selecionados[] = $r;
                $v -= $valorinicial;
            }
        }
        if(count($valores)){
            foreach ($valores as $esteValor){
                $selecionados[] = $esteValor;
            }
        }
        return $selecionados;
    }//resistencias_selecionadas

    $vias["TB"] = "BUCAL";
    $vias["CA"] = "Caudal";
    $vias["TC"] = "Dermatológica";
    $vias["VD"] = "Dialisador";
    $vias["EV"] = "ENDOVENOSA";
    $vias["PD"] = "Epidural";
    $vias["VG"] = "GASTROSTOMIA";
    $vias["IN"] = "Inalatória";
    $vias["IO"] = "Inalatória ora";
    $vias["IA"] = "Intra-arterial";
    $vias["AR"] = "Intra-articula";
    $vias["ID"] = "Intra-dérmica";
    $vias["IM"] = "Intra-muscular";
    $vias["IP"] = "Intra-peritoni";
    $vias["IT"] = "Intra-tecal";
    $vias["TQ"] = "INTRATRAQUEAL";
    $vias["VV"] = "Intra-vaginal";
    $vias["IV"] = "INTRAVENOSA";
    $vias["BX"] = "Intra-vesical";
    $vias["VJ"] = "JEJUNOSTOMIA";
    $vias["VN"] = "Nasal";
    $vias["NE"] = "NASOENTERAL";
    $vias["NG"] = "NASOGASTRICA";
    $vias["OC"] = "Oftálmica";
    $vias["VO"] = "Oral";
    $vias["OT"] = "Otolóigica";
    $vias["PB"] = "Peribulbar";
    $vias["PN"] = "Perineural";
    $vias["VS"] = "Por Sonda";
    $vias["DD"] = "Pós-dialisador";
    $vias["AD"] = "Pré-dialisador";
    $vias["VR"] = "Retal";
    $vias["SC"] = "Subcutânea";
    $vias["SL"] = "Sublingual";
    $vias["TP"] = "TOPICO";
    $vias["TD"] = "Transdérmica";
    $vias["TR"] = "Traqueostomia";
    $vias["UR"] = "Uretral";

    $paciente = 
    $justificativas = 
    $antimicrobianos = 
    $pareceres =
    $antimicrobianosPareceres = 
    $prorrogacoes =
    $pareceresProrrogacoes =
    $excluosoes = null;

    $paciente = new stdClass();
    $paciente->prontuario = $dados[0]['prontuario'];
    $paciente->nome = $dados[0]['nome'];
    $paciente->sexo = $dados[0]['sexo'];
    
    $idJustificativaAtual = null;

    $justificativasComDuplicadas = array_map(function($l){
        $camposManter = [
            'idade'
            , 'unidade_funcional'
            , 'leito'
            , 'data_preenchimento'
            , 'preenchido_por'
            , 'clinico_cirurgico'
            , 'profilatico_terapeutico'
            , 'empirico_guiado'
            , 'diagnostico'
            , 'profilaxia_cirurgica'
            , 'classificacao_infeccao'
            , 'profilaxia_clinica'
            , 'uso_previo_antibioticos'
            , 'culturas_solicitadas'
            , 'cultura_positiva_atual'
            , 'bacteria_isolada'
            , 'amostra'
            , 'resistencias'
            , 'peso'
            , 'insuficiencia_renal'
            , 'clearence_creatina'            
        ];
        $j = new stdClass();
        $j->id = $l['justificativa_id'];
        foreach($camposManter as $c){
            $j->$c = $l[$c];
        }
        return $j;
    }, $dados);

    $antimicrobianosDuplicados = array_map(function($l){
        $camposManter = [
              'antimicrobiano_prescrito_id'
            , 'codigo_medicamento'
            , 'descricao_medicamento'
            , 'dose_prescrita'
            , 'posologia_prescrita'
            , 'intervalo_prescrito'
            , 'via_prescrita'
            , 'dias_propostos_prescritos'
            , 'suspenso' 
            , 'justificativa_id'                       
        ];

        $a = new stdClass();
        $a->id = $l['antimicrobiano_prescrito_id'];
        foreach($camposManter as $c){
            $a->$c = $l[$c];
        }

        return $a;
    }, $dados);

    foreach($antimicrobianosDuplicados as $atbD){
        $antimicrobianos[$atbD->justificativa_id][$atbD->id] = $atbD;
    }

    $pareceresDuplicados = 
    array_map(function($l) {
        if(!$l['parecer_id']){
            return false;
        }
        $p = new stdClass();
        $p->id = $l['parecer_id'];
        $p->conteudo_parecer = $l['conteudo_parecer'];
        $p->data_hora_parecer = $l['data_hora_parecer'];
        $p->responsavel_parecer = $l['responsavel_parecer'];
        $p->justificativa_id = $l['justificativa_id'];
        return $p;
    }
    ,$dados);

    foreach($pareceresDuplicados as $p){
        if(!$p){
            continue;
        }
        $pareceres[$p->justificativa_id] = $p;
    }

    $antimicrobianosPareceresDuplicados = array_map(function($l){
        if(!$l['antimicrobiano_parecer_id']){
            return false;
        }
        $ap = new stdClass();

        $ap->id = $l['antimicrobiano_parecer_id'];
        $ap->antimicrobiano_parecer_id = $l['antimicrobiano_parecer_id'];
        $ap->parecer_id = $l['parecer_id'];
        $ap->antimicrobiano_prescrito_id = $l['antimicrobiano_prescrito_id'];
        $ap->dose_parecer = $l['dose_parecer'];
        $ap->via_parecer = $l['via_parecer'];
        $ap->intervalo_parecer = $l['intervalo_parecer'];
        $ap->duracao_parecer = $l['duracao_parecer'];
        $ap->alterado = $l['alterado'];
        $ap->autorizacao = $l['autorizacao'];

        return $ap; 
    }, $dados);

    foreach($antimicrobianosPareceresDuplicados as $apd){
        if(!$apd){
            continue;
        }
        $antimicrobianosPareceres[$apd->antimicrobiano_prescrito_id] = $apd;
    }

    $prorrogacoes = array_map(function($l){

        if(!$l['prorrogacao_id']){
            return false;
        }
        $p = new stdClass();
        $p->id = $l['prorrogacao_id'];
        $p->prorrogacao_id = $l['prorrogacao_id'];
        $p->dias_solicitados_prorrogacao = $l['dias_solicitados_prorrogacao'];
        $p->observacao_prorrogacao = $l['observacao_prorrogacao'];
        $p->usuario_prorrogacao = $l['usuario_prorrogacao'];
        $p->data_solicitacao_prorrogacao = $l['data_solicitacao_prorrogacao'];
        $p->antimicrobiano_prescrito_id = $l['antimicrobiano_prescrito_id'];
        $p->parecerProrrogacao = null;
        return $p;
    }, $dados);

    $pareceresProrrogacoes = array_map((function($l){
        
        if(!$l['parecer_prorrogacao_id']){
            return false;
        }
        $pp = new stdClass();

        $pp->id = $l['parecer_prorrogacao_id'];
        $pp->prorrogacao_id = $l['prorrogacao_id'];
        $pp->parecer_prorrogacao_id = $l['parecer_prorrogacao_id'];
        $pp->autorizacao_prorrogacao = $l['autorizacao_prorrogacao'];
        $pp->data_parecer_prorrogacao = $l['data_parecer_prorrogacao'];
        $pp->dias_parecer_prorrogacao = $l['dias_parecer_prorrogacao'];
        $pp->responsavel_parecer_prorrogacao = $l['responsavel_parecer_prorrogacao'];

        return $pp;
    }), $dados);

    $exclusoesDuplicadas = array_map(function($l){
        if(!$l['exclusao_id']){
            return false;            
        }

        $e = new stdClass();
        $e->id = $l['exclusao_id'];
        $e->exclusao_id = $l['exclusao_id'];
        $e->antimicrobiano_prescrito_id = $l['antimicrobiano_prescrito_id'];
        $e->motivo_exclusao = $l['motivo_exclusao'];
        $e->data_hora_exclusao = $l['data_hora_exclusao'];
        $e->observacao_exclusao_id = $l['observacao_exclusao_id'];
        $e->conteudo_observacao_exclusao = $l['conteudo_observacao_exclusao'];
        $e->responsavel_exclusao = $l['responsavel_exclusao'];

        return $e;
    }, $dados);

    foreach ($exclusoesDuplicadas as $e) {
        if(!$e) continue;
        $excluosoes[$e->antimicrobiano_prescrito_id] = $e;
    }

    unset($dados);

    foreach($prorrogacoes as $p){
        if(!$p){
            continue; 
        }
        $ppDuplicados = array_filter($pareceresProrrogacoes, function($pp) use ($p){
                if($pp){
                    return $pp->prorrogacao_id == $p->id;
                }
                return false;
            });
        $p->parecerProrrogacao = array_shift($ppDuplicados);
    }

    
    foreach($antimicrobianos as $justificativaId => $listaAtbs){
        foreach($listaAtbs as $a){
            $a->antimicrobianoParecer = $antimicrobianosPareceres[$a->id] ?? false;
            $a->prorrogacoes = array_filter($prorrogacoes, function($p) use ($a){
                if($p){
                    return $p->antimicrobiano_prescrito_id == $a->id; 
                }
                return false;
            });
            $a->exclusoes = $excluosoes[$a->id] ?? []; 
        }//foreach
    }//foreach

    $justificativasIds = array_unique(array_map(function($j){
        return $j->id; 
    }, $justificativasComDuplicadas));
    
    while(count($justificativasIds) >0){
        $esteId = array_shift($justificativasIds);
        $duplicadas = array_filter($justificativasComDuplicadas, function($j) use ($esteId){
            return $j->id == $esteId;
        });
        $j = array_shift($duplicadas);
        $j->antimicrobianosPrescritos = $antimicrobianos[$j->id];
        $j->parecer = $pareceres[$j->id] ?? [];
        $justificativas[] = $j;
    }

    $esteEsta = ($paciente->sexo == 'Masculino') ? 'este' : 'esta';
    $contadorJustificativas = count($justificativas);
    $textoTotal = $contadorJustificativas == 1 ? "Existe uma justificativa cadastrada para $esteEsta paciente" : "Existem " . $contadorJustificativas . " justificativas cadastradas para $esteEsta paciente";

?>
<style type="text/css">

    div.dados-relatorio{
        margin: 0 auto;
        width: 210mm;
    }

    div.dados-relatorio div:not(.grupo-info) {
        padding: 5mm;
        border-radius: 5px;
        border: solid 1px silver;
    }

    div.justificativa{
        border-radius: 5mm;
        border: solid 1px sivler; 
        margin: 5px ;
        padding: 3px;
    }

    div.paciente {
        background-color: #dddddd;
    }

    div.grupo-info h6{
        border-bottom: solid 1px silver;
    }

    li{
        margin-bottom: 2px;
    }

    tr.parecer td{ 
        font-weight: normal;
        margin-top: 2px;
        border-top: solid 5px white;
        background-color: #eeeeee;
    }

    span.alterado:before{
        content: '(';
    }
    
    blockquote ul{
        font-size: 14px;
    }

    span.alterado:after{
        content: ')';
    }
    
    span.alterado{
        text-decoration: line-through;
    }

    table{
        font-size: 12px;
    }

    table tbody tr, table tbody tr td{
        height: 32px !important;
        padding: 1px !important;
    }

    table tr.impar{
        background-color: #eeeeee;
    }
</style>

    <div class="dados-relatorio">


    <h4 class="center">Relatório de antimicrobianos</h4>

    <div class="paciente">
        <h5>Paciente</h5>
        <ul>
            <li><strong>Prontuário: </strong><?= $paciente->prontuario?></li>
            <li><strong>Nome: </strong><?= $paciente->nome?></li>
            <li><strong>Sexo: </strong><?= $paciente->sexo?></li>
        </ul>
    </div>

    <h5 class="center">Justificativas cadastradas</h5>
    <p class="center explicacao-breve"><small><?= $textoTotal ?></small></p>

        <?php 
        foreach($justificativas as $i => $j){
            $resistenciasCadastradas = resistenciasSelecionadas($j->resistencias);
            echo '<div class="justificativa">';
            if(count($justificativas) >= 1){
                //echo "<h6> " . ($i+1) ."ª justificativa <small>#($j->id)</small><h6>\n";
                echo "<p>Justificativa preenchida em $j->data_preenchimento, por $j->preenchido_por</p>";
            } ?>

        <blockquote>
            <ul>
                <li><strong>Unidade Funcional: </strong><?= $j->unidade_funcional?></li>
                <li><strong>Leito: </strong><?= $j->leito?></li>
                <li><strong>Idade do paciente <small>(no momento da justificativa)</small>: </strong><?= $j->idade?></li>
            </ul>
        </blockquote>
        
        <h6>Indicação do antimicrobiano</h6>
        <blockquote>
            <ul>
                <li><?= $j->clinico_cirurgico == 'clinico' ? 'Clínico' : 'Cirúrgico'?></li>
                <li><?= $j->profilatico_terapeutico == 'terapeutico' ? 'Terapeutico' : 'Profilático'?></li>
                <li><?= $j->empirico_guiado == 'empirico' ? 'Empírico' : 'Guiado'?></li>
            </ul>
        </blockquote>
        

        <blockquote>
            <ul>
                <li><strong>Diagnóstico: </strong><?= $j->diagnostico?></li>
                <li><strong>Classificação da infecção: </strong><?= $classificacoes[$j->classificacao_infeccao] ?></li>
                <?php if($j->profilaxia_cirurgica){?>
                    <li><strong>Profilaxia cirúrgica: </strong><?= $j->profilaxia_cirurgica?></li>
                <?php } ?>
                <?php if($j->profilaxia_clinica){?>
                    <li><strong>Profilaxia clínica: </strong><?= $j->profilaxia_clinica?></li>
                <?php } ?>            
                <li><strong>Uso prévio de antibióticos: </strong><?= $j->uso_previo_antibioticos ?></li>
                <li><strong>Culturas solicitadas: </strong> <?= $j->culturas_solicitadas?></li>
                <?php 
                    if($j->cultura_positiva_atual){
                        echo "<li><strong>Culturas positiva atual: </strong>Sim</li>";
                        $bacteria = strlen(trim($j->bacteria_isolada)) > 0  ? $j->bacteria_isolada : ' (sem informação cadastrada)';
                        echo "<li><strong>Bacteria isolada: </strong>$bacteria</li>";
                    }else{
                        echo "<li><strong>Culturas positiva atual: </strong>Não</li>";
                    }
                ?>
                <li><strong>Amostra: </strong><?= strlen(trim($j->amostra)) > 0 ? $j->amostra : '(sem informação cadastrada)' ?></li>
                <li><strong>Resistências: </strong><?php 
                    if(count($resistenciasCadastradas) == 0){
                        echo "(sem informação cadastrada)";
                    }else{
                        echo "<ul>\n";
                        foreach($resistenciasCadastradas as $r){
                            echo "<li>&nbsp;&nbsp;&nbsp;$r</li>\n";
                        }
                        echo "</ul>\n";
                    }
                ?></li>
                <li><strong>Peso: </strong><?= $j->peso ?></li>
                <li><strong>Insuficiência Renal: </strong><?= $j->insuficiencia_renal?></li>
                <?php if($j->insuficiencia_renal == 'Sim') {
                    echo "<li></strong> Clearence de creatina: </strong> $j->clearence_creatina</li>\n";
                } ?>
            </ul>            
        </blockquote>
        
        <table>
            <thead>
                <tr class="colunas">
                    <th>Medicamento <small>(codigo)</small></th>
                    <th>Dose</th>
                    <th>Posologia</th>
                    <th>Intervalo</th>
                    <th>Via</th>
                    <th>Dias</th>
                    <th>Autorização</th>
                    <th>Alteração</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $descricaoMedicamento 
                    = $codigoMedicamento 
                    = $dose 
                    = $posologia 
                    = $intervalo 
                    = $via 
                    = $duracao
                    = $autorizacao
                    = $alteracao =  "";
                    $prorrogacoes = array();
                    $suspenso = 
                    $exclusao = false;
                    $imparPar = 0;
                    foreach($j->antimicrobianosPrescritos as $ap){
                        $classeImparPar = $imparPar++ % 2 == 1 ? "impar" : "par";
                        
                        $descricaoMedicamento = $ap->descricao_medicamento;
                        $codigoMedicamento = $ap->codigo_medicamento;
                        $dose = $ap->dose_prescrita;
                        $posologia = $ap->posologia_prescrita;
                        $intervalo = $ap->intervalo_prescrito;
                        $via = $vias[$ap->via_prescrita] ?? false;
                        $suspenso = ($ap->suspenso == 'Sim');
                        if($ap->antimicrobianoParecer){
                            $app = $ap->antimicrobianoParecer;
                            if($app->autorizacao == 'Sim'){
                                $autorizacao = 'Sim';
                            } else {
                                $autorizacao = 'Não';
                            } //autorizacao
                            if($app->alterado == 'Sim'){
                                $alteracao = 'Sim';
                                if($app->dose_parecer != $ap->dose_prescrita){
                                    $dose = "<span class='alterado'>$ap->dose_prescrita</span> $app->dose_parecer";
                                }
                                if($app->intervalo_parecer != $ap->intervalo_prescrito){
                                    $intervalo = "<span class='alterado'>$ap->intervalo_prescrito</span> $app->intervalo_parecer";
                                }
                                if($app->via_parecer != $ap->via_prescrita){
                                    $via = "<span class='alterado'>". $vias[$ap->via_prescrita]."</span>".$vias[$app->via_parecer];
                                }                                
                                if($app->duracao_parecer != $ap->dias_propostos_prescritos){
                                    $dose = "<span class='alterado'>$ap->dias_propostos_prescritos</span> $app->duracao_parecer";
                                }                                
                            } else {
                                $alteracao = 'Não';
                            }//alteracao
                        } else {
                            $alteracao = $autorizacao = ' - '; 
                        }?>
                    <tr class="<?= $classeImparPar ?>">
                        <td><?= $descricaoMedicamento?><small> (<?=$codigoMedicamento?>)</small></td>
                        <td><?= $dose ?></td>
                        <td><?= $posologia ?></td>
                        <td><?= $intervalo ?></td>
                        <td><?= $via ?></td>
                        <td><?= $duracao ?></td>
                        <td><?= $autorizacao ?></td>
                        <td><?= $alteracao ?></td>
                    </tr>
                    <?php 
                        if($suspenso){
                            $suspenso = false;
                            echo "<tr class='$classeImparPar'><td colspan='8'><strong>$descricaoMedicamento foi suspenso no ato da justificativa</strong></td></tr>";
                        }
                    ?>
                <?php 
                    $nProrrogacoes = count($ap->prorrogacoes);
                        if($nProrrogacoes>0){
                            //$textoTotalProrrogacoes = "Este medicamento foi prorrogado $nProrrogacoes vez" . ($nProrrogacoes == 1 ? 'es' :'');
                            foreach($ap->prorrogacoes as $i => $prorrogacao){
                                ?>
                                <tr class="<?= $classeImparPar ?>">
                                    <td colspan="8" class="texto-pequeno">
                                        <small>Solicitação de prorrogação por <?= $prorrogacao->dias_solicitados_prorrogacao ?> dias feita em
                                        <?= $prorrogacao->data_solicitacao_prorrogacao ?>, por <?=  $prorrogacao->usuario_prorrogacao?>.</small>
                                        <?php 
                                        $pp =$prorrogacao->parecerProrrogacao;
                                        if($pp){ 
                                            $analisadaComo = "";
                                            if($pp->autorizacao_prorrogacao == 'Sim'){
                                                if($pp->dias_parecer_prorrogacao = $prorrogacao->dias_solicitados_prorrogacao){
                                                    $analisadaComo = "autorizada";
                                                }else{
                                                    $analisadaComo = "alterada para $pp->dias_parecer_prorrogacao dia" . ($pp->dias_parecer_prorrogacao > 1) ? 's':'';
                                                }
                                            }else{
                                                $analisadaComo = "negada";
                                            }
                                            $textoParecerProrrogacao = "A solicitação foi $analisadaComo por $pp->responsavel_parecer_prorrogacao em $pp->data_parecer_prorrogacao";
                                        } ?>
                                        <small><?= $textoParecerProrrogacao ?></small>
                                    </td>
                                </tr>
                            <?php
                            }
                        }//if prorrogações.
                        if($ap->exclusoes){
                            $e = $ap->exclusoes;
                            $motivoExclusao = $e->motivo_exclusao == 'outro' ? $e->conteudo_observacao_exclusao : $e->motivo_exclusao;
                            echo "<tr class='$classeImparPar'><td colspan='8'><small>$descricaoMedicamento foi excluído em $e->data_hora_exclusao por $e->responsavel_exclusao, pelo motivo: $motivoExclusao</small></td></tr>";
                        }
                    }//foreach antimicrobianosPrescritos
                ?>
                <?php
                    if($j->parecer){ ?>
                    <tr class="parecer">
                        <td colspan="8">
                            <p>Parecer desta justificativa elaborado por : <strong><?= $j->parecer->responsavel_parecer?></strong> em <strong><?= $j->parecer->data_hora_parecer?></strong>
                            <blockquote>
                            <p>
                                <?= $j->parecer->conteudo_parecer ?>
                            </p>
                            </blockquote>
                        </td>
                    </tr>
                <?php } else{ ?>
                    <tr class="parecer">
                        <td colspan="8">
                            <p class="center">Não existe parecer para esta justificativa</p>
                        </td>
                    </tr>
                <?php } //if parecer ?>
            </tbody>
        </table>
        <?php 
        echo "</div>";
        }//foreach
    ?>
    </div>


    <?php
    //echo "<pre>";
    //print_r($justificativas); 
    //print_r($antimicrobianos); 
    //print_r($pareceres); 
    //print_r($antimicrobianosPareceres); 
    //print_r($prorrogacoes); 
    // print_r($pareceresProrrogacoes); 
    //print_r($exclusoes); 
    //print_r($dados); 
    //echo "<pre>";
    ?>
</div>