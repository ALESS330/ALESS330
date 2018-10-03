<?php
$cssMPDF = "";
$usarPDF = false;
if (isset($pdf)) {
    if ($pdf) {
        $usarPDF = true;
    }
    if($usarPDF){
        $cssMPDF = '<link href="/base-x/assets/css/pdf.css" type="text/css" rel="stylesheet"/>';
    }
}
?>

<html>
    <head>
        <meta charset="UTF-8"> 
        <title><?= $nomeDocumento ?? "documento-pdf" ?></title>
        <?= $cssMPDF ?>
    </head>
    <style type="text/css">
        @media print{
            @page{
                size: A4;
                margin: 0mm;
                @bottom-right { 
                    content: counter(page) " of " counter(pages); 
                }
            }
        }

        * {
            padding:0;
            margin:0;
            vertical-align:baseline;
            list-style:none;
            border:0
        }        

        html{
            font-family: Roboto, Arial;
        }        
        body{
            width: 210mm;
            height: auto;
            background-image: url('/formularios/assets/img/fundo.jpg') !important;
            background-repeat: repeat-y;
            background-position: 0 0;
            background-size: 210mm 297mm;
        }

        <?php if(!$usarPDF) {?>
        .header{
            position: fixed;
            top: -10mm;
            left: 0;
            display: block;
            margin-left: 85mm;
            width: 118mm;
            height: 21mm;
            padding-top: 10mm;
            text-align: center;
            font-size: 13pt;
            color: white;
            font-weight: bold;
        }
        <?php } ?>
        .footer{
            position: fixed;
            top: 280mm;
            left: 0;
            display: block;
            font-size: 8pt;
            width: 190mm;
            padding-bottom: 2mm;
            padding-right: 10mm;
            padding-left: 10mm;
            padding-top: 5mm;
        }

        .footer .pages{
            float: right;
            content: counter(page) " of " counter(pages); 
        }

        div.content{
            padding-top: 25mm;
            padding-left: 10mm;
            padding-right: 10mm;
            padding-bottom: 20mm;
        }

        strong{
            font-family: Arial;
            font-weight: bolder;
        }
    </style>
    #{stylesPagina /}    
    <body>
        <div class="content">
            #{content /}    
        </div>
    </body>
</html>