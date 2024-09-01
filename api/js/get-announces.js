function deleteAllRows() {
    var table = document.getElementById("idb-tbody");
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

function getAnnounces(){
    deleteAllRows();
    $.ajax({
        url: `./api/ajax/get-announces.php`,
        type: 'get',
        dataType: 'JSON',
        success: function(response){
            var resp = response.reverse();
            var len = response.length;


            for(var i=0; i<len; i++){
                var content = resp[i].content;
                var never = resp[i].never;
                var id = resp[i].id;
                if(never){
                    never = "Oui";
                }else{
                    never = "Non";
                }
                var date = resp[i].expiration_date;

                var tr_str = 
                "<tr>" +
                    "<td>" + content + "</td>" +
                    "<td>" + never + "</td>" +
                    "<td>" + formatTimestamp(date) + "</td>" +
                    "<td><button onclick='deleteAnnounce(" + id + ")' class='btn btn-danger btn-rounded'><i class='fas fa-trash'></i></button></td>" +
                "</tr>";
                

                $("#idb tbody").append(tr_str);
            }



        }
    });
};