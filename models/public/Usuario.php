<?php

class Usuario extends Model {

    private $usuario;
    private $username;

    public function __construct($username = NULL) {
        parent::__construct();
        if ($username) {
            $this->username = $username;
            $this->usuario = $this->getUsuario($username);
        }
    }
    
    public function setUsername($username) {
        $this->username = $username;
    }
    
    public function getUsuario() {
        $sql = "
select
    p.id as pessoa_id, 
    p.nome,
    p.data_nascimento,
    p.email,
    p.email_institucional,
    p.cpf,
    p.masculino,
    u.id as usuario_id,
    u.username
FROM
    public.pessoas p 
    INNER JOIN usuarios u ON u.pessoa_id = p.id
WHERE u.username = '$this->username'";
        $lista = $this->db->consulta($sql);
        return count($lista) ? $lista[0] : NULL;
    }

    public function getUsername() {
        return $this->getUsuario()['username'];
    }

    public function getGrupos() {
        $sql = "  
SELECT DISTINCT
    g.nome
FROM 
    public.grupos g 
    INNER JOIN public.usuario_grupo ug ON g.id = ug.grupo_id 
    LEFT JOIN public.usuarios u ON u.id = ug.usuario_id
WHERE
    u.username = '".$this->username."'";
        $grupos = $this->db->consulta($sql);
        return $grupos;
    }

    public function getArrayGrupos() {
        $gruposUser = $this->getGrupos();
        $grupos = array();
        foreach ($gruposUser as $grupo => $nome) {
            array_push($grupos, $nome->nome);
        }
        return $grupos;
    }

    public function listar() {

        $sql = " select u.*, p.nome pessoa_nome From public.usuarios u \n"
                . "inner join public.pessoas p on (p.id = u.pessoa_id) \n"
                . " order by u.username ";

        $result = $this->db->consulta($sql);

        return $result;
    }

    public function isDeveloper() {
        
        $username = $this->username;
        
         $sql = "
SELECT
    count(u.id) = 1 as is_developer 
FROM public.usuarios u 
    INNER JOIN public.usuario_grupo ug ON ug.usuario_id = u.id 
    INNER JOIN public.grupos g ON g.id = ug.grupo_id
    INNER JOIN public.sistemas s ON s.id = g.sistema_id 
WHERE
    g.nome = 'developer' 
AND u.username = '$username'\n";
        $result = $this->db->consulta($sql)[0]->is_developer;
        return $result;
    }

    public function buscarPorId($id) {

        $sql = "select * From public.usuarios u where u.id = $id";

        $result = $this->db->consulta($sql);

        return $result;
    }

    public function incluirGrupo($grupo) {

        $grupoId = $grupo["grupoId"];
        $usuarioId = $this->usuario->id;
        
        $sql = "INSERT INTO public.usuario_grupo (usuario_id, grupo_id) \n"
                . " VALUES ( $usuarioId, $grupoId )";

        $result = $this->db->executa($sql);
        
        return $result;
    }
    
    public function excluirGrupo($idGrupo){
        
        $sql = "delete from public.usuario_grupo where id = $idGrupo";
        
        $result = $this->db->executa($sql);
               
        return $result;
        
    }
 
    public function incluirFuncionalidade($funcionalidade) {

        $funcionalidadeId = $funcionalidade["funcionalidadeId"];
        $usuarioId = $this->usuario->id;
        
        $sql = "INSERT INTO public.funcionalidade_usuario (usuario_id, funcionalidade_id) \n"
                . " VALUES ( $usuarioId, $funcionalidadeId )";

        $result = $this->db->executa($sql);
        
        return $result;
    }
    
    public function excluirFuncionalidade($idFuncionalidade){
        
        $sql = "delete from public.funcionalidade_usuario where id = $idFuncionalidade";
        
        $result = $this->db->executa($sql);
               
        return $result;
        

    }
  
    
    public function salvar($dados){
        
        $id = $dados["id"];
        $username = $dados["username"];
        $senha = $dados["senha"];
        $confirmaSenha = $dados["confirmaSenha"];
        $pessoaId = $dados["pessoaId"];
        
        
        
        if ($senha != $confirmaSenha){
            
            return false;    
        }
        
        if ($id){
            
            $sql = "update public.usuarios set username = '$username' , \n"
                    . "senha = '$senha', pessoa_id = $pessoaId \n"
                    . "where id = $id";
            
        }else{
        
            $sql = "INSERT INTO public.usuarios (username, senha, pessoa_id) \n"
                    . "values('$username', '$senha', $pessoaId)";
        }
        
        $result = $this->db->executa($sql);
               
        return $result;
    }
    
}
