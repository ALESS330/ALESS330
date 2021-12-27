<?php
$termo = false;
// $termo = $dados[1];

$url = $_SERVER["REQUEST_URI"];
// echo "<pre>";
// print_r($dados);
// print_r($url);
// echo "</pre>";

function cpf($cpf)
{
    $cpfInteiro = str_pad($cpf, 11, "0", STR_PAD_LEFT); // mantem os numeros de cpf com 11 digitos, adicionando 0 para a esquerda
    $maskCPF = "/(\d{3})(\d{3})(\d{3})(\d{2})/";
    $arrayCPF = array();
    $matches = preg_match_all($maskCPF, $cpfInteiro, $arrayCPF); // insere os resultados obtidos com maskCPF e cpfInteiro no array
    $cpfResultante = $arrayCPF[1][0] . "." . $arrayCPF[2][0] . "." . $arrayCPF[3][0] . "-" . $arrayCPF[4][0];
    return $cpfResultante;
}

if (isset($_GET["termo"])) {
    $termo = $dados[$_GET["termo"]];

    global $filename;
    $filename = "termo-responsabilidade-" . $termo['nome'];
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

if ($termo) {
?>

    #{botoes}
    <div class="fixed-action-btn no-print">
        <button class="btn-floating btn-large red" id="bt-imprimir" title="Imprimir" onclick="window.print();">
            <i class="material-icons">local_printshop</i>
        </button>
    </div>
    #{/botoes}

<?php } else { // if ($termo) 
?>

    #{botoes}
    <div class="fixed-action-btn no-print">
        <a class="btn-floating btn-large" title="Voltar à pesquisa por CPF" href="/relator/relatorio/aghu/termo-responsabilidade" style="background-color: #37474f;">
            <i class="material-icons">arrow_back</i></a>
    </div>
    #{/botoes}

<?php } ?>

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

    thead {
        font-weight: bold;
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

    .itens-termo {
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

    .blockquote-instrucoes {
        padding-left: 0 !important;
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

        .itens-termo {
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

<?php
// if (!$termo) {
if (!$termo) { // se nao e um termo
    if (!cpf($dados[0]['cpf']) || cpf($dados[0]['cpf']) == '000.000.000-00') {
?>
        <div>
            <h4 style="text-align: justify;"><strong>CPF não encontrado!</strong></h4>

            <div class="row">
                <div class="col s6">
                    <p>Número de CPF <em><strong><?= $_GET['cpf'] ?></strong></em> não cadastrado no AGHU. Refaça a pesquisa clicando <a href="/relator/relatorio/aghu/termo-responsabilidade">aqui</a>.</p>
                </div>
            </div>
        </div>

    <?php } else { // if cpf nulo 
    ?>
        <h4 class="header" style="text-align: justify;"><strong>Dados do Colaborador</strong></h4>
        <blockquote>
            <div><strong>Nome: </strong><?= $dados[0]["nome"] ? $dados[0]["nome"] : '<em>Colaborador não cadastrado</em>' ?></div>
            <div><strong>CPF: </strong><?= cpf($dados[0]['cpf']) ? cpf($dados[0]['cpf']) : '<em>CPF não cadastrado</em>' ?></div>
        </blockquote>

        <table class="highlight">
            <thead>
                <tr>
                    <!-- <td>Nome</td>
                <td>CPF</td> -->
                    <td>Matrícula</td>
                    <td>Vínculo</td>
                    <td>Lotação</td>
                    <td>Cadastro atualizado no AGHU em</td>
                    <td>Termo de Responsabilidade</td>
                </tr>
            </thead>
            <?php
            foreach ($dados as $i => $linha) { // $linha = valor como linha da tabela
            ?>
                <tr>
                    <!-- <td><?= $linha["nome"] ?></td>
                <td><?= cpf($linha['cpf']) ?></td> -->
                    <td><?= $linha["matricula"] ?></td>
                    <td><?= $linha["vinculo"] ?></td>
                    <td><?= $linha["lotacao"] ?></td>
                    <td><?= $linha["cadastro_atualizado_em"] ?></td>
                    <td><a href="<?= $url . "&termo=$i" ?>" target="_blank">Gerar</a></td>
                </tr>
            <?php } // foreach
            ?>
        </table>
    <?php } // else cpf nulo
    ?>

<?php
} else { // if (!$termo)
    $emailParticular = strtolower($termo['email_particular']) ? strtolower($termo['email_particular']) : '<em style="color: red"><strong>Não cadastrado no AGHU! Favor cadastrá-lo e atualizar essa página para que apareça aqui (essa informação é  necessária para facilitar o cadastro do usuário de rede, por parte da equipe de TI).</strong></em>';
?>

    <div class="no-print">
        <h4 class="header" style="text-align: justify;"><strong>Instruções</strong></h4>
        <blockquote class="blockquote-instrucoes">
            <ol>
                <li>Imprimir esse termo, através do botão "Imprimir", localizado no canto inferior direito dessa página;</li>
                <li>Coletar as assinaturas do colaborador e de sua chefia imediata;</li>
                <li>Encaminhar o termo escaneado (devidamento assinado) para o SGPTI, por meio de novo chamado pelo Help Desk, solicitando criação de usuário de rede e adequação do acesso ao AGHU.</li>
            </ol>
        </blockquote>
        <p>Última alteração feita no cadastro, no AGHU: <strong> <?= $termo['cadastro_atualizado_em'] ?></strong>.</p>
    </div>

    <div class="conteudo">
        <h4 class="titulo-termo">TERMO DE RESPONSABILIDADE</h4>
        <h5 class="titulo-termo">USO DE RECURSOS DE TIC E CONFIDENCIALIDADE</h5>
        <div class="texto">
            <p>Pelo presente instrumento, eu <strong><?= $termo['nome'] ?></strong>, CPF <strong><?= cpf($termo['cpf']) ?></strong>, identidade <strong><?= $termo['nro_identidade'] ?> - <?= $termo['orgao_emissor'] ?>/<?= $termo['uf_orgao'] ?></strong>, com vínculo <strong><?= $termo['vinculo'] ?></strong>, ocupação <strong><?= $termo['ocupacao'] ?></strong> e matrícula <strong><?= $termo['matricula'] ?></strong>, no Hospital Universitário da Universidade Federal da Grande Dourados, DECLARO, sob pena das sanções cabíveis nos termos da POSIC/Sede estendida para o Hospital Universitário da Universidade Federal da Grande Dourados, publicada por meio da Portaria N. 035, de 6 de março de 2017 da Ebserh, e instituída no HU-UFGD por meio da Resolução N. 026, de 26 de abril de 2018, assumo a responsabilidade por:
            </p>
        </div>

        <ol class="itens-termo" type="I">
            <li>Tratar o(s) ativo(s) de informação como patrimônio do HU-UFGD;</li>
            <li>Utilizar as informações em qualquer suporte sob minha custódia, exclusivamente, no interesse do serviço do HU-UFGD;</li>
            <li>Contribuir para assegurar a disponibilidade, a integridade, a confidencialidade e a autenticidade das informações, conforme descrito na Instrução Normativa N. 01, do Gabinete de Segurança Institucional da Presidência da República, de 13 de junho de 2008, que Disciplina a Gestão de Segurança da Informação e Comunicações na Administração Pública Federal, direta e indireta;</li>
            <li>Utilizar as credenciais, as contas de acesso e os ativos de informação em conformidade com a legislação vigente e normas específicas da HU-UFGD;</li>
            <li>Responder, perante o HU-UFGD, pelo uso indevido das minhas credenciais ou contas de acesso e dos ativos de informação;</li>
            <li>A não observância deste termo, Política e/ou de seus documentos complementares, bem como a quebra de controles de segurança da informação e comunicações, poderá acarretar, isolada ou cumulativamente, nos termos da legislação aplicável, sanções administrativas, civis e penais, assegurados aos envolvidos o contraditório e a ampla defesa.</li>
        </ol>

        <br />
        <p align="right">Dourados, MS, <?= $data ?>.</p>

        <div class="assinaturas">
            <div>
                <strong><?= $termo['nome'] ?></strong>
                <br />
                <small>E-mail particular: <strong><?= $emailParticular ?></strong></small>
            </div>
            <!-- div class="assinatura-chefia"><strong>Chefia imediata <small>(carimbo e assinatura)</small></strong></div -->
            <div class="assinatura-chefia"><strong><?= $termo['lotacao'] ?></strong></div>
        </div>
        <fieldset class="fieldset-cadastradores">
            <legend>USO EXCLUSIVO DOS CADASTRADORES</legend>
            <div class="assinatura-rede"><small>Assinatura do responsável pela criação da conta</small></div>
            <div class="assinatura-perfil"><small>Assinatura do responsável pela atribuição de perfil</small></div>
        </fieldset>
    </div>
<?php }  // else if (!$termo) 
?>