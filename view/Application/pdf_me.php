#{header}
<strong>Cabeçalho</strong>
#{/header}

<h1>Sou um PDF!</h1>


#{footer}
<div class="footer-report-ebserh footer">
    <div class="footer-content">
        <p>Documento preenchido por <strong><?= $usuario?> </strong> em <strong><?= date('d/m/Y')?></strong></p>
    </div>
    <div style="text-align: right;">
        <div class="referencia-pagina">Página {PAGENO} de {nbpg}</div>
    </div>
</div>
#{/footer}
    