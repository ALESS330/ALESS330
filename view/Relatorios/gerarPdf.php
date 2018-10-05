<?php

date_default_timezone_set("America/Campo_Grande");
$horaImpressao = date('d/m/Y H:i:s');
$usuarioImpressao = $user->getUsuarioAGHU()->getUsuario()->nome ?? " - Não identificado - ";
?>

#{header}
<div class="header">
    <strong><?= $descricao ?></strong>
</div>
#{/header}
<?php
echo $html;
?>
#{footer}
<div class="footer">
    <div class="footer-content">
        <p>Impresso em <?= $horaImpressao?> por <?= $usuarioImpressao ?></p> 
    </div>
    <div style="text-align: right;">
        <div>Página {PAGENO} de {nbpg}</div>
    </div>
</div>
#{/footer}