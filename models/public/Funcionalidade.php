<?php

class Funcionalidade extends Model {

    public function getGrupos($funcionalidade) {
        $sql = "SELECT g.nome FROM \n"
                . " public.funcionalidades f "
                . " INNER JOIN funcionalidade_grupo fg ON fg.funcionalidade_id = f.id \n"
                . " INNER JOIN public.grupos g ON g.id = fg.grupo_id \n"
                . " WHERE f.funcionalidade = '$funcionalidade'"
//                . " AND f.id NOT IN ("
//                . "     SELECT f.id FROM "
//                . "         public.funcionalidades f "
//                . "         INNER JOIN public.bloqueio_funcionalidade b ON f.id = b.funcionalidade_id "
//                . "     WHERE f.funcionalidade = '$funcionalidade'"
//                . " )";
                . "";
        $grupos = $this->db->consulta($sql);
        return $grupos;
    }

    public function getArrayGrupos($funcionalidade) {
        $gruposFuncionalidade = $this->getGrupos($funcionalidade);
        $grupos = array();
        if (count($gruposFuncionalidade)) {
            foreach ($gruposFuncionalidade as $grupo => $nome) {
                array_push($grupos, $nome->nome);
            }
        }
        return $grupos;
    }

    public function listar() {
        $sql = 'select * From public.funcionalidades order by funcionalidade';
        $result = $this->db->consulta($sql);
        return $result;
    }

    public function salvar($dados) {
        $id = $dados["id"];
        $funcionalidade = $dados["funcionalidade"];
        $descricao = $dados["descricao"];
        $sistemas_id = $dados["sistemas_id"];

        if ($id) {
            //Nesse caso, o curso já existe, é uma alteração
            $sql = "update funcionalidades set funcionalidade = '$funcionalidade' , \n"
                    . "sistema_id = $sistemas_id, descricao = '$descricao' "
                    . "where id = $id";
        } else {
            //Nesse caso, o curso não existe, é uma inserção;
            $sql = "INSERT INTO public.funcionalidades(funcionalidade, descricao, sistema_id) \n"
                    . "VALUES ('$funcionalidade', '$descricao', $sistemas_id) \n";
        }
        $result = $this->db->executa($sql);
        return $result;
    }

    public function buscaPorId($id) {
        $sql = "select * From funcionalidades  where id = $id";
        $result = $this->db->consulta($sql);
        return $result;
    }

    public function funcionalidadeNaoUsuario($idUsuario) {
        $sql = "select * From public.funcionalidades f where f.id \n"
                . " NOT IN (select funcionalidade_id From \n"
                . "public.funcionalidade_usuario fu where \n"
                . "fu.usuario_id ='$idUsuario')";
        $result = $this->db->consulta($sql);
        return $result;
    }

    public function funcionalidadeUsuario($idUsuario) {
        $sql = "select fu.id id_rel, f.funcionalidade,  f.descricao, \n"
                . " f.id From public.funcionalidades f \n"
                . "inner join public.funcionalidade_usuario fu \n"
                . "on (fu.funcionalidade_id = f.id) where fu.usuario_id = $idUsuario";

        $result = $this->db->consulta($sql);
        return $result;
    }

    public function bloqueada($funcionalidade) {
        $sql = "
SELECT 
    f.id = f.id as bloqueada
FROM
    public.funcionalidades f 
    INNER JOIN public.bloqueio_funcionalidade b ON b.funcionalidade_id = f.id
WHERE
    f.funcionalidade = '$funcionalidade'";
        $result = $this->db->consulta($sql);
        if ($result){
            return TRUE;
        }
        return FALSE;
    }

}
