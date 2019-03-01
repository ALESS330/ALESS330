<?php

$admin['Datasources->index'] = "Datasources";
$admin['Relatorios->index'] = "Relatórios";
$admin['separador'] = "-";
$admin['Usuarios->index'] = "Usuários";
$admin['Grupos->index'] = "Grupos";
$admin['Sistemas->index'] = "Sistemas";
$admin['Funcionalidades->index'] = "Funcionalidades";

$menuUsuario['Usuarios->ver(' . $nomeUsuario . ')'] = "Meus dados";
$menuUsuario['separador'] = "-";
$menuUsuario['Acessos->logout'] = "Logout";

$menus['<i class="material-icons">settings</i><span class="hide-on-large-only truncate">Administração</span>'] = $admin;
$menus['<i class="material-icons">account_circle</i><span class="hide-on-large-only truncate">' . $nomeUsuario . '</span>'] = $menuUsuario;