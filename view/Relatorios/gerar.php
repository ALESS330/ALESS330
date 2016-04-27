<?php 

    $linkPdf = $_SERVER['REQUEST_URI'] . "/pdf"; 
    $linkExcel = $_SERVER['REQUEST_URI'] . "/excel";
?>
#{botoes}

<div class="fixed-action-btn">
    <a class="btn-floating btn-large red">
        <i class="material-icons">more_vert</i>
    </a>
    <ul>
        <li><a href="#" class="btn-floating red"><i class="material-icons">file_upload</i></a></li>
        <li><a href="<?= $linkPdf; ?>" class="btn-floating red darken-1"><i class="fa fa-file-pdf-o "></i></a></li>
        <li><a href="<?= $linkExcel; ?>" class="btn-floating greendarken-1"><i class="fa fa-file-excel-o "></i></a></li>
    </ul>
</div>
#{/botoes}

<?php
echo $relatorio;
