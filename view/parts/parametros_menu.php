<?php

global $corSistema;
global $nomeSistema;
global $tituloSistema;
$nomeUsuario = $_SESSION['username'] ? : "Acessar";
$logado = $_SESSION['username'] ? TRUE : FALSE;
$rodapeHuufgd = '2016 Hospital Universitário da UFGD';
$linkAcesso = $logado ? "#" : "@{Acesso->login()}";

$barra_menu = '';
            //<li class="item-barra-menu"><a class="waves-effect dropdown-button" href="#" data-activates="dropdown3">' . $nomeSistema . '<i class="mdi-navigation-arrow-drop-down right"></i></a></li>'
        ;
if ($logado) {
    $barra_menu .= '<li class="' . $corSistema . ' search">
            <div class="nav-wrapper">
                <div class="input-field">
                  <input class="search-barra-menu" id="search" type="search" required>
                  <label for="search"><i class="material-icons icone-pesquisa">search</i></label>
                  <i class="material-icons">close</i>
                </div>
            </div>
          </li> ';
    $barra_menu .= '<li class="item-barra-menu"><a class="waves-effect dropdown-button" href="#" data-activates="dropdown5">Cadastros</a></li>';
    $barra_menu .= '<li class="item-barra-menu"><a class="waves-effect dropdown-button" href="#" data-activates="dropdown1">' . $nomeUsuario . '</a></li>';
}else{
    $barra_menu .='<li class="item-barra-menu"><a class="waves-effect" href="@{Acesso->login()}">' . $nomeUsuario . '</a></li>';
}


$barra_menu_redimensionado = '<li class="search">
                <div class="input-field card div-input-pesquisa">
                    <input id="search" type="search" placeholder="Pesquisar"><i class="material-icons">search</i>
                        <div class="search-results"></div>
                </div>
            </li>
            <li><a class="waves-effect dropdown-button" href="#" data-activates="dropdown4">' . $nomeSistema . '</a></li>';
if($logado){
    $barra_menu_redimensionado .= '<li><a class="waves-effect dropdown-button" href="#" data-activates="dropdown6">Cadastros</a></li>';
}
$barra_menu_redimensionado .= '<li><a class="waves-effect dropdown-button" href="#" data-activates="dropdown2">' . $nomeUsuario . '</a></li>';

$dropdown_barra_menu_interno = '';
if ($logado){
    $dropdown_barra_menu_interno = '<li><a href="'. $linkAcesso . '">' . $nomeUsuario . '</a></li><li><a href="@{Usuarios->ver('.$nomeUsuario.')}">Meus dados</a></li>
        <li class="divider"></li>
        <li><a href="@{Acesso->logout()}">Logout</a></li>';
}
        

$dropdown_barra_menu_cadastros = $logado ? '
        <li><a href="@{Datasources->index()}">Datasources</a></li>
        <li><a href="@{Relatorios->index()}">Relatórios</a></li>' : '';

//$dropdown_barra_menu_cadastros = $logado ? '<li><a href="@{Instituicoes->listar(1,3)}">Instituições</a></li>
//        <li><a href="@{Cursos->index()}">Cursos</a></li>
//        <li><a href="@{Pessoas->index()}">Pessoas</a></li>           
//        <li><a href="@{Alunos->index()}">Alunos</a></li>
//        <li><a href="@{Turmas->index()}">Turmas</a></li>     
//        <li><a href="@{Supervisores->index()}">Supervisores</a></li>     
//        <li><a href="@{Grupos->index()}">Grupos</a></li>
//        <li><a href="@{SubGrupos->index()}">Sub-Grupos</a></li>
//        <li><a href="@{Areas->index()}">Áreas</a></li>
//        <li><a href="@{SubAreas->index()}">Sub-Áreas</a></li>
//        <li><a href="@{Especialidades->index()}">Especialidades</a></li>
//        <li><a href="@{Roteiros->index()}">Roteiros</a></li>' : '';

$dropdown_barra_menu_modulos = '<li><a href="#!">' . $nomeSistema . '</a></li>
        <li><a href="/ensino">Ensino</a></li>
        <li><a href="/repositorio">Repositório</a></li>
        <li><a href="/pacs">Worklist</a></li>
        <li><a href="http://sistemas.hu.ufgd.edu.br:9000/formulario">Formulário</a></li>';
