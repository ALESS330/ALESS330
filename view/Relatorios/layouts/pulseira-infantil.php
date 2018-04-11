<?php
$pulseira = $dados[0];
$imprimirUrl = $_SERVER['REQUEST_URI']; // . "&imprimir=true";
$user = new Usuario($_SESSION['username']);
?>

#{scriptPagina}
<script type="text/javascript">
    $(document).ready(function () {
        $("select").material_select();
        $('select[required]').css({
            display: 'inline',
            position: 'absolute',
            float: 'left',
            padding: 0,
            margin: 0,
            border: '1px solid rgba(255,255,255,0)',
            height: 0,
            width: 0,
            top: '2em',
            left: '3em',
            opacity: 0
        });
    });
</script>
#{/scriptPagina}
<style type="text/css">
    .fixed-action-btn:not(.imprimir){
        display: none;
    }
    #pulseira{
        padding: none;
        padding-left: 3.5cm;
        margin: none;
        background-image: url(/relator/assets/img/pulseira-infantil-bg.svg);
        background-repeat: no-repeat;
        background-size: 17.7cm 2.5cm;
        border: none;
        height: 2.8cm;
        box-shadow: none;
    }
    div.small{
        font-size: 6pt;
    }
    div.strong{
        font-size: 10pt;
        font-weight: bold;
    }
    div.nome-paciente{
        font-size: 12pt;
        font-weight: bold;
    }
    #prontuario{
        display: block;
        width: 3cm;
        height: 2.3cm;
        float: left;
        text-align: center;
    }

    #prontuario .strong{
        display: block;
        font-size: 14pt;
        padding-top: 0.75cm;
    }

    #prontuario .small{
        font-size: 9pt;
        font-family: arial;
    }

    #dados{
        width: 18cm;
        height: 2.3cm;
        float: left;
        padding-top: 5px;
    }
    .small, .strong{
        line-height: 1.15;
        display: block;
    }
    div.container{
        padding-top: 0.5cm;
    }
    .titulo-relatorio {
        padding-bottom: 25px;
        font-weight: bold;
    }
</style>


<form action="<?= $imprimirUrl ?>">
    <div class="fixed-action-btn imprimir">
        <input type="hidden" name="prontuario" value="<?= $pulseira['prontuario'] ?>" />
        <input type="hidden" name="imprimir" value="true" />
        <button class="btn-floating btn-large red">
            <i class="material-icons">print</i>
        </button>
    </div>

    <h5 class="titulo-relatorio">Pulseira Infantil</h5>
    <div id="pulseira">
        <div id="prontuario">
            <div class="strong"><?= $pulseira['prontuario'] ?> </div>
            <div class="small">Prontuário</div>
        </div>
        <div id="dados">
            <div>
                <div class="small">Nome: </div>
                <div class="strong nome-paciente"><?= $pulseira['nome'] ?> </div>
            </div>
            <div>
                <div class="small">Nome da mãe: </div>
                <div class="strong"><?= $pulseira['nome_mae'] ?> </div>
            </div>
            <div>
                <div class="small">Data de Nascimento: </div>
                <div class="strong"><?= $pulseira['data_nascimento'] ?> </div>
            </div>
        </div>
    </div>
    <br />
    <select name="impressora" required>
        <option value="">Selecione e Impressora</option>
        <?php if ($user->isDeveloper()) { ?>
            <option value="HUGD_PULSEIRA_TESTE">TESTE SGPTI</option>
        <?php } ?>
        <!--        <option value="HUGD-PULS-COBS02">Centro Obstétrico - Neonato</option>-->
        <option value="HUGD-PULS-COBS01">Centro Obstétrico - Adulto</option>
        <option value="HUGD-PULS-RINTER01">Recepção de Internação - Adulto</option>
        <!--option value="HUGD-PULS-RINTER01">Recepção de Internação - Pediátrico</option -->
        <option value="HUGD-PULS-PAGO01">Recepção de Maternidade - Adulto</option>
        <!--option value="HUGD-PULS-PAGO01">Recepção de Maternidade - Neonato</option -->        
    </select>
</form>