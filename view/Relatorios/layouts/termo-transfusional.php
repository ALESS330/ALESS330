<?php
$termo = $dados[0];
global $filename;
$assinar = urldecode($termo['responsavel'] ?: $termo['nome']);

$filename = "termo-transfusional[" .$termo['nome'] . "]";
setlocale(LC_ALL, 'pt_BR.UTF-8');
$data = strftime('%d de %B de %Y');
?>

<style type="text/css">
    body {
        font-family: 'Times New Roman';
    }

    .texto , h5 {
        margin: 0;
        padding: 0;
        border: 0;
    }

    .texto p {
        text-align: justify;
        text-indent: 1cm;
        font-size: 12pt;
        line-height: 1.1em;
    }

    h1, h2, h3, h4, h5 {
        text-align: center;
    }

    .titulo-termo {
        margin-top: 0.5cm;
    }

    .assinaturas div {
        text-align: center;
        margin: 1.5cm 2cm 0 2cm;
        border-top: solid 1px black;
    }

    .conteudo{
        width: 190mm;
        margin: 0 auto;
        margin-top: 15px;
/*        box-shadow: 0 1.5px 5px 0.5px grey;*/
        padding: 5mm 10mm 10mm 10mm;
    }

    .assinatura-medico {
        padding-bottom: 50px;
    }

    div.header{
        padding-top: 7mm;
        display: none;
    }
    li{
        list-style: none;
    }
    div.termo-medico{
        font-size: 14pt;
        border: solid 1px black;
    }
    div.pagina-posterior{
        padding-top: 25mm;
        padding-left: 5mm;
        padding-bottom: 10mm;
        padding-right: 5mm;
    }   
    
    h5.alerta-preenchimento{
        font-size: 10pt;
    }
    @media print {
        @page { 
            margin: 0; 
        }
        body {
            margin-top: 10mm;
            margin-bottom: 10mm;
        }
        div.header{
            display: block !important;
        }

        div.page-break{
            page-break-before: always;
        }
    } 

</style>



<div class="header">
    <div class="header-content centro">
        <strong>Termo de Consentimento Livre e Esclarecido Transfusional</strong>        
    </div>
</div>


<div class="conteudo">
    <!-- h5 class="titulo-termo"><strong></strong></h5 -->
    <div class="texto">    
        <p>Eu, <strong><?= $assinar ?></strong>, paciente ou respons??vel legal pelo paciente menor de idade ou incapaz <strong><?= $termo['nome'] ?></strong>, estou ciente da necessidade da realiza????o da transfus??o de sangue (hem??cias,  plaquetas, plasma fresco congelado, crioprecipitado) indicada pelo(a) Dr.(a) <strong><?= $termo['medico'] ?></strong>, CRM <strong><?= $termo['crm'] ?></strong>.</p>
        <p>Fui informado de que o Hemocentro de Dourados e a ag??ncia transfusional do Hospital Universit??rio da Universidade Federal da Grande Dourados (HU-UFGD) cumprem as normas t??cnicas da legisla????o vigente. Dessa forma estou ciente que, apesar da sele????o dos doadores e dos testes laboratoriais previstos em lei, como, hepatite B e C, HIV, Chagas, S??filis, HTLV e moleculares para HIV, Hepatite B e Hepatite C, existe um risco, muito pequeno, de adquirir alguma dessas doen??as infecciosas ap??s a transfus??o de sangue e/ou hemocomponente.</p>
        <p>Estou ciente de que as transfus??es podem causar rea????es imprevis??veis durante ou imediatamente ap??s sua realiza????o, tais como febre, calafrio, rea????es al??rgicas, n??useas, hemat??ria e, mais raramente, problemas pulmonares ou card??acos. Fui informado que todos os cuidados dispon??veis na institui????o foram tomados para se evitar ao m??ximo estas rea????es. As rea????es mais frequentes s??o sintomas leves e facilmente controlados na maioria das vezes e, raramente, podem levar a risco de morte. Nessa ocasi??o, serei avaliado e acompanhado pelo m??dico plantonista.</p>
        <p>Fui orientado quanto ?? possibilidade de infec????o grave e a procurar o servi??o de emerg??ncia caso apresente febre, mal estar geral, ou outra manifesta????o cl??nica n??o habitual, ap??s ser liberado pelo HU-UFGD.</p>
        <p>Declaro que tive a oportunidade de fazer perguntas relativas ?? transfus??o de hemocomponentes e que me foram fornecidas orienta????es sobre os cuidados que terei que observar ap??s a transfus??o.</p>
        <ul>
            <li> &#9633; ACEITO receber transfus??es de sangue e/ou seus componentes.</li>
            <li> &#9633; N??O ACEITO receber transfus??es de sangue e/ou seus componentes e declaro estar ciente dos riscos decorrentes desta decis??o.</li>
        </ul>
    </div>

    <div class="assinaturas">
        <div><strong><?= $assinar ?></strong></div>
        <div class="assinatura-medico"><strong><?= $termo['medico'] ?></strong></div>
    </div>
    <p align="right">Dourados/MS, <?= $data ?>.</p>

</div>

<div class="conteudo page-break pagina-posterior">
    <h4 class="titulo-termo" style="font-size: 14pt; font-family: Arial; margin: 5mm;">Termo de Consentimento Livre e Esclarecido Transfusional</h4>
    <div class="termo-medico" style="padding: 3mm 10mm 10mm 10mm; ">
        <h5 class="alerta-preenchimento">PREENCHIMENTO OBRIGAT??RIO, PELO M??DICO, EM CASO DE EMERG??NCIA/RISCO DE MORTE</h5>
        <p style="text-align: justify">Eu, <?= $termo['medico'] ?>, CRMMS: <?= $termo['crm'] ?>, respons??vel pelo esclarecimento do tratamento institu??do, declaro que n??o foi poss??vel a apresenta????o deste TERMO DE ESCLARECIMENTO, CI??NCIA E CONSENTIMENTO PARA TRANSFUS??O DE HEMOCOMPONENTES, por tratar-se de situa????o de emerg??ncia e/ou risco de morte.</p>

        <div class="assinaturas">
            <div class="assinatura-medico"><strong><?= $termo['medico'] ?></strong></div>            
        </div>
            <p align="right">Dourados/MS, <?= $data ?>.</p>
    </div>

</div>