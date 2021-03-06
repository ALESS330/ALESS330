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

$idade = $idadeAnos = $idadeMeses = $idadeDias = "";

$totalCamposIdade = 0;
if($paciente['idade_anos'] > 0){
    $idadeAnos = $paciente['idade_anos'] == 1 ? "1 ano " : $paciente['idade_anos']. " anos";
    $totalCamposIdade++;
}

if($paciente['idade_meses'] > 0){
    $idadeMeses = $paciente['idade_meses'] == 1 ? "1 mês " : $paciente['idade_meses']. " meses";
    $totalCamposIdade++;    
}

if($paciente['idade_dias'] > 0){
    $idadeDias = $paciente['idade_dias'] == 1 ? "1 dia" : $paciente['idade_dias'] . " dias";
    $totalCamposIdade++;
}

if($totalCamposIdade === 3){
    $idade = "$idadeAnos, $idadeMeses e $idadeDias";
}else if($totalCamposIdade === 1){
    $idade = "$idadeAnos$idadeMeses$idadeDias";
}else{
    if($idadeAnos){
        if($idadeMeses){
            $idade = "$idadeAnos e $idadeMeses";
        }else{
            $idade = "$idadeAnos e $idadeDias";
        }
    }else{
        $idade = "$idadeMeses e $idadeDias";
    }
}
?>
<style type="text/css">
    #painel-beira-leito {
        width: 297mm;
        height: 210mm;
        box-shadow: 0 0.5px 3px 0.5px grey;
        margin: 0 auto;
        margin-bottom: 5mm;
        box-sizing: border-box;
        padding: 7mm;
    }

    #nome-paciente, #prontuario-internacao, #nome-mae {
        width: 100%;
    }

    #logo-hu, #logo-ebserh, #nascimento, #sexo {
        width: 20%;
        float: left;
    }

    #texto-titulo, #idade {
        width: 59%;
        float: left;
        text-align: center;
    }

    #painel-beira-leito div:not(.multipla-escolha):not(.opcoes) {
        height: 100px;
    }

    #logo-hu, #logo-ebserh {
        height: 70px !important;
    }

    #prontuario-paciente, #admissao, #rue {
        width: 33%;
        float: left;
    }

    #alergia, #risco {
        width: 50%;
        float: left;
        height: 250px !important;
        border: solid 1px silver !important;
        padding: 2mm !important;
    }
    #risco {
        border-left: none !important;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    #alergia {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    ul {
        margin: 3px;
    }

    ul li {
        font-size: 14pt !important;
    }

    div.opcoes {
        padding-left: 20px !important;
    }

    span.quadrado {
        font-size: 24px;
        line-height: 26px;
    }

    h4 {
        margin: 4px !important;
    }

    #logo-hu img {
        width: 40% !important;
        margin-top: 14px !important;
    }

    #logo-ebserh img {
        width: 68% !important;
        margin-top: 14px;
        margin-left: -110px;
    }

    #nome-paciente {
        height: 150px !important;
        text-align: center;
    }

    .nome-paciente {
        font-weight: bolder;
        font-size: 68px;
        height: 150px;
        overflow : hidden;
        text-overflow: ellipsis;
    }

    #icone-exclamacao {
        width: 48px;
        height: 44px;
        float: right;
    }

    #icone-queda {
        width: 48px;
        height: 43px;
        float: right;
    }

    #icone-fratura {
        width: 48px;
        height: 44px;
        float: right;
        margin-top: 10px;
    }

    @media print {

        * {
            font-family: "Google Sans" !important;
        }

        h3{
            font-size: 2.93rem;
            line-height: 110%;
        }
        h4 {
            font-size: 2.28rem;
            line-height: 110%;
        }


        li {
            list-style: none;
        }
        @page {
            margin: 0mm;
            size: 297mm 210mm;
        }
        body {
            margin: 5mm;
        }
        .no-print {
            display: none;
        }

        div.opcoes {
            padding-left: 20px;
        }

        #painel-beira-leito {
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            box-shadow: none;
            padding: 7mm;
        }
        #alergia, #risco {
            width: 50%;
            float: left;
            height: 250px !important;
            border: solid 1px silver !important;
            padding: 2mm !important;
        }
        #risco {
            border-left: none !important;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        #alergia {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
    } /*media print*/

    @media
</style>

<div id="painel-beira-leito">
    <div id="nome-paciente">
        <h4 class="nome-paciente" id="nome-paciente-h4"><?= $paciente['nome'] ?></h4>
    </div>

    <div id="dados-paciente">
        <div id="nascimento">
            <span>Data de Nascimento</span>
            <h4><strong><?= $paciente['data_nascimento'] ?></strong></h4>
        </div>
        <div id="idade">
            <span style="">Idade</span>
            <h4><?= $idade ?></h4>
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
                <li>ALERGIA a quê? __________________</li>
                <li>Risco de Broncoaspiração</li>
                <li>
                    <div class="opcoes" style="border-bottom: solid 1px silver !important;">
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
                    <div class="opcoes" style="border-bottom: solid 1px silver !important;">
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
    <div id="logos">
        <div id="logo-hu">
            <img src="http://<?= $server ?>/relator/assets/img/logo-hu-alt-80.png"/>
        </div>
        <div id="logo-ebserh">
            <img src="http://<?= $server ?>/relator/assets/img/logo-ebserh-alt-80.png"/>
        </div>
    </div>
</div>


#{scriptPagina}
<script type="text/javascript">
    str = $("#nome-paciente-h4").text();
    if (str.length >= 25) {
        $(".nome-paciente").css('font-size', '68px');
//        $(".nome-paciente").css({
//            'font-size': '68px',
//            'position': 'absolute',
//            'top': '19%',
//            'left': '50%',
//            '-ms-transform': 'translate(-50%, -50%)',
//            'transform': 'translate(-50%, -50%)'
//        });
    } else {
        $(".nome-paciente").css('font-size', '75px');
//        $(".nome-paciente").css({
//            'font-size': '75px',
//            'position': 'absolute',
//            'top': '20%',
//            'left': '50%',
//            '-ms-transform': 'translate(-50%, -50%)',
//            'transform': 'translate(-50%, -50%)'
//        });
    }
////    str = $("#nome-paciente-h4").text();
//            function contaPalavras(str) {
//                str = str.replace(/(^\s*)|(\s*$)/gi, "");
//                str = str.replace(/[ ]{2,}/gi, " ");
//                str = str.replace(/\n /, "\n");
//                return str.split(' ').length;
//            }
//
//    if (contaPalavras(str) >= 4) {
//        $(".nome-paciente").css('font-size', '68px');
//    } else {
//        $(".nome-paciente").css('font-size', '80px');
//    }

    function gerarTermo() {
        window.print();
    }
</script>
#{/scriptPagina}