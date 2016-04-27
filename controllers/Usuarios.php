<?php

$_CONTROLE = 'Usuarios';
$_ROTULO = 'Usuários';

class Usuarios extends Controller {

    private $usuario;
    
    public function __construct() {
        parent::__construct();
        $this->usuario = new Usuario();
    }
    
    public function listar() {
        $usuario = new Usuario('');
        $usuarios = $usuario->listar();
        $dados["usuarios"] = $usuarios;
        parent::render($dados);
    }

    public function cadastro() {

        $pessoa = new Pessoa();
        if (isset($_POST["grupoInclusao"])) {
            $grupoInclusao = $_POST["grupoInclusao"];
            $userName = $grupoInclusao["username"];
            $usuarios = new Usuario($userName);
            $result = $usuarios->incluirGrupo($grupoInclusao);
        }

        if (isset($_POST["funcionalidadeInclusao"])) {
            $funcionalidadeInclusao = $_POST["funcionalidadeInclusao"];
            $userName = $funcionalidadeInclusao["username"];
            $usuarios = new Usuario($userName);
            $result = $usuarios->incluirFuncionalidade($funcionalidadeInclusao);
        }

        if (isset($_GET["idRelGrupo"])) {

            $idGrupo = $_GET["idRelGrupo"];

            $usuarios = new Usuario("");

            $result = $usuarios->excluirGrupo($idGrupo);
        }

        if (isset($_GET["idRelFuncionalidade"])) {

            $idFuncionalidade = $_GET["idRelFuncionalidade"];

            $usuarios = new Usuario("");

            $result = $usuarios->excluirFuncionalidade($idFuncionalidade);
        }

        if (isset($_GET["id"])) {



            $id = $_GET["id"];

            $usuarios = new Usuario("");
            $grupo = new Grupo();
            $funcionalidade = new Funcionalidade();

            $usuario = $usuarios->buscarPorId($id);
            $grupos = $grupo->listarGruposNaoUsuario($id);
            $gruposUsuario = $grupo->listarGrupoUsuario($id);
            $funcionalidades = $funcionalidade->funcionalidadeNaoUsuario($id);
            $funcionalidadesUsuario = $funcionalidade->funcionalidadeUsuario($id);

            $pessoaId = $usuario[0]->pessoa_id;

            $pessoas = $pessoa->buscaPessoasSemUsuario($pessoaId);

            $dados["usu"] = $usuario;
            $dados["gruposUsuario"] = $gruposUsuario;
            $dados["grupos"] = $grupos;
            $dados["funcionalidades"] = $funcionalidades;
            $dados["funcionalidadesUsuario"] = $funcionalidadesUsuario;
        } else {

            $pessoas = $pessoa->buscaPessoasSemUsuario(0);
        }

        $dados["pessoas"] = $pessoas;
        parent::render($dados);
    }

    public function salvar() {

        $dados = $_POST["usuario"];
        $usuario = new Usuario('');
        $result = $usuario->salvar($dados);

        if ($result === TRUE) {
            $_SESSION['mensagem']['sucesso'] = "Usuário salvo com sucesso!";
            parent::go2("Usuarios->index");
        } else {

            if (!isset($_SESSION['mensagem']['erro'])) {
                $_SESSION['mensagem']['erro'] = "Erro ao tentar salvar usuário, tente novamente!";
            }
            parent::go2("");
        }
    }

    public function ver($username) {
        $dados = array();
        $this->usuario->setUsername($username);
        $dados['usuario'] = $this->usuario->getUsuario();
        parent::render($dados);
    }

}
