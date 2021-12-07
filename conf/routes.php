<?php

$routes = array();

$routes["/"] = "Appplication->index";
$routes['/printer'] = "Appplication->printers";
$routes['/pdf'] = "Appplication->pdf_me";


$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}/print"] = "Relatorios->toPDF('\$datasource','\$nomeRelatorio')";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}.pdf"] = "Relatorios->gerarPdf('\$datasource','\$nomeRelatorio')";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}/pdf"] = "Relatorios->gerarPdf('\$datasource','\$nomeRelatorio')";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}/excel"] = "Relatorios->gerarExcel('\$datasource','\$nomeRelatorio')";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}/csv"] = "Relatorios->gerarCsv('\$datasource','\$nomeRelatorio')";
$routes["/relatorio/{\w+:datasource}/{.+:nomeRelatorio}"] = "Relatorios->gerar('\$datasource','\$nomeRelatorio')";
$routes["/relatorios"] = "Relatorios->index()";
$routes["/relatorio/{\d+:idRelatorio}/tela-parametros/salvar"]  = "Relatorios->salvarTelaParametros(\$idRelatorio)";
$routes["/relatorio/{\d+:idRelatorio}/composicao/salvar"]  = "Relatorios->salvarComposicao(\$idRelatorio)";
$routes["/relatorio/{\d+:idRelatorio}/composicao/{\d+:idComposicao}/excluir"]  = "Relatorios->excluirComposicao(\$idRelatorio)";
$routes['/relatorio/{\d+:idRelatorio}/formatos/salvar'] = "Relatorios->salvarFormatos(\$idRelatorio)";
$routes['/relatorio-categoria-salvar-{\d+:idRelatorio}-{\d+:idCategoria}'] = "Relatorios->salvarCategoria(\$idRelatorio,\$idCategoria)";
$routes['/relatorio-categoria-remover-{\d+:idRelatorio}-{\d+:idCategoria}'] = "Relatorios->removerCategoria(\$idRelatorio,\$idCategoria)";
$routes['/relatorio/{\d+:idRelatorio}/decoradores/salvar'] = "Relatorios->salvarDecoradores(\$idRelatorio)";
$routes['/relatorio/{\d+:idRealtorio}/grupo/{\d+:idGrupo}/associa'] = "Relatorios->associaGrupo(\$idRelatorio)";
$routes['/relatorio/{\d+:idRealtorio}/grupo/{\d+:idGrupo}/remove'] = "Relatorios->removeGrupo(\$idRelatorio,\$idGrupo)";
$routes["/relatorio-propriedades-{\d+:idRelatorio}"] = "Relatorios->propriedades(\$idRelatorio)";
$routes["/relatorio/{\d+:idRelatorio}/excluir"] = "Relatorios->excluir(\$idRelatorio)";
$routes["/relatorio/{\d+:idRelatorio}"] = "Relatorios->cadastro(\$idRelatorio)";
$routes["/relatorio/novo"] = "Relatorios->novo()";
$routes["/relatorios/salvar"] = "Relatorios->salvar()";
$routes['/relatorios/gerado/{.+:datasource}/{.+:nomeRelatorio}'] = "Relatorios->gerado('\$datasource','\$nomeRelatorio')";
$routes["/relatorios/{\d+:pagina}/{.+:busca}"] = "Relatorios->pagina(\$pagina,'\$busca')";
$routes["/relatorios/{\d+:pagina}/"] = "Relatorios->pagina(\$pagina)";
$routes["/parametro/{\d+:parametroId}"] = "Parametros->ver(\$parametroId)";
$routes["/parametros/salvar"] = "Parametros->salvar()";

$routes['/relatorio/download-html-pdf'] = "Relatorios->downloadHtmlAsPDF()";
$routes['/relatorio/download-html'] = "Relatorios->printHTML()";

$routes["/datasources"] = "Datasources->index()";
$routes["/datasource"] = "Datasources->cadastro()";
$routes["/datasource/{\d+:id}"] = "Datasources->cadastro(\$id)";
$routes["/datasource/salvar"] = "Datasources->salvar()";

$routes["/categorias"] = "Categorias->index()";
$routes["/categoria"] = "Categorias->cadastro()";
$routes["/categoria/{\d+:id}"] = "Categorias->cadastro(\$id)";
$routes["/categoria/salvar"] = "Categorias->salvar()";

$routes["/rotulos"] = "Rotulos->index()";
$routes["/rotulo"] = "Rotulos->cadastro()";
$routes["/rotulo/{\d+:id}"] = "Rotulos->cadastro(\$id)";
$routes["/rotulo/salvar"] = "Rotulos->salvar()";

$routes["/espelho"] = "Appplication->espelha()";
