#{botoes}
<div class="fixed-action-btn no-print">
    <button class="btn-floating btn-large red" id="bt-imprimir" title="Imprimir" onclick="window.print();">
        <i class="material-icons">local_printshop</i>
    </button>
</div>
#{/botoes}
<?php
$termo = $dados[0];
foreach ($termo as $variavel => $valor) {
    $$variavel = $valor ?: ""; // $termo['$nome'] para $nome
}

if ($email_particular == "") {
    ("E-mail particular não cadastrado no cadastro de pessoa no AGHU.");
}
setlocale(LC_ALL, 'pt_BR.UTF-8');

$meses['01'] = "janeiro";
$meses['02'] = "fevereiro";
$meses['03'] = "março";
$meses['04'] = "abril";
$meses['05'] = "maio";
$meses['06'] = "junho";
$meses['07'] = "julho";
$meses['08'] = "agosto";
$meses['09'] = "setembro";
$meses['10'] = "outubro";
$meses['11'] = "novembro";
$meses['12'] = "dezembro";

$dia = strftime('%d de ');
$mes = $meses[strftime('%m')];
$ano = strftime(' de %Y');

$data = $dia . $mes . $ano;

global $filename;
$filename = "termo-responsabilidade-" . $nome;

$cpfInteiro = str_pad($cpf, 11, "0", STR_PAD_LEFT); // mantem os numeros de cpf com 11 digitos
$maskCPF = "/(\d{3})(\d{3})(\d{3})(\d{2})/";
$arrayCPF = array();
$matches = preg_match_all($maskCPF, $cpfInteiro, $arrayCPF); // insere os resultados obtidos com maskCPF e cpfInteiro e insere no array
$cpfResultante = $arrayCPF[1][0] . "." . $arrayCPF[2][0] . "." . $arrayCPF[3][0] . "-" . $arrayCPF[4][0];

// funcao que deixa preposicoes e conjuncoes com a primeira letra minuscula
function titleCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("de", "da", "dos", "das", "do", "com"))
{
    $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
    foreach ($delimiters as $dlnr => $delimiter) {
        $words = explode($delimiter, $string);
        $newwords = array();
        foreach ($words as $wordnr => $word) {
            if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
                $word = mb_strtoupper($word, "UTF-8");
            } elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
                $word = mb_strtolower($word, "UTF-8");
            } elseif (!in_array($word, $exceptions)) {
                $word = ucfirst($word);
            }
            array_push($newwords, $word);
        }
        $string = join($delimiter, $newwords);
    } // foreach
    return $string;
}
?>

<style>
    body {
        font-family: 'Google Sans' !important;
    }

    /* h4 {
        font-size: 21pt;
    } */

    h5 {
        font-size: 14pt;
    }

    div.texto {
        margin-top: 40px !important;
    }

    .texto,
    h5 {
        margin: 0;
        padding: 0;
        border: 0;
    }

    .texto p {
        text-align: justify;
        text-indent: 1cm !important;
        font-size: 11pt;
        /*            line-height: 1.1em;*/
    }

    h1,
    h2,
    h3,
    h4,
    h5 {
        text-align: center;
    }

    .titulo-termo {
        margin-top: 0.5cm !important;
        line-height: 0.5em !important;
    }

    .conteudo {
        width: 190mm;
        margin: 0 auto;
        margin-top: 15px;
        box-shadow: 0 0.5px 3px 0.5px grey;
        padding: 5mm 10mm 5mm 10mm;
    }

    .page-footer {
        margin-top: 20px;
        padding-top: 0;
    }

    .assinaturas div {
        text-align: center;
        margin: 1.5cm 2cm 0 2cm;
        border-top: solid 1px black !important;
    }

    .assinatura-chefia {
        padding-bottom: 50px !important;
    }

    .assinatura-rede {
        float: left;
        padding-right: 10px;
        border-top: solid 1px black !important;
        width: 45%;
        text-align: center;
    }

    .assinatura-perfil {
        float: right;
        border-top: solid 1px black !important;
        width: 45%;
        text-align: center;
    }

    ol {
        text-align: justify !important;
        padding-inline-start: 40px !important;
    }

    fieldset.fieldset-cadastradores {
        border: solid 1px grey !important;
        box-shadow: none !important;
        border-radius: 4px;
        margin: 0 auto;
        padding: 20px !important;
        padding-top: 1.8cm !important;
    }

    fieldset.fieldset-cadastradores legend {
        font-size: 11pt !important;
        margin-bottom: 20px !important;
        top: 0;
    }

    .dados li {
        list-style-type: none;
    }

    .rodape-documento {
        display: none;
    }

    @media print {
        @page {
            margin: 0 !important;
        }

        body {
            font-family: Roboto !important;
            /* margin-top: 1mm;
            margin-bottom: 5mm; */
        }

        fieldset.fieldset-cadastradores {
            border: solid 1px grey !important;
            box-shadow: none !important;
            border-radius: 4px;
            margin: 0 auto;
            padding: 20px;
            padding-top: 1.8cm;
        }

        fieldset.fieldset-cadastradores legend {
            font-size: 11pt !important;
            margin-bottom: 20px !important;
            top: 0;
        }

        .conteudo {
            box-shadow: none;
            margin-top: 0px;
            padding-top: 2.5mm !important;
        }

        h4,
        h5 {
            margin: 0.5mm;
        }

        h4 {
            font-size: 24pt !important;
        }

        h5 {
            font-size: 12pt !important;
        }

        div.texto {
            margin-top: 10px;
        }

        .texto p {
            font-size: 12pt;
        }

        ol {
            padding-inline-start: 40px !important;
            font-size: 12pt !important;
        }

        .rodape-documento {
            display: block;
            margin-left: 10mm !important;
            font-size: 7pt !important;
        }

        .hospital-rodape {
            font-weight: bold !important;
        }

        .no-print {
            display: none;
        }
    }
