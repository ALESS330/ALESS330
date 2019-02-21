<?php

global $corSistema;
global $nomeSistema;
global $tituloSistema;
global $urlSistema;

$nomeUsuario = isset($_SESSION['username']) ? $_SESSION['username'] : "Acessar";
$logado = isset($_SESSION['username']) === TRUE;
$rodapeHuufgd = '© <?= date("Y") ?> Hospital Universitário da UFGD';
$mostrarAcesso = true;

$mostrarAcesso = ((strcmp($_SESSION['request']['CONTROLLER'], "Acessos") == 0) && (strcmp($_SESSION['request']['ACTION'], "login") == 0)) ? false : true;
$mostrarBusca = true;
if (($_SESSION['request']['CONTROLLER'] == "Formularios") && ($_SESSION['request']['CONTROLLER'] == "gerar")) {
    $mostrarBusca = false;
}

$menus = array();
$admin = array();
$usuario = array();

$admin['Datasources->index'] = "Datasources";
$admin['Relatorios->index'] = "Relatórios";
$admin['separador'] = "-";
$admin['Usuarios->index'] = "Usuários";
$admin['Grupos->index'] = "Grupos";
$admin['Sistemas->index'] = "Sistemas";
$admin['Funcionalidades->index'] = "Funcionalidades";

$usuario['Usuarios->ver(' . $nomeUsuario . ')'] = "Meus dados";
$usuario['separador'] = "-";
$usuario['Acessos->logout'] = "Logout";

$menus['<i class="material-icons">settings</i>'] = $admin;
$menus['<i class="material-icons">account_circle</i>'] = $usuario;

$menuResultante = array();
if ($logado) {
    foreach ($menus as $r => $menu) {
        $permissor = new Permissor();
        foreach ($menu as $action => $rotulo) {
            $rota = explode("->", $action);
            if ($rota[0] == "separador") {
                $menuResultante[$r]['-'] = '-';
                continue;
            }
            $controle = $rota[0];
            $acao = explode("(", $rota[1])[0];
            if ($permissor->autoriza($controle, $acao)) {
                $menuResultante[$r][$action] = $rotulo;
            }
        } //itens de menu
        //Se só sobrou o separador, não exibir esse menu.
        if (count($menuResultante[$r]) == 1 && $menuResultante[$r]['-'] == '-') {
            unset($menuResultante[$r]);
        }
    }//foreach $menus
} //if logado

$barra_menu = '';
if ($logado) {
    if ($mostrarBusca) {
        $barra_menu .= '
            <li class="center">
                <nav>
                    <div class="nav-wrapper white grey lighten-4">
                        <form>
                          <div class="input-field div-pesquisa">
                            <input id="search" type="search" placeholder="Pesquisar">
                            <label class="label-icon" for="search"><i class="material-icons icone-pesquisa">search</i></label>
                            <i class="material-icons">close</i>
                          </div>
                        </form>
                    </div>
                </nav> 
            </li>';
    }
    $idDropDown = (1 + count($menus));
    foreach ($menuResultante as $rotulo => $itens) {
        $barra_menu .= '<li><a class="dropdown-trigger" href="#" data-target="dropdown-' . $idDropDown++ . '">' . $rotulo . '</a></li>' . "\n";
    }
} else {//se não logado
    if ($mostrarAcesso) {
        $barra_menu .= '<li><a class="waves-effect" href="@{Acessos->login()}">' . $nomeUsuario . '</a></li>';
    } else {
        $barra_menu .= '';
    }
}

$barra_menu_redimensionado = '';
if ($mostrarBusca) {
    $barra_menu_redimensionado = '<li class="search">
                <div class="input-field card div-input-pesquisa">
                    <input id="search" type="search" placeholder="Pesquisar"><i class="material-icons">search</i>
                        <div class="search-results"></div>
                </div>
            </li>';
}
$idDropDown = 1;
if ($logado) {
    foreach ($menuResultante as $rotulo => $itens) {
        $barra_menu_redimensionado .= '<li><a class="waves-effect dropdown-trigger" href="#" data-target="dropdown-' . $idDropDown++ . '">' . $rotulo . '<i class="material-icons right">arrow_drop_down</i></a></li>' . "\n";
    }
} else {
    $barra_menu_redimensionado .= '<li><a class="waves-effect" href="@{Acessos->login()}">' . $nomeUsuario . '</a></li>';
}

$dropdown_barra_menu_interno = '';
if ($logado) {
    $dropdown_barra_menu_interno = //'<li><a href="' . $linkAcesso . '">' . substr($nomeUsuario, 0, strpos($nomeUsuario, '@')) . '</a></li>' .
            '<li><a href="@{Usuarios->ver(' . $nomeUsuario . ')}">Meus dados</a></li>
            <li class="divider"></li>
            <li><a href="@{Acessos->logout()}">Logout</a></li>';
}

$dropdownAtual = $logado ? '' : '';
global $router;
$idDropDown = 0;
$dropDowns = array();
foreach ($menuResultante as $rotulo => $itens) {
    foreach ($menuResultante[$rotulo] as $action => $rotulo) {
        if ($action == "-") {
            $dropdownAtual .= "\t<li class=\"divider\"></li>\n";
        } else {
            $dropdownAtual .= "\t<li>\n"
                    . "\t\t<a href=\"" . $router->link($action) . '">' . $rotulo . "</a>\n"
                    . "\t</li>\n";
        }
    }
    $dropDowns[$idDropDown++] = $dropdownAtual;
    $dropdownAtual = "";
}