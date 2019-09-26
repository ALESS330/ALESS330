<div class="fixed-action-btn no-print">
    <button class="btn-floating btn-large red" id="bt-imprimir" title="Imprimir" onclick="gerarTermo();">
        <i class="material-icons">local_printshop</i>
    </button>
</div>

<?php
global $orientacao, $margem, $template;
$margem = array(
    'margin_left' => 0,
    'margin_right' => 0,
    'margin_top' => 0,
    'margin_bottom' => 0,
    'margin_header' => 0,
    'margin_footer' => 0);
$orientacao = "L";
$template = 'blank';
$paciente = $dados[0];

$server = $_SERVER['HTTP_HOST'];

//59 Fátima do Sul
//55 Naviraí
//53 HR de Nova Andradina
//21 HR de Ponta Porã
//17 Hospital da Vida
//52 UPA
$origensRUE = [-1, 59, 55, 53, 21, 17, 52];

$mostrarRUE = false;
if (array_search($paciente['seq_origem'], $origensRUE) !== FALSE) {
    $mostrarRUE = TRUE;
}
?>
<style type="text/css">
    #painel-beira-leito{
        width: 297mm;
        height: 210mm;
        box-shadow: 0 0.5px 3px 0.5px grey;
        margin: 0 auto;
        margin-bottom: 5mm;
        box-sizing: border-box;
        padding: 7mm;
    }

    #titulo, #nome-paciente, #prontuario-internacao, #nome-mae{
        width: 100%;
    }

    #logo-hu, #logo-ebserh, #nascimento, #sexo{
        width: 20%;
        float: left;
    }

    #texto-titulo, #idade{
        width: 59%;
        float: left;
        text-align: center;
    }

    #painel-beira-leito div:not(.multipla-escolha):not(.opcoes){
        height: 100px;
    }
    #prontuario-paciente, #admissao, #rue, #peso-admissional{
        width: 25%;
        float: left;
    }

    #alergia, #risco{
        width: 50%;
        float: left;
        height: 250px !important;
        border: solid 1px silver !important;
        padding: 2mm !important;
    }        
    #risco{
        border-left: none !important;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    #alergia{
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    ul{
        margin: 3px;
    }

    ul li{
        font-size: 14pt !important;
    }

    h4{
        margin: 4px !important;
    }

    #logo-hu img{
        width: 200px !important;
        height: 80px !important;
        margin-top: 10px !important;
    }

    #logo-ebserh img{
        height: 56px;
        width: 215px;
        margin-top: 22px;        
    }

    div.opcoes{
        padding-left: 20px !important;
    }

    span.quadrado{
        font-size: 24px;
        line-height: 26px;
    }

    .nome-paciente{
        font-weight: bolder;
    }

    #icone-exclamacao{
        width: 48px;
        height: 44px;
        float: right        
    }

    #icone-queda{
        width: 48px;
        height: 43px;
        float: right;        
    }

    #icone-fratura{
        width: 48px;
        height: 44px;
        float: right;
        margin-top: 10px;
    }
    @media print{
        @page { 
            margin: 0mm; 
            size: 297mm 210mm;
        }
        
        * {
            font-family: "Google Sans" !important;
        }

        h3{
            font-size: 2.93rem;
            line-height: 110%;
        }
        
        h4{
            font-size: 2.28rem;
            line-height: 110%;        
        }

        li{
            list-style: none;
        }

        body{
            margin: 5mm;
        }
        .no-print{
            display: none;
        }

        div.opcoes{
            padding-left: 20px;
        }

        #painel-beira-leito{
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            box-shadow: none;
            padding: 7mm;
        }
        #alergia, #risco{
            width: 50%;
            float: left;
            height: 250px !important;
            border: solid 1px silver !important;
            padding: 2mm !important;
        }        
        #risco{
            border-left: none !important;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        #alergia{
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
    } /*media print*/
</style>

