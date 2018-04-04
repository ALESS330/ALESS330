<?php $pulseira = $dados[0]; ?> 
<html>
    <head>
        <style type="text/css">
            html{
                font-family: sans-serif;
            }
            #pulseira{
                padding-left: 5cm;
                padding-top: 0.18cm;
                background-image: url('/relator/assets/img/logo_sistemas_cinza.png');
                background-repeat: no-repeat;
                background-size: auto 90%;
                background-position: 4.5cm;
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

        </style>
    </head>
</html>
<body>
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
</body>