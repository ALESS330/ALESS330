<?php

$admin['tooltip'] = "Administração"; // [action] = "rotulo"
$admin['Datasources->index'] = "Datasources";
$admin['Categorias->index'] = "Categorias";
$admin['Relatorios->index'] = "Relatórios";
$admin['separador'] = "-";
$admin['Pessoas->index'] = "Pessoas";
$admin['Usuarios->index'] = "Usuários";
$admin['Grupos->index'] = "Grupos";
$admin['Sistemas->index'] = "Sistemas";
$admin['Funcionalidades->index'] = "Funcionalidades";

$menuUsuario['tooltip'] = "Menu do usuário";
$menuUsuario['Usuarios->ver(' . $nomeUsuario . ')'] = "Meus dados";
$menuUsuario['separador'] = "-";
$menuUsuario['Acessos->logout'] = "Logout";

$menus['settings'] = $admin; // icone do material-icons
$menus['account_circle'] = $menuUsuario;

$rotulosMobile['settings'] = 'Administração';
$rotulosMobile['account_circle'] = $nomeUsuario;
