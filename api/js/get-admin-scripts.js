function deleteAllRows() {
    var table = document.getElementById("admin-tbd");
    var rowCount = table.rows.length;

    while (rowCount > 0) {
      table.deleteRow(0); // Supprime la première ligne à chaque itération
      rowCount = table.rows.length; // Met à jour le nombre de lignes restantes
    }
}

function formatTimestamp(timestamp) {
    var date = new Date(timestamp * 1000); // Convertir le timestamp Unix en millisecondes
    var options = { year: 'numeric', month: '2-digit', day: '2-digit' };
  
    return date.toLocaleDateString('fr-FR', options);
}

function getAdminScripts(){
    deleteAllRows();
    $.ajax({
        url: `./api/ajax/get-admin-scripts.php`,
        type: 'get',
        dataType: 'JSON',
        success: function(response){
            var resp = response.reverse();
            var len = response.length;


            for(var i=0; i<len; i++){
                var name = resp[i].name;
                var description = resp[i].description;
                var categorie = resp[i].categorie;
                var id = resp[i].id;
                var date = resp[i].creation_date;

                var tr_str = 
                "<tr>" +
                    "<td>" + name + "</td>" +
                    "<td>" + description + "</td>" +
                    "<td>" + categorie + "</td>" +
                    "<td>" + formatTimestamp(date) + "</td>" +
                    "<td>" +
                        "<button onclick='editScript("+ id +")' class='btn btn-warning btn-rounded mr-3'><i class='fas fa-pen'></i></button>" +
                        "<button onclick='deleteScript(" + id + ")' class='btn btn-danger btn-rounded'><i class='fas fa-trash'></i></button>" +
                    "</td>" +
                "</tr>";

                $("#idb tbody").append(tr_str);
            }



        }
    });
};