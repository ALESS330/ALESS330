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
$routes["/datasources/cadastro"] = "Datasources->cadastro";

$routes['/usuario/{.+:username}']             = "Usuarios->ver";
//$routes["/usuarios/salvar"]     = "Usuarios->salvar";
//$routes["/usuarios"]            = "Usuarios->listar";
//$routes["/usuarios/cadastro"]   = "Usuarios->cadastro";

$routes["/login"] = "Acesso->login";
$routes["/logout"] = "Acesso->logout";
$routes["/login/"] = "Acesso->logar";