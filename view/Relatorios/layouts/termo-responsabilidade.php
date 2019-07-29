<?php
$termo = $dados[0];
setlocale(LC_ALL, 'pt_BR.UTF-8');
$data = strftime('%d de %B de %Y');
global $filename;
$filename = "termo-responsabilidade-" . $termo['nome'];

$cpfInteiro = str_pad($termo['cpf'], 11, "0", STR_PAD_LEFT); // mantem os numeros de cpf com 11 digitos
$maskCPF = "/(\d{3})(\d{3})(\d{3})(\d{2})/";
$arrayCPF = array();
$matches = preg_match_all($maskCPF, $cpfInteiro, $arrayCPF); // insere os resultados obtidos com maskCPF e cpfInteiro e insere no array
$cpfResultante = $arrayCPF[1][0] . "." . $arrayCPF[2][0] . "." . $arrayCPF[3][0] . "-" . $arrayCPF[4][0];

// funcao que deixa preposicoes e conjuncoes com a primeira letra minuscula
function titleCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("de", "da", "dos", "das", "do", "com")) {
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
<!--<head>
    <title>Termo de Responsabilidade: <?= $termo['nome'] ?></title>
</head>
<body>-->

<style>
    body {
        font-family: 'Google Sans' !important;
    }

    h4 {
        font-size: 21pt;
    }

    h5 {
        font-size: 14pt;
    }

    div.texto {
        margin-top: 40px;
    }

    .texto, h5 {
        margin: 0;
        padding: 0;
        border: 0;
    }

    .texto p {
        text-align: justify;
        text-indent: 1cm;
        font-size: 11pt;
        /*            line-height: 1.1em;*/
    }

    h1, h2, h3, h4, h5 {
        text-align: center;
    }

    .titulo-termo {
        margin-top: 0.5cm;
        line-height: 0.5em;
    }

    .assinaturas div {
        text-align: center;
        margin: 1.5cm 2cm 0 2cm;
        border-top: solid 1px black;
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

    .assinatura-chefia {
        padding-bottom: 50px;
    }

    ol {
        text-align: justify;
    }

    fieldset {
        border: solid 1px grey;
        box-shadow: none;
        border-radius: 4px;
        margin: 0 auto;
        padding: 20px;
        padding-top: 1.8cm;
    }

    fieldset legend {
        font-size: 11pt;
        margin-bottom: 20px;
        top: 0;
    }

    .assinatura-rede {
        float: left;
        padding-right: 10px;
        border-top: solid 1px black;
        width: 45%;
        text-align: center;
    }

    .assinatura-perfil {
        float: right;
        border-top: solid 1px black;
        width: 45%;
        text-align: center;
    }

    .dados li {
        list-style-type: none;
    }

    .rodape-documento {
        display: none;
    }

    @media print {
        @page { 
            margin: 0;
        }
        body {
            font-family: Roboto !important;
            margin-top: 10mm;
            margin-bottom: 10mm;
        }
        fieldset {
            width: 95%;
            margin: 0 auto;
        }
        .conteudo {
            padding-top: 25mm;
            box-shadow: none;
        }
        h4, h5 {
            margin: 0.5mm;
        }
        h4 {
            font-size: 18pt;
        }
        h5 {
            font-size: 12pt;
        }
        div.texto {
            margin-top: 10px;
        }
        .rodape-documento {
            display: block;
            margin-left: 10mm;
            font-size: 7pt;
        }
        .hospital-rodape {
            font-weight: bold;
        }
    } 

</style>

<div class="conteudo">
    <h4 class="titulo-termo">TERMO DE RESPONSABILIDADE</h4>
    <h5 class="titulo-termo">USO DE RECURSOS DE TIC E CONFIDENCIALIDADE</h5>
    <div class="texto">    
        <p>Pelo presente instrumento, eu <strong><?= $termo['nome'] ?></strong>, CPF <strong><?= $cpfResultante ?></strong>, identidade <strong><?= $termo['nro_identidade'] ?> - <?= $termo['orgao_emissor'] ?>/<?= $termo['uf_orgao'] ?></strong>, lotado no(a) <strong><?= $termo['lotacao'] ?></strong>, com vínculo <strong><?= $termo['vinculo'] ?></strong> e ocupação <strong><?= $termo['ocupacao'] ?></strong> no Hospital Universitário da Universidade Federal da Grande Dourados, DECLARO, sob pena das sanções cabíveis nos termos da POSIC/Sede estendida para o Hospital Universitário da Universidade Federal da Grande Dourados, publicada por meio da Portaria n.0 35, de 6 de março de 2017 da Ebserh, e instituída no HU-UFGD por meio da Resolução n.0 26, de 26 de abril de 2018, assumo a responsabilidade por:</p>            
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
        <div><strong><?= $termo['nome'] ?></strong></div>
        <div class="assinatura-chefia"><strong><?= $termo['chefia_imediata'] ?></strong></div>
    </div>
    <fieldset>
        <legend>USO EXCLUSIVO DO SETOR DE GESTÃO DE PROCESSOS E TECNOLOGIA DA INFORMAÇÃO</legend>
        <div class="assinatura-rede"><small>Assinatura do responsável pela criação da conta</small></div>
        <div class="assinatura-perfil"><small>Assinatura do responsável pela atribuição de perfil</small></div>
    </fieldset>
</div>

<footer class="rodape-documento">
    <strong class="hospital-rodape">Hospital Universitário da Universidade Federal da Grande Dourados – HU-UFGD</strong>
    <br />CNPJ: 07.775.847/0002-78
    <br />Rua Ivo Alves da Rocha, 558 – Altos do Indaiá
    <br />CEP 79.823-501 – Dourados/MS, Brasil
    <br />67 3410-3000
</footer>
<!--<footer>
    <address>
        <ul>
            <li><strong>Hospital Universitário da Universidade Federal da Grande Dourados – HU-UFGD</strong></li>
            <li>CNPJ: 07.775.847/0002-78</li>
            <li>Rua Ivo Alves da Rocha, 558 – Altos do Indaiá</li>
            <li>CEP 79.823-501 – Dourados/MS, Brasil</li>
            <li>67 3410-3000</li>
        </ul>
    </address>
</footer>-->