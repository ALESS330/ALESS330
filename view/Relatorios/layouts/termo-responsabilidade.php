<?php ?>

<style>
    .centro {
        text-align: center;
    }

    .dados p {
        margin: 0;
    }

    .texto, p {
        text-align: justify;
        text-indent: 1.5cm;
        font-size: 14pt;
    }

    div h1, h2, h3, h4, h5 {
        text-align: center;
    }

    .conteudo {
        width: 190mm;
    }

    .assinaturas div {
        text-align: center;
        margin: 1.5cm 4cm 0 4cm;
        border-top: solid 1px black;
    }

    .assinatura-chefia {
        padding-bottom: 50px;
    }

    fieldset {
        border: solid 1px grey;
        border-radius: 4px;
        margin: auto;
        padding-left: 20px;
        padding-right: 20px;
    }

    .assinatura-rede {
        float: left;
        margin-top: 1.5cm;
        padding-right: 10px;
        padding-bottom: 20px;
        border-top: solid 1px black;
        width: 45%;
        text-align: center;
    }

    .assinatura-aghu {
        float: right;
        margin-top: 1.5cm;
        padding-bottom: 20px;
        border-top: solid 1px black;
        width: 45%;
        text-align: center;
    }

    @media print {
        @page {
            margin: 0;
        }

        body:before {
            content: url('/assets/img/fundo.png');
        }
    }

</style>

<div>
    <h2 style="text-align: center;">Termo de Compromisso, Sigilo e Confidencialidade</h2>

    <p>Solicito meu cadastro como usuário no Sistema AGHU, utilizado pelo HU-UFGD/EBSERH e me responsabilizo pelos dados informados para o cadastro. </p>
    <p>Comprometo-me a manter sigilo das informações acessadas, com exceção de dados autorizados previamente pelo Hospital Universitário da UFGD. </p>
    <p>Estou ciente que devo conservar e atualizar imediatamente minhas informações de Registro para mantê-las verdadeiras, exatas, e completas. </p>
    <p>Estou ciente, também, de que <strong>NÃO</strong> devo passar minha identificação e senha para quem quer que seja, sob pena de responsabilidade civil e funcional, pelo uso indevido da mesma. </p>
    <p>É de minha responsabilidade a observância dos princípios éticos, o cumprimento da legislação pertinente e obediência às políticas e diretrizes aplicáveis, sendo vedada a facilitação do acesso de terceiros não autorizados. </p>
    <p>É direito de o Hospital assegurar a observância dos princípios éticos e sua obrigação supervisionar o cumprimento da legislação vigente, das normas e dos procedimentos cabíveis, sendo permitida realização, da área de TI, de auditorias periódicas e sempre que constatar a ocorrência de qualquer irregularidade, efetuar as investigações que julgar conveniente, verificando inclusive o conteúdo das informações que trafegaram na rede.</p>
    <p>O desrespeito a qualquer destas políticas e diretrizes configurará falta grave, acarretando ao infrator a suspensão imediata dos privilégios de acesso e uso dos recursos de informática do Hospital e de ações disciplinares cabíveis.</p>

    <p class="centro">Dourados/MS, ${data.format('dd')} de ${mes} de ${data.format('yyyy')}. </p>

    <div class="dados">    
        <p>Usuário: <strong>${pessoa?.nome}</strong></p>
        <p>Matrícula/SIAPE: <strong>${pessoa?.matricula}</strong></p>
        <p>Função de acesso: <strong>${pessoa?.ocupacao?.descricao}</strong></p>
        <p>E-mail: <strong>${pessoa?.emailInstitucional ? pessoa?.emailInstitucional:pessoa?.emailAlternativo}</strong></p>
        <p>Lotação: <strong>${pessoa?.lotacao}</strong></p>
        <p>Data de preenchimento do formulário: <strong>${pessoa?.dataCadastro?.format('dd/MM/yyyy HH:mm:ss')}</strong></p>
    </div>
    <div class="assinaturas">
        <div><strong>${pessoa.nome}</strong></div>
        <div class="assinatura-chefia"><strong>Chefia <small>(Assinatura e carimbo)</small></strong></div>
    </div>
    <fieldset>
        <legend><strong>PÓS-CADASTROS</strong></legend>
        <div class="assinatura-rede">Rede interna de computadores</div>
        <div class="assinatura-aghu">Sistema AGHU</div>
    </fieldset> <!-- assinaturas -->
</div> <!-- conteudo -->

<script type="text/javascript">
    window.onload = function () {
        window.print();
    };
</script>