<div id="painel-beira-leito">
    <div id="titulo">
        <div id="logo-hu">
            <img src="http://<?= $server ?>/relator/assets/img/logo-hu.png"/>
        </div>
        <div id="texto-titulo">
            <h3>Identificação Pediátrica</h3>
        </div>
        <div id="logo-ebserh">
            <img src="http://<?= $server ?>/relator/assets/img/logo-ebserh.jpg"/>
        </div>
    </div> <!-- #titulo -->

    <div id="nome-paciente">
        <span>Nome do paciente</span>
        <h4 class="nome-paciente"><?= $paciente['nome'] ?></h4>
    </div> <!-- #nome-paciente -->

    <div id="dados-paciente">
        <div id="nascimento">
            <span>Data de Nascimento</span>
            <h4><?= $paciente['data_nascimento'] ?></h4>
        </div>
        <div id="idade">
            <span>Idade</span>
            <h4><?= $paciente['idade'] ?></h4>
        </div>
        <div id="sexo">
            <span>Sexo</span>
            <h4><?= $paciente['sexo'] ?></h4>
        </div>
    </div>
    <div id="nome-mae">
        <span>Nome da mãe</span>
        <h4><?= $paciente['nome_mae'] ?></h4>
    </div>
    <div id="prontuario-internacao">
        <div id="prontuario-paciente">
            <span>N° Prontuário</span>
            <h4><?= $paciente['prontuario'] ?></h4>            
        </div>
        <div id="admissao">
            <span>Data de admissão</span>
            <h4><?= $paciente['data_internacao'] ?></h4>
        </div>
        <div id="peso-admissional">
            <span>Peso admissional</span>
            <h4>____________</h4>
        </div>
        <div id="rue">
            <?php if ($mostrarRUE) { ?>
                <span><?= $paciente['origem'] ?></span>
                <h4>RUE</h4>                
            <?php } //mostrarRUE ?>
        </div>
    </div>
    <div id="alergias-risco">
        <div id="alergia">
            <ul>
                <img src="http://<?= $server ?>/relator/assets/img/icone-exclamacao.png" id="icone-exclamacao">
                <li>ALERGIA a quê?__________________  </li>
                <li>Risco de Broncoaspiração</li>
                <li>
                    <div class="opcoes" style="border-bottom: solid 1px silver;">
                        <div class="multipla-escolha"> <span class="quadrado">&square;</span> SIM</div>
                        <div class="multipla-escolha"> <span class="quadrado">&square;</span> NÃO</div>
                    </div>
                </li>
                <li>Risco de Lesão por Pressão</li>
                <li>
                    <div class="opcoes">
                        <div class="multipla-escolha"><span class="quadrado">&square;</span> ALTO</div>
                        <div class="multipla-escolha"><span class="quadrado">&square;</span> Moderado</div>
                        <div class="multipla-escolha"><span class="quadrado">&square;</span> Baixo</div>
                    </div>
                </li>
            </ul>
        </div> <!-- alergia -->
        <div id="risco">
            <ul>
                <img src="http://<?= $server ?>/relator/assets/img/icone-queda.png" id="icone-queda">                
                <li>Risco de Queda</li>
                <li>
                    <div class="opcoes">
                        <div class="multipla-escolha"><span class="quadrado">&square;</span> Alto</div>
                        <div class="multipla-escolha"><span class="quadrado">&square;</span> Médio</div>
                    </div>                    
                </li>
                <li>Risco de dano grave por queda</li>
                <li>
                    <div class="opcoes" style="border-bottom: solid 1px silver;">
                        <div class="multipla-escolha"><span class="quadrado">&square;</span> SIM</div>
                        <div class="multipla-escolha"><span class="quadrado">&square;</span> NÃO</div>
                    </div>                    
                </li>
                <img src="http://<?= $server ?>/relator/assets/img/icone-fratura.png" id="icone-fratura">                                     
                <li><span class="quadrado">&square;</span> Discrasia sanguínea/anticoagulante</li>
                <li><span class="quadrado">&square;</span> Osteoporose/fraturas anteriores   </li>
            </ul>
        </div>
    </div>
</div>

#{scriptPagina}
<script type="text/javascript">

    function gerarTermo() {
        window.print();
    }
</script>
#{/scriptPagina}