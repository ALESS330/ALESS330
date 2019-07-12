<?php
$termo = $dados[0];
setlocale(LC_ALL, 'pt_BR.UTF-8');
$data = strftime('%d de %B de %Y');

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
<head>
    <title>Termo de compromisso: <?= $termo['nome'] ?></title>
</head>
<body>

    <style>
        body {
            font-family: 'Google Sans';
        }

        .texto , h5 {
            margin: 0;
            padding: 0;
            border: 0;
        }

        .texto p {
            text-align: justify;
            text-indent: 1cm;
            font-size: 11pt;
            line-height: 1.1em;
        }

        h1, h2, h3, h4, h5 {
            text-align: center;
        }

        .titulo-termo {
            margin-top: 0.5cm;
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
            padding: 5mm 10mm 10mm 10mm;
        }

        .page-footer {
            margin-top: 20px;
            padding-top: 0;
        }

        .assinatura-chefia {
            padding-bottom: 50px;
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

        /*    .assinatura-sgpti {
                float: left;
                padding-right: 10px;
                border-top: solid 1px black;
                width: 45%;
                text-align: center;
            }*/

        .assinatura-cadastrador {
            border-top: solid 1px black;
            width: 80%;
            text-align: center;
            margin: 0 auto;
        }

        .dados li {
            list-style-type: none;
        }

        @media print {
            @page { 
                margin: 0; 
            }
            body {
                margin-top: 10mm;
                margin-bottom: 10mm;
            }
            h5 {
                font-size: 18pt;
                margin-top: 0.5cm;
            }
            fieldset {
                width: 95%;
                margin: 0 auto;
            }

            .conteudo {
                box-shadow: none;
            }
        } 

    </style>

    <div class="conteudo">
        <h5 class="titulo-termo"><strong>Termo de Compromisso, Sigilo e Confidencialidade</strong></h5>
        <div class="texto">    
            <p>Solicito meu cadastro como usuário no Sistema AGHU, utilizado pelo HU-UFGD/EBSERH e me responsabilizo pelos dados informados para o cadastro. </p>
            <p>Comprometo-me a manter sigilo das informações acessadas, com exceção de dados autorizados previamente pelo Hospital Universitário da Fundação Universidade Federal da Grande Dourados. </p>
            <p>Estou ciente que devo conservar e atualizar imediatamente minhas informações de registro para mantê-las verdadeiras, exatas, e completas. </p>
            <p>Estou ciente, também, de que <strong>NÃO</strong> devo passar minha identificação e senha para quem quer que seja, sob pena de responsabilidade civil e funcional, pelo uso indevido da mesma. </p>
            <p>É de minha responsabilidade a observância dos princípios éticos, o cumprimento da legislação pertinente e obediência às políticas e diretrizes aplicáveis, sendo vedada a facilitação do acesso de terceiros não autorizados. </p>
            <p>É direito do Hospital assegurar a observância dos princípios éticos e sua obrigação supervisionar o cumprimento da legislação vigente, das normas e dos procedimentos cabíveis, sendo permitida realização, da área de Tecnologia da Informação, de auditorias periódicas e sempre que constatar a ocorrência de qualquer irregularidade, efetuar as investigações que julgar conveniente, verificando inclusive o conteúdo das informações que trafegaram na rede.</p>
            <p>O desrespeito a qualquer destas políticas e diretrizes configurará falta grave, acarretando ao infrator a suspensão imediata dos privilégios de acesso e uso dos recursos de informática do Hospital e de ações disciplinares cabíveis.</p>
        </div>

        <p align="right">Dourados/MS, <?= $data ?>.</p>

        <div>
            <ul class="dados">
                <li>Nome: <strong><?= $termo['nome'] ?></strong></li>
                <li>CPF: <strong><?= $cpfResultante ?></strong></li>
                <li>Matrícula/SIAPE: <strong><?= $termo['matricula'] ?></strong></li>
                <li>Ocupação: <strong><?= $termo['ocupacao'] ?></strong></li>
                <li>Tipo de vínculo: <strong><?= $termo['vinculo'] ?></strong></li>
                <li>Lotação: <strong><?= $termo['lotacao'] ?></strong></li>
                <li>E-mail particular: <strong><?= strtolower($termo['email_particular']) ?></strong></li>
                <li>Cadastrado em: <strong><?= $termo['cadastro_atualizado_em'] ?>, por <?= titleCase($termo['cadastrador']) ?></strong></li>
            </ul>
        </div>

        <div class="assinaturas">
            <div><strong><?= $termo['nome'] ?></strong></div>
            <div class="assinatura-chefia"><strong><?= $termo['chefia_imediata'] ?></strong></div>
    <!--        <div class="assinatura-chefia"><strong>Chefia <small>(Assinatura e carimbo)</small></strong></div>-->
        </div>
        <fieldset>
    <!--        <legend class="pos-cadastros">PÓS-CADASTROS<small> (Campos destinados ao(s) cadastrador(es))</small></legend>-->
            <legend class="pos-cadastros">PÓS-CADASTRO</legend>
    <!--        <div class="assinatura-sgpti">SGPTI <small>(Rede interna/Perfil AGHU)</small></div>-->
            <div class="assinatura-cadastrador">Cadastrador: <?= $termo['cadastrador'] ?></div>

        </fieldset>
    </div>

<!--<script type="text/javascript">
//    window.onload = function () {
//        window.print();
//    };
</script>-->

</body>