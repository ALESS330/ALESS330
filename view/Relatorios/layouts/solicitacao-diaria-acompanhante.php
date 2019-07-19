<?php
$solicitacao = $dados[0];
// /*
//echo "<pre>";
//echo "\nprint_r:\n";
//print_r($solicitacao);
//echo "\nvar_dump\n";
//var_dump($solicitacao);
//echo "</pre>";
$solicitacao['a'] = "A";
$sexoM = $solicitacao['sexo'] == "M" ? "x" : " ";
$sexoF = $solicitacao['sexo'] == "F" ? "x" : " ";
//die("concluido...");
// */
//setlocale(LC_ALL, 'pt_BR.UTF-8');
//$data = strftime('%d de %B de %Y');
//
//$cpfInteiro = str_pad($termo['cpf'], 11, "0", STR_PAD_LEFT); // mantem os numeros de cpf com 11 digitos
//$maskCPF = "/(\d{3})(\d{3})(\d{3})(\d{2})/";
//$arrayCPF = array();
//$matches = preg_match_all($maskCPF, $cpfInteiro, $arrayCPF); // insere os resultados obtidos com maskCPF e cpfInteiro e insere no array
//$cpfResultante = $arrayCPF[1][0] . "." . $arrayCPF[2][0] . "." . $arrayCPF[3][0] . "-" . $arrayCPF[4][0];
//
//// funcao que deixa preposicoes e conjuncoes com a primeira letra minuscula
//function titleCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("de", "da", "dos", "das", "do", "com")) {
//    $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
//    foreach ($delimiters as $dlnr => $delimiter) {
//        $words = explode($delimiter, $string);
//        $newwords = array();
//        foreach ($words as $wordnr => $word) {
//            if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
//                $word = mb_strtoupper($word, "UTF-8");
//            } elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
//                $word = mb_strtolower($word, "UTF-8");
//            } elseif (!in_array($word, $exceptions)) {
//                $word = ucfirst($word);
//            }
//            array_push($newwords, $word);
//        }
//        $string = join($delimiter, $newwords);
//    } // foreach
//    return $string;
//}
?>
<head>
    <title>AIH Especial: <?= $solicitacao['nome'] ?></title>
