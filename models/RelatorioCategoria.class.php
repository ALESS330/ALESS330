<?php

class RelatorioCategoria extends Model {

    function __construct() { 
        parent::__construct();
        $this->nomeTabela = "relatorios.relatorio_categoria";
    }

//     function getLocalEstoque($codigoUF){
//         $lista = $this->selectBy(["codigo_uf_aghu " => $codigoUF]);
//         if(count($lista)){
//             $oUsuario = new Usuario();
//             foreach($lista as $ufd){
//                 $usuario = $oUsuario->get($ufd->usuario_id);
//                 $ufd->usuario = $usuario;
//             }
//         }
//         return $lista;
//     }

//     function getUnidades(){
//         $sql = 
//         "
// select distinct
//     codigo_uf_aghu uf
// from 
//     $this->nomeTabela        
//         ";
//         $lista = $this->db->consulta($sql);
//         $retorno = array_map(function($unidade){
//             return $unidade->uf;
//         }, $lista);
//         return $retorno;
//     }

}