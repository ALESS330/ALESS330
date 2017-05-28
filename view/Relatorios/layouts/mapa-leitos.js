MapaLeitos = {
    initPagina: function () {

    },
    updateTable: function (dadosTabela, filtros = null) {
        console.log("Filtrar com: " + filtros);
        console.log("Dados tem: " + dadosTabela.length + " registros");
        if (filtros) {
            for (var linha in dadosTabela) {
                for (var coluna in linha) {
                    //if (filtros.)
                }
            }
        }else{ //if (filtros)
            //construir a tabela
        }
    }
}