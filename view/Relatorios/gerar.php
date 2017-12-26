<?php 
    $uri = $_SERVER['REQUEST_URI'];
    if(strpos($uri, "?") > 0){
        $uPdf = substr_replace($uri, "/pdf", strpos($uri, "?"), 0);
        $uCsv = substr_replace($uri, "/csv", strpos($uri, "?"), 0);
    }else{
        $uPdf = $uri . "/pdf";
        $uCsv = $uri . "/csv";
    }
    
    $linkPdf =  $uPdf; 
    $linkCsv = $uCsv;
?>
#{botoes}

<div class="fixed-action-btn">
    <a class="btn-floating btn-large red">
        <i class="material-icons">more_vert</i>
    </a>
    <ul>
        <li><a href="#" class="btn-floating red"><i class="material-icons">file_upload</i></a></li>
        <li><a title="Baixar como PDF" href="<?= $linkPdf; ?>" class="btn-floating red darken-1"><i class="material-icons">picture_as_pdf</i></a></li>
        <li><a title="Exportar como CSV (planilhas)" href="<?= $linkCsv; ?>" class="btn-floating greendarken-1"><i class="material-icons">assessment</i></a></li>
    </ul>
</div>
#{/botoes}

<?php
echo $relatorio;
