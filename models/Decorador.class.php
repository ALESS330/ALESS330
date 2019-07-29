<?php

/**
 * Description of Decorador
 *
 * @author marcos
 */
class Decorador extends Model {

    public function __construct() {
        parent::__construct();
        $this->nomeTabela = "relatorios.decoradores";
    }

    public function decoradores($relatorioId) {
        $sql = "
    	select 
            d.*
            , t.nome tipo_decorador
            , t.descricao descricao_decorador
	from 
            relatorios.decoradores d
            join relatorios.tipos_decoradores t on t.id = d.tipo_decorador_id
	where true 
            and d.relatorio_id = $relatorioId
            and d.ativo
	order by
            d.ordem desc
";
        $lista = $this->db->consulta($sql);
        if (count($lista)) {
            return $lista;
        }
        return false;
    }

    public function decorar($dados, $decoradores) {
        $campos = array_keys($dados['0']);
        $indicesCampos = [];
        //buscar os indices dos campos nas respectivas linhas
        foreach ($decoradores as $i => $decorador) {
            foreach ($campos as $j => $campo) {
                if ($campo == $decorador->nome_campo) {
                    $indicesCampos[$j] = $campo;
                }// if
            }//foreach campo
        }//foreach decoradores
        $novosDados = array();
        foreach ($dados as $linha) {
            $linhaDecorada = $this->decoraLinha($linha, $decoradores);
            if ($linhaDecorada) {
                $novosDados[] = $linhaDecorada;
            }
        }//dados
        return $novosDados;
    }

    public function decoraLinha($linha, $decoradores) {
        $decorador = array_pop($decoradores);
        $novaLinha = $linha;
        foreach ($linha as $coluna => $valorCampo) {
            $novaLinha[$coluna] = $this->decoraValor($decorador, $valorCampo, $coluna, $novaLinha);
        }
        if (count($decoradores)) {
            $novaLinha = $this->decoraLinha($novaLinha, $decoradores);
        }
        return $novaLinha;
    }

    public function decoraValor($decorador, $valorCampo, $coluna, $linha) {
        if ($decorador->tipo_decorador == "remover-linha" && $valorCampo == $decorador->parametro) {
            return false;
        }//if
        $decorar = false;
        if ($coluna == $decorador->nome_campo) {
            $decorar = true;
        }
        if ($decorar) {
            return $this->decora($valorCampo, $decorador, $linha);
        } else {
            return $valorCampo;
        }
    }

    public function decora($valorCampo, $decorador, $linha) {
        $decorado = "";
        switch ($decorador->tipo_decorador) {
            case "remover":
                $decorado = $this->decoraComRemocao($valorCampo, $decorador->parametro, $linha);
            case "link":
                $decorado = $this->decoraComLink($valorCampo, $decorador->parametro, $linha);
                break;
            case "envelope";
                $decorado = $this->decoraComEnvelope($valorCampo, $decorador->parametro, $linha);
                break;
            case "tag";
                $decorado = $this->decoraComTag($valorCampo, $decorador->parametro, $linha);
                break;
            case "data";
                $decorado = $this->decoraComData($valorCampo, $decorador->parametro, $linha);
                break;
            default:
                $decorado = "Falha na decoração desse valor: $valorCampo";
                break;
        } //switch
        return $decorado;
    }

//decora

    public function decoraComLink($valorDecorar, $parametro, $linha) {
        preg_match_all("/[$](\w+)/", $parametro, $camposEncontrados);
        foreach ($camposEncontrados[1] as $campo) {
            $parametro = str_replace('$' . $campo, $linha[$campo], $parametro);
        }
        $link = "<a href='$parametro'>$valorDecorar</a>";
        return $link;
    }

//decoraComLink

    public function decoraComRemocao($valorDecorar, $parametro) {
        return "Eu $valorDecorar lamento dizer que serei removido";
    }

//decoraComRemocao

    public function decoraComEnvelope($valorDecorar, $parametro, $linha) {
        return $this->decoraComTag($valorDecorar, $parametro, $linha);
    }

//decoraComEnvelope

    public function decoraComTag($valorDecorar, $parametro, $linha) {
        $chaves = explode(",", $parametro);
        if (count($chaves) == 1) {
            $chaveAbrir = $chaveFechar = $chaves[0];
        } else if (count($chaves) == 2) {
            $chaveAbrir = $chaves[0];
            $chaveFechar = $chaves[1];
        } else {
            throw new Exceptin("Parâmetros demais para tipo de decorator com chaves");
        }
        return "$chaveAbrir$valorDecorar$chaveFechar";
    }

    public function decoraComData($valorDecorar, $parametro, $linha) {
        if (trim($valorDecorar)) {
            $parsed = date_parse($valorDecorar);
            $miliseconds = mktime(0, 0, 0, $parsed['month'], $parsed['day'], $parsed['year']);
            $formated = date($parametro, $miliseconds);
            return $formated;
        }
        return "";
    }

//decoraComData
}

//class
