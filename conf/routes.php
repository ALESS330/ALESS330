<?php

$routes = array();

$routes["/"] = "Appplication->index";
$routes['/printer'] = "Appplication->printers";
$routes['/pdf'] = "Appplication->pdf_me";

$routes["/relatorios"] = "Relatorios->index";
$routes["/relatorio/{\d+:idRelatorio}/tela-parametros/salvar"]  = "Relatorios->salvarTelaParametros";
$routes["/relatorio/{\d+:idRelatorio}/composicao/salvar"]  = "Relatorios->salvarComposicao";
$routes["/relatorio/{\d+:idRelatorio}/composicao/{\d+:idComposicao}/excluir"]  = "Relatorios->excluirComposicao";
$routes['/relatorio/{\d+:idRelatorio}/formatos/salvar'] = "Relatorios->salvarFormatos";
$routes['/relatorio/{\d+:idRelatorio}/categoria/{\d+:idCategoria}/salvar'] = "Relatorios->salvarCategoria";
$routes['/relatorio/{\d+:idRelatorio}/categoria/{\d+:idCategoria}/remover'] = "Relatorios->removerCategoria";
$routes['/relatorio/{\d+:idRelatorio}/decoradores/salvar'] = "Relatorios->salvarDecoradores";
$routes['/relatorio/{\d+:idRealtorio}/grupo/{\d+:idGrupo}/associa'] = "Relatorios->associaGrupo";
$routes['/relatorio/{\d+:idRealtorio}/grupo/{\d+:idGrupo}/remove'] = "Relatorios->removeGrupo";
$routes["/relatorio/{\d+:idRelatorio}/propriedades"] = "Relatorios->propriedades";
$routes["/relatorio/{\d+:idRelatorio}/excluir"] = "Relatorios->excluir";
$routes["/relatorio/{\d+:idRelatorio}"] = "Relatorios->cadastro";
$routes["/relatorio/novo"] = "Relatorios->novo";
$routes["/relatorios/salvar"] = "Relatorios->salvar";
$routes['/relatorios/gerado/{.+:datasource}/{.+:nomeRelatorio}'] = "Relatorios->gerado";
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

$routes['/relatorio/download-html-pdf'] = "Relatorios->downloadHtmlAsPDF";
$routes['/relatorio/download-html'] = "Relatorios->printHTML";

$routes["/datasources"] = "Datasources->index";
$routes["/datasource"] = "Datasources->cadastro";
$routes["/datasource/{\d+:id}"] = "Datasources->cadastro";
$routes["/datasource/salvar"] = "Datasources->salvar";

$routes["/categorias"] = "Categorias->index";
$routes["/categoria"] = "Categorias->cadastro";
$routes["/categoria/{\d+:id}"] = "Categorias->cadastro";
$routes["/categoria/salvar"] = "Categorias->salvar";

$routes["/rotulos"] = "Rotulos->index";
$routes["/rotulo"] = "Rotulos->cadastro";
$routes["/rotulo/{\d+:id}"] = "Rotulos->cadastro";
$routes["/rotulo/salvar"] = "Rotulos->salvar";


$routes["/espelho"] = "Appplication->espelha";

$routes["/login"] = "Acessos->login";
$routes["/logout"] = "Acessos->logout";
$routes["/login/"] = "Acessos->logar";