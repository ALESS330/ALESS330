<?php
$pulseira = $dados[0];
$imprimirUrl = $_SERVER['REQUEST_URI']; // . "&imprimir=true";
$user = new Usuario($_SESSION['username'] ?? NULL);
?>

#{scriptPagina}
<script type="text/javascript">
    $(document).ready(function () {
        $("select").formSelect();
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
        margin: none;
        background-image: url(/relator/assets/img/pulseira-neonato-soft-bg.svg);
        background-repeat: no-repeat;
        background-size: 19cm 2.5cm;
        border: none;
        height: 2.8cm;
        box-shadow: none;
    }
    div.small{
        font-size: 7px;
    }
    div.strong{
        font-size: 7px;
        font-weight: bold;
    }
    div.nome-paciente{
        font-size: 7px;
        font-weight: bold;
        height: 13pt;
        width: 48mm;
    }
    #prontuario{
        display: block;
        width: 21mm;
        height: 2.3cm;
        float: left;
        text-align: center;
        transform: rotate(270deg);
    }

    #prontuario .strong{
        display: block;
        font-size: 16px;
        padding-top: 0.75cm;
    }

    #dados{
        width: 18cm;
        height: 2.3cm;
        float: left;
        padding-top: 8px;
        line-height: 2px;
        left: -38px;
        position: relative;
    }

    #dados div{
        margin-top: 3px;
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
    div.inline {
        float:left;
        padding-right: 12px;
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

    <h5 class="titulo-relatorio">Pulseira Neonato</h5>
    <div id="pulseira">

        <div id="prontuario">
            <div class="strong"><?= $pulseira['prontuario'] ?> </div>
        </div>
        <div id="dados">
            <div>
                <div class="strong nome-paciente"><?= $pulseira['nome'] ?></div>
            </div>
            <div>
                <div class="small">Nome da m??e: </div>
                <div class="strong"><?= $pulseira['nome_mae'] ?> </div>
            </div>
            <div class="inline">
                <div class="small">Nascimento: </div>
                <div class="strong"><?= $pulseira['data_nascimento'] ?> </div>
            </div>
            <div class="inline">
                <div class="small">Sexo: </div>
                <div class="strong"><?= $pulseira['sexo'] ?> </div>
            </div>
            <div class="inline">
                <div class="small">Cor: </div>
                <div class="strong"><?= $pulseira['raca_cor'] ?> </div>
            </div>
        </div>
    </div>
    <br />
    =#{selectImpressoras /}
</form>