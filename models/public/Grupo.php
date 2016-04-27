<?php

require_once dirname(dirname(dirname(__FILE__))) . '/classes/Model.php';

class Grupo extends Model {
    
    
    
    public function salvar($dados){
        
        $id = $dados["id"];
        $nome = $dados["nome"];
        $descricao = $dados["descricao"];
        $sistema_id = $dados["sistemas_id"];
                       
         if($id){
            //Nesse caso, o curso já existe, é uma alteração
            $sql = "update grupos set nome = '$nome' , sistema_id = $sistema_id, \n"
                    . "descricao = '$descricao' where id = $id";
            
        }else{
            //Nesse caso, o curso não existe, é uma inserção;
            $sql = "INSERT INTO public.grupos(nome, descricao, sistema_id) \n"
                    . "VALUES ('$nome', '$descricao', $sistema_id) \n";
        }

        $result = $this->db->executa($sql);
         
        return $result;
          
        
    }
    
    public function listar(){
        
        $sql = 'select * From public.grupos order by nome';
        
        $result = $this->db->consulta($sql);
         
        return $result;
        
        
    }
    
    public function listarGruposNaoUsuario($ususarioId){
        
        $sql = "select * From public.grupos g where  g.id \n "
                . "not in(select ug.grupo_id From public.usuario_grupo \n"
                . "ug where ug.usuario_id = $ususarioId )";
        
        $result = $this->db->consulta($sql);
        
        return $result;
                              
    }
    
    public function listarGrupoUsuario($usuarioId){
        
        $sql = "select ug.id,  g.id as idGrupo, g.nome From public.usuario_grupo ug \n"
                . "inner join public.grupos g on (g.id = ug.grupo_id) \n"
                . "where ug.usuario_id = $usuarioId";
        
        $result = $this->db->consulta($sql);
        

        return $result;
        
    }
    
    public function buscaPorId($id){
      
        $sql = "select * From grupos where id = $id";
        
        $result = $this->db->consulta($sql);
               
        return $result;
        
    }
    
  

}
