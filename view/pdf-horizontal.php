<?php
    global $orientacao;
    $orientacao = "L";
?>
<html>
    <head>
        <meta charset="UTF-8"> 
        <title><?= $nomeDocumento ?? "documento-pdf" ?></title>
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
    </style>
    #{stylesPagina /}    
    <div class="header">
        #{header /}
    </div>
    <body>
        <div class="content">
            <?php $html ?>
        </div>
    </body>
    <div class="footer">
        #{footer /}
        <div class="pages"></div>
    </div>
</html>
        