<html>
    <head>
        <link rel="stylesheet" href="/relator/assets/css/relatorios.css" media="all" />
        <link href="http://sistemas.hugd.ebserh.gov.br/static/css/fontes.css" rel="stylesheet" media="all" />
        <title>#{tituloRelatorio}</title>
        <style type="text/css">
            @page{
                margin: 10mm 10mm 10mm 10mm;
                size: 210mm 297mm;
                footer: html_footer;
            }
            html{
                font-family: Roboto, Arial;
            }
            .header{
                width: 118mm;
                padding-left: 85mm;
                text-align: center;
                font-size: 13pt;
                font-weight: bold;
                color: white;
            }
            .footer{
                font-size: 8pt;
            }
            strong{
                font-family: Arial;
                font-weight: bolder;
            }
            .texto-esquerdo{
                text-align: left !important;
            }
        </style>
    </head>
    <body>
    <htmlpageheader name="header" >
        #{header /}
    </htmlpageheader>
    <htmlpagefooter name="footer">
        <div style="text-align: right">
            <small>{PAGENO}/{nb}</small>
        </div>
    </htmlpagefooter>        
    #{corpoRelatorio}
</body>
</html>