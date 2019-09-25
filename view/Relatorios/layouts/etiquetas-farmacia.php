<?php

$etiqueta1 = $dados[0];
$etiqueta2 = $dados[1] ?? NULL;
$etiqueta3 = $dados[2] ?? NULL;

$imprimirUrl = $_SERVER['REQUEST_URI']; // . "&imprimir=true";
$user = new Usuario($_SESSION['username'] ?? NULL);
?>

#{scriptPagina}
<script type="text/javascript">
    $(document).ready(function () {
        $("select").material_select();
        $('select[required]').css({
            display: 'inline',
            position: 'absolute',
            float: 'left',
            padding: 0,
            margin: 0,
            border: '1px solid rgba(255,255,255,0)',
            height: 0,
            width: 0,
            top: '2em',
            left: '3em',
            opacity: 0
        });
    });
</script>
#{/scriptPagina}
<style type="text/css">
    .fixed-action-btn:not(.imprimir){
        display: none;
    }
   
    div.small{
        font-size: 6px;
    }
    div.strong{
        font-size: 8px;
        font-weight: bold;
    }
    
    div.etiqueta{
        padding: 0.5mm;
        width: 30mm;
        height: 20mm;
        margin: 1.5mm;
        margin-top: 3mm;
        margin-bottom: 0.5mm;
        float: left;
        box-sizing: content-box;
        border-radius: 6px;
        background-color: white;
    }
    div.etiqueta:first-child{
        margin-left: 3mm;
    }
    
    #linha-etiquetas{
        width: 105mm;
        height: 25mm;
        background-color: #dddddd;
    }
    
    
    .titulo-relatorio {
        padding-bottom: 25px;
        font-weight: bold;
    }
</style>


<form action="<?= $imprimirUrl ?>">
    <div class="fixed-action-btn imprimir">
        <input type="hidden" name="prontuario1" value="<?= $etiqueta1['prontuario'] ?>" />
        <input type="hidden" name="prontuario2" value="<?= $etiqueta2['prontuario'] ?>" />
        <input type="hidden" name="prontuario3" value="<?= $etiqueta3['prontuario'] ?>" />
        
        <input type="hidden" name="periodo1" value="<?= $etiqueta1['periodo'] ?>" />
        <input type="hidden" name="periodo2" value="<?= $etiqueta2['periodo'] ?>" />
        <input type="hidden" name="periodo3" value="<?= $etiqueta3['periodo'] ?>" />
        
        <input type="hidden" name="imprimir" value="true" />
        <button class="btn-floating btn-large red">
            <i class="material-icons">print</i>
        </button>
    </div>

    <h5 class="titulo-relatorio">Etiquetas</h5>

    <div id="linha-etiquetas">
        <div id="etiqueta1" class="etiqueta">
            <div id="prontuario">
                <div class="small">Prontuário</div>                
                <div class="strong"><?= $etiqueta1['prontuario'] ?> </div>
            </div>
            <div id="dados">
                <div>
                    <div class="small">Nome: </div>
                    <div class="strong nome-paciente"><?= $etiqueta1['nome'] ?> </div>
                </div>
                <div>
                    <div class="small">Nascimento: </div>
                    <div class="strong"><?= $etiqueta1['nascimento'] ?> </div>
                </div>
            </div>
        </div>
        
        <div id="etiqueta2" class="etiqueta">
            <div id="prontuario">
                <div class="small">Prontuário</div>                
                <div class="strong"><?= $etiqueta2['prontuario'] ?> </div>
            </div>
            <div id="dados">
                <div>
                    <div class="small">Nome: </div>
                    <div class="strong nome-paciente"><?= $etiqueta2['nome'] ?> </div>
                </div>
                <div>
                    <div class="small">Nascimento: </div>
                    <div class="strong"><?= $etiqueta2['nascimento'] ?> </div>
                </div>
            </div>
        </div>

        <div id="etiqueta3" class="etiqueta">
            <div id="prontuario">
                <div class="small">Prontuário</div>                
                <div class="strong"><?= $etiqueta3['prontuario'] ?> </div>
            </div>
            <div id="dados">
                <div>
                    <div class="small">Nome: </div>
                    <div class="strong nome-paciente"><?= $etiqueta3['nome'] ?> </div>
                </div>
                <div>
                    <div class="small">Nascimento: </div>
                    <div class="strong"><?= $etiqueta3['nascimento'] ?> </div>
                </div>
            </div>
        </div>        
    </div> <!-- linha-etiquetas -->
    <br />
    
    <select name="impressora">
        <option value="HUGD-ETIQ-UDF01">Zebra UDF 1</option>
        <option value="HUGD-ETIQ-UDF02">Zebra UDF 2</option>
    </select>
</form>