</head>
<body>
    <style>
        body {
            font-family: 'Arial';
        }
        .pagina {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            margin-top: 15px;
            box-shadow: 0 1.5px 5px 0.5px grey;
            padding: 5mm 10mm 10mm 10mm;

        }

        div.aih{
            /*            width: 190mm;
                        height: 260mm;*/
        }

        div.cabecalho{
            background-image: url(/relator/assets/img/cabecalho-aih-esp.png);
            background-position: center;
            background-size: 190mm 14mm;
            width: 190mm;
            height: 14mm;
            /* border: solid 1px red; */
            background-repeat: no-repeat;
        }
        .page-footer {
            margin-top: 20px;
            padding-top: 0;
            display: none;
        }

        table#aih{
            width: 100%;
            line-height: 10pt;
            font-size: 9pt;
        }

        table#aih tbody tr td{
            border: solid 1px black;
            height: 10pt !important;
            padding: 1px !important;
        }

        table#aih tbody tr.titulo, div.titulo{
            font-family: Arial !important;
            font-size: 8px !important;
        }

        table#aih tbody tr.titulo td{
            border-bottom: none;
        }

        table#aih tbody tr.titulo-forte td{
            text-align: center;
            font-weight: bold;
            border-left: none;
            border-right: none
        }

        table#aih tbody tr.titulo-enfase td{
            background-color: black;
            color: white;
            font-size: 9pt;
        }
        
        #conteudo-justificativa{
            height: 170px !important;
            border: none;
            overflow: hidden;
            resize: none;
        }

        #fantasma td{
            line-height: 1pt;
            font-size: 1pt;
            padding: 0 !important;
        }
        .check{
            width: 16px;
            height: 16px;
            background-color: white;
            margin-right: 3px;
            color: black;
            display: inline-block;
            font-size: 10pt;
            text-align: center;
            font-weight: bold;
            border-radius: 4px;
        }

        table#aih tbody tr.dados td{
            border-top: none;
            font-size: 8pt !important;
            font-family: Arial !important;
            font-weight: bold !important;            
        }

        table#aih tbody tr.separadora, table#aih tbody tr.separadora td{
            border: none;
            font-size: 1px;
            padding: 1px !important;
        }        

        strong{
            font-weight: bold;
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
                width: 175mm;
                margin: 0 auto;
            }
        } /*media printe*/

    </style>

    <div class="pagina">
        <div class="aih">
            <div class="cabecalho">
            </div>
            <table id="aih">
                <thead>
                    <tr id="fantasma">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="titulo">
                        <td colspan="8">1 - NOME DO ESTABELECIMENTO SOLICITANTE</td>
                        <td colspan="2">2 - CNES</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="8">HOSPITAL UNIVERSITÁRIO DA UFGD</td>
                        <td colspan="2">2710935</td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="8">3 - NOME DO ESTABELECIMENTO EXECUTANTE</td>
                        <td colspan="2">4 - CNES</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="8">HOSPITAL UNIVERSITÁRIO DA UFGD</td>
                        <td colspan="2">2710935</td>
                    </tr>
                    <tr class="separadora">
                        <td colspan="10">&nbsp;</td>
                    </tr>
                    <tr class="titulo-secao">
                        <td colspan="10"><strong>Identificação do Paciente</strong></td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="8">5 - NOME DO PACIENTE</td>
                        <td colspan="2">6 - Nº DO PRONTUÁRIO</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="8"><?= $solicitacao['nome'] ?></td>
                        <td colspan="2"><?= $solicitacao['prontuario'] ?></td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="1">7 - CARTÃO NACIONAL DE SA&Uacute;DE (CNS)</td>
                        <td colspan="2">8 - DATA DE NASCIMENTO</td>
                        <td colspan="3">9 - SEXO</td>
                        <td colspan="2">10 -RAÇA/COR</td>
                        <td colspan="2" >10.1 - ETNIA</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="1"><?= $solicitacao['cartao_sus'] ?></td>
                        <td colspan="2"><?= $solicitacao['data_nascimento'] ?></td>
                        <td colspan="3">MASC. [<?= $sexoM ?>][1] FEM. [<?= $sexoF ?>][3]</td>
                        <td colspan="2"><?= $solicitacao['raca'] ?></td>
                        <td colspan="2"><?= $solicitacao['etnia'] ?></td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="7">11 - NOME DA MÃE</td>
                        <td colspan="3">12 - TELEFONE DE CONTATO</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="7"><?= $solicitacao['nome_mae'] ?></td>
                        <td colspan="3"><?= $solicitacao['telefone'] ?></td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="7">13 - NOME DO RESPONSÁVEL</td>
                        <td colspan="3">14 - TELEFONE DE CONTATO</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="7"><?= $solicitacao['responsavel'] ?? ' ' ?></td>
                        <td colspan="3"><?= $solicitacao['telefone_responsavel'] ?? ' ' ?></td>
                    </tr>
                    <tr class="titulo">
                        <td  colspan="10">15 - ENDEREÇO (RUA, Nº, BAIRRO)</td>
                    </tr>
                    <tr class="dados">
                        <td  colspan="10"><?= $solicitacao['endereco'] ?></td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="3">16 - MUNICÍPIO DE RESIDÊNCIA</td>
                        <td colspan="3">17 - CÓD. IBGE MUNICÍPIO</td>
                        <td colspan="2">18 - UF</td>
                        <td colspan="2">19 - CEP</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="3"><?= $solicitacao['cidade'] ?></td>
                        <td colspan="3"><?= $solicitacao['ibge_cidade'] ?? 'IBGE' ?></td>
                        <td colspan="2"><?= $solicitacao['uf'] ?></td>
                        <td colspan="2"><?= $solicitacao['cep'] ?? 'CEP' ?></td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <div class="center titulo">20 - NÚMERO DA AUTORIZAÇÃO DE INTERNAÇÃO HOSPITALAR (AIH)</div>
                            <div class="center"><strong>AIH</strong></div>                            
                        </td>
                    </tr>
                    <tr class="separadora">
                        <td colspan="10">&nbsp;</td>
                    </tr>
                    <tr class="titulo-enfase">
                        <td colspan="10"><span class="check" checked>&nbsp;</span><span>MUDANÇA DE PROCEDIMENTO</span></td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="6">21 - DESCRIÇÃO DO PROCEDIMENTO SOLICITADO - ANTERIOR</td>
                        <td colspan="4">22 - CÓD. DO PROCEDIMENTO - ANTERIOR</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="6"><?= $codigoProcedAnterior ?? 'CODIGO PROCEDIMENTO ANTERIOR' ?></td>
                        <td colspan="4"><?= $descProced1Anterior ?? 'DESCRICAO' ?></td>
                    </tr>                    
                    <tr class="titulo">
                        <td colspan="6">23 - DESCRIÇÃO DO PROCEDIMENTO SOLICITADO - MUDANÇA</td>
                        <td colspan="4">24 - CÓD. DO PROCEDIMENTO - MUDANÇA</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="6"><?= $codigoProcedMudanca ?? 'CODIGO PROCEDIMENTO MUDANCA' ?></td>
                        <td colspan="4"><?= $descProcedMudanca ?? 'DESCRICAO' ?></td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="2">25 - DIAGNÓSTICO INICIAL</td>
                        <td colspan="2">26 - CID 10 PRINCIPAL</td>
                        <td colspan="3">27 - CID 10 SECUNDÁRIO</td>
                        <td colspan="3">28 - CID 10 CAUSAS ASSOCIADAS</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="3"></td>
                        <td colspan="3"></td>
                    </tr>
                    <tr class="separadora">
                        <td colspan="10">&nbsp;</td>
                    </tr>                    
                    <tr class="titulo-enfase">
                        <td colspan="10"><span class="check" checked>&times;</span><span>SOLICITAÇÃO DE PROCEDIMENTO(S) ESPECIAL(AIS)</span></td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="5">29 - DESCRIÇÃO DO PROCEDIMENTO PRINCIPAL</td>
                        <td colspan="5">30 - CÓD. DO PROCEDIMENTO PRINCIPAL</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="5">&nbsp;</td>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="10">31 - SOLICITAÇÃO DE DIÁRIA DE UTI E/OU DIÁRIA DE ACOMPANHANTE</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="10">
                            <span class="check preto"></span><span>DIARIA DE ACOMPANHANTE</span>
                            <span class="check preto"></span><span>DIARIA DE UTI TIPO I</span>
                            <span class="check preto"></span><span>DIARIA DE UTI TIPO II</span>
                            <span class="check preto"></span><span>DIARIA DE UTI TIPO III</span>
                        </td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="4">32 - DESCRIÇÃO DO PROCEDIMENTO ESPECIAL</td>
                        <td colspan="4">33 - CÓD. DO PROCEDIMENTO ESPECIAL</td>
                        <td colspan="2">34-QTDE.</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="4"><?= $solicitacao['a'] ?></td>
                        <td colspan="4"><?= $solicitacao['a'] ?></td>
                        <td colspan="2"><?= $solicitacao['a'] ?></td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="4">35 - DESCRIÇÃO DO PROCEDIMENTO ESPECIAL</td>
                        <td colspan="4">36 - CÓD. DO PROCEDIMENTO ESPECIAL</td>
                        <td colspan="2">37-QTDE.</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="4"><?= $solicitacao['a'] ?></td>
                        <td colspan="4"><?= $solicitacao['a'] ?></td>
                        <td colspan="2"><?= $solicitacao['a'] ?></td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="4">38 - DESCRIÇÃO DO PROCEDIMENTO ESPECIAL</td>
                        <td colspan="4">39 - CÓD. DO PROCEDIMENTO ESPECIAL</td>
                        <td colspan="2">40-QTDE.</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="4"><?= $solicitacao['a'] ?></td>
                        <td colspan="4"><?= $solicitacao['a'] ?></td>
                        <td colspan="2"><?= $solicitacao['a'] ?></td>
                    </tr>
                    <tr class="titulo-forte">
                        <td colspan="10">41 - JUSTIFICATIVA DA SOLICITAÇÃO</td>
                    </tr>
                    <tr class="dados justificativa">
                        <td colspan="10">
                            <textarea id="conteudo-justificativa">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla auctor condimentum mollis. Suspendisse eros mauris, porttitor non metus vel, pulvinar posuere ante. Ut et quam tortor. Fusce eu luctus mauris, eu porta nisl. Proin condimentum euismod ipsum, eget tempor arcu vehicula nec. In hac habitasse platea dictumst. Cras varius erat ante, nec dictum nisi rhoncus ut. Donec id orci nulla. Ut nisi lorem, imperdiet ac tempus eget, pharetra accumsan est. Vivamus iaculis sapien ac ipsum lobortis, et pulvinar nunc vehicula. Pellentesque eget ullamcorper ex, ac dignissim dolor.
