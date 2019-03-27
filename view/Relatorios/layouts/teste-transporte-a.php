<?php 

$linha = $dados[0];
// /*
echo "<pre>";
echo "\nprint_r:\n";
print_r($linha);
echo "\nvar_dump\n";
var_dump($linha);
echo "</pre>";
die("concluido...");
// */
$vetor = explode("\n", $linha['content']);

// /*
echo "<pre>";
echo "\nprint_r:\n";
print_r($vetor);
echo "\nvar_dump\n";
var_dump($vetor);
echo "</pre>";
die("concluido...");
// */