<?php
global $orientacao;
$orientacao = "L";
$paciente = $dados[0];
?>
<style type="text/css">

    .rotulo{
        width: 63mm;
        height: 100mm;
        background-image: url('/relator/assets/img/fundo-rotulo-medicamento.jpg');
        background-size: 98%;
        background-position: center;
        background-repeat: no-repeat;
        padding-top: 5mm;
        padding-left: 5mm;
        padding-right: 5mm;
        padding-bottom: 0mm;
        float: left;
/*        border: solid 1px silver;*/
        font-size: 10pt;
        font-family: Arial;
    }

    .rotulo ul li{
        list-style: none;
    }

    .rotulo .titulo-rotulo{
        padding-left: 30mm;
        font-weight: bold;
        font-size: 8pt;
        color: white;
        padding-bottom: 2mm;
    }
    strong{
        font-size: 8pt;
        line-height: 10pt;
    }
    .medicamento{
        height: 40mm;
    }
    div.dados div{
        line-height: 7mm;
    }
</style>
<?php for ($i = 0; $i <= 7; $i++) { ?>
    <div class="rotulo">
        <div class="titulo-rotulo">Rótulo de Medicação</div>
        <div class="paciente">
            <strong>Paciente: </strong><span><?= $paciente['nome'] ?></span>
            <strong>DN: </strong><span><?= $paciente['data_nascimento'] ?></span>        
        </div>
        <div class="medicamento">
            <strong>Diluente: </strong> _________ <strong>Volume: </strong> ___________
            <strong>Medicamento/dose: </strong>
        </div>
        <div class="dados">
            <div><strong>Tempo de infusão:</strong> _______h</div>
            <div><strong>Velocidade: </strong> _____ <small>gts/min</small> ou _____ <small>ml/h</small></div>
            <div><strong>Hora Início:</strong> ___:___ <strong>Hora Término: </strong> ___:___ </div>
            <div><strong>Data: </strong> ____/____/________</div>
            <div><strong>Profissional: </strong>__________________</div>
        </div>
    </div>
<?php } ?>