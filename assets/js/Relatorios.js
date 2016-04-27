Relatorios = {
    initIndex: function () {
        window.sessionStorage.setItem("paginas.relatorios.pagina", "1");
        window.sessionStorage.setItem("paginas.relatorios.busca", "");
        Relatorios.loadPagina();
        $(window).on('scroll', function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                Relatorios.loadPagina();
            }
        });

    },
    loadPagina: function () {
        var busca = $("#search").val();
        var buscaStorage = window.sessionStorage.getItem("pagina.relatorios.busca");
        if (busca != buscaStorage){
            window.sessionStorage.setItem("paginas.relatorios.pagina", "1");
            $("#tabela-relatorios tbody tr").remove("*");            
        }
        var pagina = window.sessionStorage.getItem("paginas.relatorios.pagina");
        var url = "/relator/relatorios/pagina?pagina=" + pagina + "&busca=" + busca;
        window.sessionStorage.setItem("pagina.relatorios.busca", busca);
        $.getJSON(url, function (dados) {
            $.each(dados["relatorios"], function (key, value) {
                var
                        linha = "            <tr>\n";
                linha += "                <td>";
                linha += "                    <a href=\"/relator/relatorio/" + value.datasource + "/"+ value.nome + "\">";
                linha += "                        " + value.nome;
                linha += "                    </a>";
                linha += "                </td>\n";
                linha += "                <td>" + value.descricao + "</td>\n";
                linha += "                <td>" + value.datasource + "</td>\n";
                linha += "                <td>";
                linha += "                    <div class=\"acoes\">";
                linha += "                        <a href=\"/relator/relatorios/cadastro?id=" + value.id + "\" class=\"btn indigo darken-3 waves-effect waves-light glyphicon glyphicon-edit\" aria-hidden=\"true\" >";
                linha += "                            <i class=\"material-icons\">edit</i>";
                linha += "                        </a>";
                linha += "                        <a class=\"btn btn-excluir red darken-3 waves-effect waves-light glyphicon glyphicon-edit\" alt=\"Excluir\" href=\"/relator/excluir?id=" + value.id + "\">";
                linha += "                            <i class=\"material-icons\">delete</i></a>";
                linha += "                    </div>";
                linha += "                </td>";
                linha += "            </tr>\n";
                $("#tabela-relatorios tbody").append(linha);
            });
            if (dados.relatorios.length > 1) {
                pagina++;
                window.sessionStorage.setItem("paginas.relatorios.pagina", pagina);
            }
        });
    },
    _loadPagina: function () {
        var pagina = window.sessionStorage.getItem("paginas.relatorios.pagina");
        var url = "/relator/relatorios/pagina?pagina=" + pagina;
        if (pagina == 1) {
            $.getJSON(url, function (dados) {
                window.sessionStorage.setItem("paginas.relatorios.linhas", JSON.stringify(dados));
            });
        }
        var linhas = window.sessionStorage.getItem("paginas.relatorios.linhas");
        linhas = JSON.parse(linhas);
        window.sessionStorage.removeItem("paginas.relatorios.linhas");
        Relatorios.atualizaTabela(linhas);
        //baixa a pagina seguinte
        pagina++;
        window.sessionStorage.setItem("paginas.relatorios.pagina", pagina);
        if (pagina > 1) {
            console.log("Carregando a página " + pagina);
            $.getJSON(url, function (dados) {
                window.sessionStorage.setItem("paginas.relatorios.linhas", JSON.stringify(dados));
            });
        }

    },
    atualizaTabela: function (linhas) {
        $.each(linhas["relatorios"], function (key, value) {
            var
                    linha = "            <tr>\n";
            linha += "                <td>" + value.nome + "</td>\n";
            linha += "                <td>" + value.descricao + "</td>\n";
            linha += "                <td>" + value.datasource + "</td>\n";
            linha += "                <td>";
            linha += "                    <div class=\"acoes\">";
            linha += "                        <a href=\"/relator/relatorios/cadastro?id=" + value.id + "\" class=\"btn indigo darken-3 waves-effect waves-light glyphicon glyphicon-edit\" aria-hidden=\"true\" >";
            linha += "                            <i class=\"material-icons\">edit</i>";
            linha += "                        </a>";
            linha += "                        <a class=\"btn btn-excluir red darken-3 waves-effect waves-light glyphicon glyphicon-edit\" alt=\"Excluir\" href=\"/relator/relatorios/excluir?id=" + value.id + "\">";
            linha += "                            <i class=\"material-icons\">delete</i></a>";
            linha += "                    </div>";
            linha += "                </td>";
            linha += "            </tr>\n";
            $("#tabela-relatorios tbody").append(linha);
        });
    }
};