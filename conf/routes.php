<?php

$routes = array();

$routes["/"] = "Application->index";
$routes['/printer'] = "Application->printers";


$routes["/relatorios"] = "Relatorios->index";
$routes["/relatorio/{\d+:idRelatorio}/tela-parametros/salvar"]  = "Relatorios->salvarTelaParametros";
$routes['/relatorio/{\d+:idRelatorio}/formatos/salvar'] = "Relatorios->salvarFormatos";
$routes['/relatorio/{\d+:idRealtorio}/grupo/{\d+:idGrupo}/associa'] = "Relatorios->associaGrupo";
$routes['/relatorio/{\d+:idRealtorio}/grupo/{\d+:idGrupo}/remove'] = "Relatorios->removeGrupo";
$routes["/relatorio/{\d+:idRelatorio}/propriedades"] = "Relatorios->propriedades";
$routes["/relatorio/{\d+:idRelatorio}/excluir"] = "Relatorios->excluir";
$routes["/relatorio"] = "Relatorios->cadastro";
$routes["/relatorio/{\d+:idRelatorio}"] = "Relatorios->cadastro";
$routes["/relatorios/salvar"] = "Relatorios->salvar";
$routes["/relatorios/{\d+:pagina}/{.+:busca}"] = "Relatorios->pagina";
$routes["/relatorios/{\d+:pagina}/"] = "Relatorios->pagina";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}/print"] = "Relatorios->toPDF";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}.pdf"] = "Relatorios->gerarPdf";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}/pdf"] = "Relatorios->gerarPdf";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}/excel"] = "Relatorios->gerarExcel";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}/csv"] = "Relatorios->gerarCsv";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}"] = "Relatorios->gerar";
$routes["/parametro/{\d+:parametroId}"] = "Parametros->ver";
$routes["/parametros/salvar"] = "Parametros->salvar";

$routes["/datasources"] = "Datasources->index";
$routes["/datasource"] = "Datasources->cadastro";
$routes["/datasource/{\d+:id}"] = "Datasources->cadastro";
$routes["/datasource/salvar"] = "Datasources->salvar";

$routes["/espelho"] = "Application->espelha";

$routes["/login"] = "Acessos->login";
$routes["/logout"] = "Acessos->logout";
$routes["/login/"] = "Acessos->logar";