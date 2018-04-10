<?php global $corSistemaRGB; 
$grupoAtual = "";
?>
<style>
    .lista-relatorios{
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: center;
    }

    .lista-relatorios .relatorio{
        display: inline-block;
        width: 300px;
        height: 80px;
        margin: 5px;
        border-radius: 5px;
        /*        padding: 4px;*/
        text-align: center;
        vertical-align: middle;
    }
    .lista-relatorios .relatorio .icone{
        width: 80px;
        height: 80px;
        background-color:  <?= $corSistemaRGB ?>;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        float: left;
        padding-top: 16px;
    }
    .lista-relatorios .relatorio .icone i{
        font-size: 48px;
    }

    .lista-relatorios .relatorio .descricao{
        width: 220px;
        height: 59px;
        border-bottom-right-radius: 5px;
        /*        float: left;*/
        padding: 2px;
        font-size: 12px;
        line-height: 30px;
        white-space: nowrap; 
        display: inline-block;
        overflow: hidden;
        text-overflow: ellipsis
    }
    .lista-relatorios .relatorio strong{
        height: 20px;
        width: 220px;
        display: inline-block;
        border-top-right-radius: 5px;
    }

    a .relatorio .icone i{
        color: white !important;
    }

</style>

<h4>Lista de Relatórios</h4>


<div class="lista-relatorios">
    <?php foreach ($listaRelatorios as $index => $relatorio) { ?>
        <a href="@{Relatorios->gerar(<?= $relatorio->nome_datasource ?>,<?= $relatorio->nome ?>)}">
            <div class="relatorio card hoverable">
                <strong><?= $relatorio->nome ?>&nbsp;</strong>
                <div class="icone <?= implode(" ", $coresIcones[$relatorio->grupo]) ?>">
                    <i class="material-icons"><?= $relatorio->icone ?></i>
                </div>
                <div class="descricao">
                    <span title="<?= $relatorio->descricao ?>"><?= $relatorio->descricao ?></span>
                </div>
            </div>

        </a>
    <?php } ?>    
</div>
