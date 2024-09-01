function escapeHtml(text) {
    var map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };
    
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
  }
  
      function addScript(){
        title = escapeHtml($("#inputTitle").val());
        desc = escapeHtml($("#inputDesc").val());
        code = $("#code").val();
        $.ajax({
            url: "api/ajax/add-script.php",
            type: 'POST',
            cache: false,
            data: {
              title: title,
              description: desc,
              code: code
            },
            success: function () {
              $('#addModal').modal('hide');
              toastr.success('Le script ' + title + ' a été ajouté a votre bibliothèque', 'Ajouté avec succès');
              getScripts();
            },
            error: function (jqXHR) {
              $('#addModal').modal('hide');
              toastr.error('The API server has respond a error', 'ERROR ' + jqXHR.status)
              getScripts();
            }
        });
      }
  
      function editScript(id){
        editorScript = id;
        $.ajax({
            url: "api/ajax/get-script.php?id=" + id,
            contentType: 'application/json; charset=utf-8',
            dataType:"json",
            success: function (data) {
              document.getElementById("editorModalLabel").textContent = data.name;
              document.getElementById("inputEditTitle").value = data.name;
              document.getElementById("inputEditDesc").value = data.description;
              document.getElementById("editcode").innerHTML = data.content;
              $('#editorModal').modal('show');
            },
            error: function (jqXHR) {
                toastr.error('The API server has respond a error', 'ERROR ' + jqXHR.status);
            }
        });
      }
  
      function editTheScript(){
        edittitle = escapeHtml($("#inputEditTitle").val());
        editdesc = escapeHtml($("#inputEditDesc").val());
        editcode = $("#editcode").val();
        $.ajax({
            url: "api/ajax/put-script.php?id=" + editorScript,
            type: 'POST',
            cache: false,
            data: {
              title: edittitle,
              description: editdesc,
              code: editcode
            },
            success: function () {
              $('#editorModal').modal('hide');
              toastr.success('Le script ' + edittitle + ' a été correctemene modifié', 'Modifié avec succès');
              getScripts();
            },
            error: function (jqXHR) {
              toastr.error('The API server has respond a error', 'ERROR ' + jqXHR.status);
              getScripts();
            }
        });
      }    
  
      function deleteScript(id){
        $.ajax({
            url: "api/ajax/delete-script.php?id=" + id,
            contentType: 'application/json; charset=utf-8',
            dataType:"json",
            success: function (data) {
                toastr.success('Le script a été correctement supprimé', 'Succès');
                getScripts();
            },
            error: function (jqXHR) {
                toastr.error('The API server has respond a error', 'ERROR ' + jqXHR.status);
            }
        });
      }