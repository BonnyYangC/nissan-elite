(function () {
    var MDGuild = {
        tbodyList: [],
    };

    MDGuild.init = function () {
        this.tbodyList = document.querySelectorAll(".md-guild-table tbody[data-data-file]");

        this.loadDataFiles();
    };

    MDGuild.loadDataFiles = function () {
        Array.prototype.forEach.call(this.tbodyList, function (tbody) {
            var filePath = tbody.getAttribute("data-data-file");
            var request = new XMLHttpRequest();

            request.onload = function () {
                MDGuild.handleDataResponse(request, tbody);
            };

            request.open("GET", filePath, true);
            request.send();
        });
    };

    MDGuild.handleDataResponse = function (request, tbody) {
        try {
            var data = JSON.parse(request.responseText);

            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }

            data.forEach(function (row) {
                var tr = document.createElement("tr");

                row.forEach(function (tableData) {
                    var td = document.createElement("td");
                    td.innerHTML = tableData;
                    tr.appendChild(td);
                });

                tbody.appendChild(tr);
            });

            tbody.removeAttribute("data-data-file");
        } catch (e) {
            console.warn("Could not load data file for an MD Guild table.");
        }
    };

    document.addEventListener("DOMContentLoaded", MDGuild.init.bind(MDGuild));
})();
