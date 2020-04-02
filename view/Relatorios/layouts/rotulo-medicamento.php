#{botoes}
<div class="fixed-action-btn no-print">
    <button class="btn-floating btn-large red" id="bt-imprimir" title="Imprimir" onclick="window.print();">
        <i class="material-icons">local_printshop</i>
    </button>
</div>
#{/botoes}

<?php 
    $paciente = $dados[0];
?>
<style>
    body {
        font-family: 'Google Sans' !important;
    }

    .conteudo {
        width: 297mm;
        height: 210mm;
        margin: 0 auto;
        margin-top: 15px;
        box-shadow: 0 0.5px 3px 0.5px grey;
        padding: 10mm;
        margin-bottom: 5px;
    }

    .rotulo{
        width: 66mm;
        height: 94mm;
        background-image: url('/relator/assets/img/fundo-rotulo-medicamento.jpg');
        background-size: 100%;
        background-position: 0 0;
        background-repeat: no-repeat;
        margin: 1mm;
        float: left;
        font-size: 9pt;
        font-family: Arial;
        border: solid 1px silver;
    }

    .rotulo .titulo-rotulo{
        padding-left: 32mm !important;
        font-weight: bold !important;
        font-size: 7pt !important;
        color: white;
        padding-bottom: 2mm !important;
        padding-top: 6px !important;
    }
    strong{
        font-size: 8pt;
        line-height: 10pt;
    }
    .medicamento{
        height: 50mm;
    }

    .rotulo div{ 
        margin-left: 1mm;
    }

    @media print {
        @page { 
            margin: 0 !important;
        }
        body {
            font-family: Roboto !important;
            /* margin-top: 1mm;
            margin-bottom: 5mm; */
        }
        .conteudo {
            box-shadow: none;
            margin-top: 0px;
            padding-top: 2.5mm !important;
            height: 200mm;
        }
        .no-print {
            display: none;
        }
    }
</style>

<div class="conteudo">
<?php for ($i = 0; $i <= 7; $i++) { ?>
    <div class="rotulo">
        <div class="titulo-rotulo">Rótulo de Medicação</div>
        <div class="paciente">
            <div class="nome-paciente"><strong><?= $paciente['nome'] ?></strong></div>
            <strong>DN: </strong><span><?= $paciente['data_nascimento'] ?></span>        
        </div>
        <div class="medicamento">
            <div>
                <strong>Diluente: </strong> _________ <strong>
            </div>
            <div>
                Volume: </strong> ___________
            </div>
            <strong>Medicamento/dose: </strong>
        </div>
        <div class="dados">
            
            <div><strong>Tempo de infusão:</strong> _______h</div>
            <div><strong>Velocidade: </strong> _____ <small>gts/min ou _____ ml/h</small></div>
            <div>
                <strong>Hora Início:</strong> ___:___
                <strong>Término</strong> ___:___ 
            </div>
            <div><strong>Data: </strong> ____/____/________</div>
            <div><strong>Profissional: </strong>__________________</div>
        </div>
    </div>
<?php } ?>
</div>