</style>

<div class="conteudo">
    <h4 class="titulo-termo">TERMO DE RESPONSABILIDADE</h4>
    <h5 class="titulo-termo">USO DE RECURSOS DE TIC E CONFIDENCIALIDADE</h5>
    <div class="texto">
        <p>Pelo presente instrumento, eu <strong><?= $nome ?></strong>, CPF <strong><?= $cpfResultante ?></strong>, identidade <strong><?= $nro_identidade ?> - <?= $orgao_emissor ?>/<?= $uf_orgao ?></strong>,
            <!-- lotado no(a) <strong><?= $lotacao ?></strong>,--> com vínculo <strong><?= $vinculo ?></strong> ocupação <strong><?= $ocupacao ?></strong> e matrícula <strong><?= $matricula ?></strong>, no Hospital Universitário da Universidade Federal da Grande Dourados, DECLARO, sob pena das sanções cabíveis nos termos da POSIC/Sede estendida para o Hospital Universitário da Universidade Federal da Grande Dourados, publicada por meio da Portaria n.0 35, de 6 de março de 2017 da Ebserh, e instituída no HU-UFGD por meio da Resolução n. 026, de 26 de abril de 2018, assumo a responsabilidade por:
        </p>
    </div>

    <ol type="I">
        <li>Tratar o(s) ativo(s) de informação como patrimônio do HU-UFGD;</li>
        <li>Utilizar as informações em qualquer suporte sob minha custódia, exclusivamente, no interesse do serviço do HU-UFGD;</li>
        <li>Contribuir para assegurar a disponibilidade, a integridade, a confidencialidade e a autenticidade das informações, conforme descrito na Instrução Normativa nº 01, do Gabinete de Segurança Institucional da Presidência da República, de 13 de junho de 2008, que Disciplina a Gestão de Segurança da Informação e Comunicações na Administração Pública Federal, direta e indireta;</li>
        <li>Utilizar as credenciais, as contas de acesso e os ativos de informação em conformidade com a legislação vigente e normas específicas da HU-UFGD;</li>
        <li>Responder, perante o HU-UFGD, pelo uso indevido das minhas credenciais ou contas de acesso e dos ativos de informação;</li>
        <li>A não observância deste termo, Política e/ou de seus documentos complementares, bem como a quebra de controles de segurança da informação e comunicações, poderá acarretar, isolada ou cumulativamente, nos termos da legislação aplicável, sanções administrativas, civis e penais, assegurados aos envolvidos o contraditório e a ampla defesa.</li>
    </ol>

    <p align="right">Dourados, MS, <?= $data ?>.</p>

    <div class="assinaturas">
        <div>
            <strong><?= $nome ?> </strong>
            <br />
            <small>(<?= strtolower($email_particular) ?>)</small>
        </div>

        <div class="assinatura-chefia"><strong>Chefia imediata <small>(carimbo e assinatura)</small></strong></div>
        <!-- <div class="assinatura-chefia"><strong><?= $chefia_imediata ?></strong></div> -->
    </div>
    <fieldset class="fieldset-cadastradores">
        <legend>USO EXCLUSIVO DOS CADASTRADORES</legend>
        <div class="assinatura-rede"><small>Assinatura do responsável pela criação da conta</small></div>
        <div class="assinatura-perfil"><small>Assinatura do responsável pela atribuição de perfil</small></div>
    </fieldset>
</div>

<!-- <footer class="rodape-documento">
    <strong class="hospital-rodape">Hospital Universitário da Universidade Federal da Grande Dourados – HU-UFGD</strong>
    <br />CNPJ: 07.775.847/0002-78
    <br />Rua Ivo Alves da Rocha, 558 – Altos do Indaiá
    <br />CEP 79.823-501 – Dourados/MS, Brasil
        <br />67 3410-3000
</footer> -->