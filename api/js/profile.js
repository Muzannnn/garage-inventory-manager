function saveSettings() {
    var discordMP = $("#discordMP").prop("checked") ? 1 : 0;
    var profileListMembers = $("#profileListMembers").prop("checked") ? 1 : 0;
    var publicProfile = $("#publicProfile").prop("checked") ? 1 : 0;
    var seeOnline = $("#seeOnline").prop("checked") ? 1 : 0;
    $.ajax({
        url: "api/ajax/save-settings.php",
        type: 'POST',
        cache: false,
        data: {
            notifications_authorization_discord: discordMP,
            confidentiality_profile_list_members: profileListMembers,
            confidentiality_public_profile: publicProfile,
            confidentiality_visible_online: seeOnline
        },
        success: function() {
            toastr.success('Vos paramètres ont été correctement sauvegardé', 'Succès');
        },
        error: function(jqXHR) {
            toastr.error('The API server has respond a error', 'ERROR ' + jqXHR.status)
        }
    });
}

function copierTexte(texteACopier) {
    var textarea = document.createElement("textarea");
    textarea.textContent = texteACopier;
    textarea.style.position = "fixed";
    document.body.appendChild(textarea);
    textarea.select();

    try {
        var reussi = document.execCommand('copy');
        toastr.success('Le lien a été copié dans votre presse papier', 'Copié avec succès');
        if (!reussi) {
            console.error("La copie du texte a échoué.");
        }
    } catch (err) {
        console.error("Erreur lors de la copie du texte : ", err);
    }

    document.body.removeChild(textarea);
}