Aenean aliquet risus massa, tempor dignissim mi luctus ac. Integer condimentum ex vel nulla ornare lacinia vitae quis tellus. Etiam venenatis lorem ut sem placerat, ac pharetra quam mollis. Suspendisse mi magna, rutrum eget viverra non, vehicula et lacus. Ut sollicitudin volutpat velit, sed suscipit urna interdum pellentesque. Cras vel velit non elit cursus interdum. Cras neque nulla, viverra et euismod a, vehicula eget dui. Aenean nec ipsum dignissim nisl tempor bibendum. Vestibulum ac ante commodo, cursus augue id, tincidunt eros.
Etiam rhoncus felis quis mollis facilisis. Nulla facilisi. Curabitur dui mauris, ultricies sit amet risus vitae, pulvinar interdum erat. Pellentesque faucibus maximus purus. Donec rutrum leo nisl, non dignissim metus interdum a. In hac habitasse platea dictumst. Aenean ac mattis erat. Phasellus semper elementum lacinia. Ut feugiat velit ipsum, eu rhoncus ante vulputate consectetur. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam quis lectus eget nisi ullamcorper elementum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam sit amet enim mi.</textarea>
                        </td>
                    </tr>
                    <tr class="titulo-forte">
                        <td colspan="10">PROFISSIONAL SOLICITANTE</td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="8">42 - NOME DO PROFISSIONAL SOLICITANTE</td>
                        <td colspan="2">43 - DATA DA SOLICITAÇÃO</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="8"><?= $solicitacao['a'] ?></td>
                        <td colspan="2"><?= $solicitacao['a'] ?></td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="2">44 - DOCUMENTO</td>
                        <td colspan="5">45 - Nº DOCUMENTO (CNS/CPF) DO PROFISSIONAL SOLICITANTE</td>
                        <td colspan="3">46-ASSINATURA E CARIMBO (Nº DO REGISTRO DO CONSELHO)</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="2"><?= $solicitacao['a'] ?></td>
                        <td colspan="5"><?= $solicitacao['a'] ?></td>
                        <td colspan="3"><?= $solicitacao['a'] ?></td>
                    </tr>
                    <tr class="titulo-forte">
                        <td colspan="10">AUTORIZAÇÃO</td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="4">47 - NOME DO PROFISSIONAL AUTORIZADOR</td>
                        <td colspan="3">48 - CÓD. ÓRGÃO EMISSOR 4</td>
                        <td colspan="3">49-DATA DA AUTORIZAÇÃO</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="4"></td>
                        <td colspan="3"></td>
                        <td colspan="3" class="center">___/___/______</td>
                    </tr>
                    <tr class="titulo">
                        <td colspan="2">50 - DOCUMENTO</td>
                        <td colspan="5">51 - Nº DOCUMENTO (CNS/CPF) DO PROFISSIONAL SOLICITANTE</td>
                        <td colspan="3">52-ASSINATURA E CARIMBO (N&ordm; DO REGISTRO DO CONSELHO)</td>
                    </tr>
                    <tr class="dados">
                        <td colspan="2"></td>
                        <td colspan="5"></td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                </tbody>
            </table>   
        </div> <!-- aih -->
    </div>

</body>