<?php

$routes = array();

$routes["/"] = "Application->index";

$routes["/relatorios"] = "Relatorios->index";
$routes["/relatorios/cadastro"] = "Relatorios->cadastro";
$routes["/relatorios/salvar"] = "Relatorios->salvar";
$routes["/relatorios/pagina"] = "Relatorios->lista";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}/pdf"] = "Relatorios->gerarPdf";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}/excel"] = "Relatorios->gerarExcel";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}"] = "Relatorios->gerar";


$routes["/datasources"] = "Datasources->index";
$routes["/datasource"] = "Datasources->cadastro";
$routes["/datasource/{\d+:id}"] = "Datasources->cadastro";
$routes["/datasource/salvar"] = "Datasources->salvar";

$routes["/espelho"] = "Application->espelha";

$routes["/login"] = "Acessos->login";
$routes["/logout"] = "Acessos->logout";
$routes["/login/"] = "Acessos->logar";