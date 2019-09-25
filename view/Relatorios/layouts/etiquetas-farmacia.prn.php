<?php

//l é para rótulos
//v é para valores
$lProntuarioX = 18;
$lProntuarioY = 16;
$vProntuarioX = 18;
$vProntuarioY = 32;

$lNascimentoX = 152;
$lNascimentoY = 16;
$vNascimentoX = 152;
$vNascimentoY = 32;

$lNomeX = 18;
$lNomeY = 66;
$vNomeX = 18;
$vNomeY = 82;

//o período não tem rótulo
//$lPeriodoX = 18;
//$lPeriodoY = 60;
$vPeriodoX = 40;
$vPeriodoY = 144;

//tamanho dos letras de rótulos
$vTamanhoH = 30;
$vTamanhoW = 24;
//tamanho das letras de valores
$lTamanhoH = 21;
$lTamanhoW = 18;

//o Período é 20% maior (ou, 1.2 vezes) do que o tamanho 'default'
$vPeriodoTamanhoH = floor($vTamanhoH*1.2);
$vPeriodoTamanhoW = floor($vTamanhoW*1.2);

$deslocamentoNascimento = 150;
$tamanhoEtiqueta = 260;

$layout = "^XA ";
$deslocamento = 20;

$periodos['manha'] = "Manh_c6";
$periodos['tarde'] = "Tarde";
$periodos['noite'] = "Noite";

for($i=0;$i<=2;$i++){
    $lProntuarioX = ($deslocamento + $tamanhoEtiqueta) * $i;
    $vProntuarioX =  ($deslocamento + $tamanhoEtiqueta) * $i;
    $lNomeX =  ($deslocamento + $tamanhoEtiqueta) * $i;
    $vNomeX =  ($deslocamento + $tamanhoEtiqueta) * $i;
    $lNascimentoX = ($deslocamentoNascimento + $tamanhoEtiqueta * $i);
    $vNascimentoX = ($deslocamentoNascimento + $tamanhoEtiqueta * $i);
    $vPeriodoX =  ($deslocamento + $tamanhoEtiqueta) * $i;
    
    $prontuarioAtual = $etiquetas[$i]['prontuario'] ?? "";
    $nomeAtual = $etiquetas[$i]['nome'] ?? "";
    $nascimentoAtual = $etiquetas[$i]['nascimento'] ?? "";
    $periodoAtual = $periodos[$etiquetas[$i]['periodo']] ?? "";
    
//primeira etiqueta
$etiqueta = "

^FO$lProntuarioX,$lProntuarioY
^A0,$lTamanhoH,$lTamanhoW
^FH
^FDProntu_a0rio
^FS

^FO$vProntuarioX,$vProntuarioY
^A0,$vTamanhoH,$vTamanhoW
^FD$prontuarioAtual
^FS

^FO$lNascimentoX,$lNascimentoY
^A0,$lTamanhoH,$lTamanhoW
^FDNascimento:
^FS

^FO$vNascimentoX,$vNascimentoY
^A0,$vTamanhoH,$vTamanhoW
^FD$nascimentoAtual
^FS

^FO$lNomeX,$lNomeY
^A0,$lTamanhoH,$lTamanhoW
^FDNome:
^FS

^FO$vNomeX,$vNomeY
^A0,$lTamanhoH,$lTamanhoW
^FB260,2,1,L,0
^FD$nomeAtual
^FS

^FO$vPeriodoX,$vPeriodoY
^A0,$vPeriodoTamanhoH,$vPeriodoTamanhoW
^FB$tamanhoEtiqueta,1,1,C,0
^FH
^FD$periodoAtual
^FS

";    
    $layout .= $etiqueta;
    $deslocamento = 24;
}//for


$layout .= "^XZ";

//echo "<pre>$layout"; exit();
