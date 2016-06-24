<?php

require_once 'ConstrutorRelatorios.php';

/**
 * Description of GeradorRelatorio
 *
 * @author marcos
 */
class GeradorRelatorio {

    function geraCelula($conteudo) {
        return "                    <td>$conteudo</td>\n";
    }

    function geraLinha($celulas) {
        $linha = "                <tr>\n";
        foreach ($celulas as $celula) {
            $linha .= $this->geraCelula($celula);
        }
        $linha .= "                </tr>\n";
        return $linha;
    }

    function geraCorpoTabela($linhas) {

        $tbody = "            <tbody>\n";
        foreach ($linhas as $linha) {
            $tbody .= $this->geraLinha($linha);
        }
        $tbody .= "            </tbody>\n";
        return $tbody;
    }

    function geraCabecalho(&$dados) {

        $linha = $dados[0];
        if (isset($dados["titulo"])) {
            $titulo = $this->getTituloRelatorio($dados["titulo"], "titulo-internacoes-unidade");
            unset($dados["titulo"]);
        }
        if (func_num_args() == 2) {
            $grupo = func_get_arg(1);
            unset($linha[$grupo]); // = null;
        }

        $colunas = count($linha);
        $ths = "";
        if (isset($grupo)) {
            //$titulo = $this-.getTitulo($)
            $ths .= "                <tr>\n";
            $ths .= "                    <th colspan=\"$colunas\">\n";
            $ths .= "                        $titulo\n";
            $ths .= "                    </th>\n";
            $ths .= "                </tr>\n";
        }
        $ths .= "                <tr>\n";
        foreach ($linha as $campo => $valor) {
            $campoRotulado = $this->getRotulo($campo);
            $ths .= "                    <th>$campoRotulado</th>\n";
        }
        return "            <thead>\n"
                //. "                <tr>\n"
                . $ths
                . "                </tr>\n"
                . "            </thead>\n";
    }

    function geraRodape($dados) {
        $totalLinhas = count($dados);
        $totalColunas = count($dados[0]);

        $rodape = "            <tfoot>\n";
        $rodape .= "                <tr>\n";
        $rodape .= "                     <td colspan=\"$totalColunas\">Total de Linhas: $totalLinhas</td>\n";
        $rodape .= "                </tr>\n";
        $rodape .= "            </tfoot>\n";

        return $rodape;
    }

    function geraTabela($dados, $colunaGrupo) {
        $class = "";
        if (isset($colunaGrupo)){
            $class =" quebrar-pagina ";
        }
        $tabela = "        <table class=\"$class bordered highlight hoverable responsive-table\" cellpadding=\"0\" cellspacing=\"0\">\n";
        if (isset($colunaGrupo)) {
            $tabela .= $this->geraCabecalho($dados, $colunaGrupo);
        } else {
            $tabela .= $this->geraCabecalho($dados);
        }
        $tabela .= $this->geraRodape($dados);
        $tabela .= $this->geraCorpoTabela($dados);
        $tabela .= "        </table>\n";
        return $tabela;
    }

    function geraTabelaGrupo($dados, $colunaGrupo) {
        $grupo = $dados[0][$colunaGrupo];
        $tabelaAtual = array();
        $tabelas = array();
        foreach ($dados as $linha) {
            if ($linha["grupo"] == $grupo) {
                unset($linha[$colunaGrupo]);
                $tabelaAtual[] = $linha;
            } else {
                $tabelas[$grupo] = $tabelaAtual;
                $tabelas[$grupo]["titulo"] = $grupo;
                $grupo = $linha["grupo"];
                unset($tabelaAtual);
                unset($linha[$colunaGrupo]);
                $tabelaAtual[] = $linha;
            }
        }

        $codigoTabelas = "";
        foreach ($tabelas as $novaTabela) {
            $codigoTabelas .= $this->geraTabela($novaTabela, $colunaGrupo);
        }
        return $codigoTabelas;
    }

    function getTituloRelatorio($parametro, $relatorioFilho) {
        $r = new ConstrutorRelatorios();                  
        return $r->getTituloRelatorio($relatorioFilho, $parametro);
    }

    function getRotulo($campo) {
        $rotulos["grupo"] = "Grupo";
        $rotulos["id_user"] = "Id do Usuário";
        $rotulos["nome_usuario"] = "Nome";
        $rotulos["login_user"] = "Login";
        $rotulos["numero_linha"] = "#";
        $rotulos["nome"] = "Nome";
        $rotulos["numero_usuarios"] = "Número de usuários";
        $rotulos["bairro"] = "Bairro do endereço";

        return isset($rotulos[$campo]) ? $rotulos[$campo] : $campo;
    }

}
