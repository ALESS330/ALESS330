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

    #titulo, #nome-paciente, #prontuario-internacao{
        width: 100%;
    }

    #nome-mae{
        width: 65%;
        float: left;
    }

    #tipo-parto{
        width: 35%;
        float: left;
    }

    #logo-hu, #logo-ebserh, #nascimento, #sexo{
        width: 20%;
        float: left;
    }

    #texto-titulo{

    }
    #texto-titulo, #idade{
        width: 59%;
        float: left;
        text-align: center;
    }

    #painel-beira-leito div:not(.multipla-escolha):not(.opcoes){
        height: 95px;
    }

    #prontuario-paciente, #admissao, #rue, #peso-ao-nascer, #idade-gestacional, #hora-nascimento{
        width: 33%;
        float: left;
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

    #cuidados-especiais{
        border: solid 1px silver !important;
        border-radius: 10px !important;
    }
    #cuidados-especiais ul{
        width: 49% !important;
        float: left;
    }
    #cuidados-especiais h4{
        font-size: 1.5rem !important;
        text-align: center;
        font-weight: bold;
    }

    #cuidados-especiais li{
        font-size: 12.5px !important;
        list-style-type: circle !important;
        list-style-position: inside !important;
    }

    #logos {
        position: relative;
        left: 820px;
    }

    #logo-hu img {
        width: 40% !important;
        margin-top: 8px !important;
    }

    #logo-ebserh img {
        width: 68% !important;
        margin-top: 8px;
        margin-left: -110px;
    }

    #nome-paciente {
        height: 160px !important;
        text-align: center;
    }

    .nome-paciente {
        font-weight: bolder;
        font-size: 68px;
        height: 160px;
        overflow : hidden;
        text-overflow: ellipsis;
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
        #painel-beira-leito{
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            box-shadow: none;
            padding: 7mm;
        }
    } /*media print*/
</style>

<div id="painel-beira-leito">
    <!--    <div id="titulo">
            <div id="logo-hu">
                <img src="http://<?= $server ?>/relator/assets/img/logo-hu-alt-80.png"/>
            </div>
            <div id="texto-titulo">
                <h3>IDENTIFICAÇÃO DO BEBÊ</h3>
            </div>
            <div id="logo-ebserh">
                <img src="http://<?= $server ?>/relator/assets/img/logo-ebserh-alt-80.png"/>
            </div>
        </div>  #titulo -->

    <div id="nome-paciente">
        <h4 class="nome-paciente"><?= $paciente['nome'] ?></h4>
    </div> <!-- #nome-paciente -->

    <div id="dados-paciente">
        <div id="nascimento">
            <span>Data de Nascimento</span>
            <h4><strong><?= $paciente['data_nascimento'] ?></strong></h4>
        </div>
        <div id="idade">
            <span style="margin-right: 84px;">Idade</span>
            <h4><?= $paciente['idade'] ?></h4>
        </div>
        <div id="sexo">
            <span>Sexo</span>
            <h4><?= $paciente['sexo'] ?></h4>
        </div>
    </div>
    <div id="nome-mae-tipo-parto">
        <div id="nome-mae">
            <span>Nome da mãe</span>
            <h4><?= $paciente['nome_mae'] ?></h4>
        </div>
        <div id="tipo-parto">
            <span>Tipo de parto</span>
            <ul>
                <li>
                    <div class="opcoes">
                        <div class="multipla-escolha"> <h4><span style="font-size: 42px;">&square;</span> Cesárea &nbsp;&nbsp;<span style="font-size: 42px;">&square;</span> Normal</div>

                    </div>
                </li>
            </ul>
        </div>
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
    <div id="dados-neonato">
        <div id="peso-ao-nascer">
            <span>Peso ao nascer</span>
            <h4>____________</h4>
        </div>
        <div id="idade-gestacional">
            <span>IG</span>
            <h4>____________</h4>
        </div>
        <div id="hora-nascimento">
            <span>Hora do nascimento</span>
            <h4>_______:_______</h4>
        </div>
    </div>
    <div id="cuidados-especiais" style="height: 178px; padding: 4px">
        <div style="margin: 0 auto">
            <h4>Cuidados especiais</h4>
            <ul>
                <li>Manter PULSEIRA DE IDENTIFICAÇÃO do seu bebê até a alta</li>
                <li>CONFERIR se os dados da pulseira estão corretos</li>
                <li>NUNCA deixar o bebê sobre a cama, pois o berço é o mais seguro</li>
                <li>NUNCA permitir que seu bebê seja amamentado por outra mãe, pelo risco de doenças</li>
                <li>SEMPRE lavar as mãos antes e após o cuidado com o bebê</li>
                <li>NUNCA transportar bebê no colo, e sim no berço</li>
                <li>EVITE uso de celular durante a internação</li>
            </ul>
            <ul style="float: right">
                <li>Lembrar da VACINAÇÃO do bebê</li>
                <li>Acompanhante deve SEMPRE auxiliar a mãe durante o cuidado e o seu repouso</li>
                <li>NUNCA dormir na cama com o bebê pelo risco de asfixia ou queda</li>
                <li>Acompanhante NUNCA dormir na cama da paciente</li>
                <li>SOLICITE ajuda dos profissionais para auxílio na amamentação</li>
                <li>NUNCA deixe seu bebê com estranhos</li>
                <li>As orientações sobre o bebê serão dadas pela manhã</li>
            </ul>
        </div> <!-- margin 0 auto-->
    </div><!-- #cuidados-especiais -->
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
        $(".nome-paciente").css({
            'font-size': '68px',
            'position': 'absolute',
            'top': '19%',
            'left': '50%',
            '-ms-transform': 'translate(-50%, -50%)',
            'transform': 'translate(-50%, -50%)'
        });
    } else {
        $(".nome-paciente").css({
            'font-size': '75px',
            'position': 'absolute',
            'top': '20%',
            'left': '50%',
            '-ms-transform': 'translate(-50%, -50%)',
            'transform': 'translate(-50%, -50%)'
        });
    }

    function gerarTermo() {
        window.print();
    }
</script>
#{/scriptPagina}