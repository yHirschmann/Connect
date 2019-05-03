$(document).ready(function() {
    endDateModifier();
    setUploadInput();
    removeUselessElements();
});

/**
 * Setup the label for the hidden image button : add_project_imageFile_file
 */
function setUploadInput() {
    var $imgInputlabel = "<label class='imgInput-label btn btn-dark' for='add_project_imageFile_file'>Photo du projet</label>";
    $('.vich-image').append($imgInputlabel);
}

/**
 * when the from is send, some fields are added due to the reloaded js files. This function delete all these.
 */
function removeUselessElements(){
    $('input[value$="Enregistrer"]').nextUntil($('#add_project__token'), "div").remove();
}

/**
 * set or remove the readonly property to the add_project_endedAt input, depending of the state of the checkbox endedAtCheckbox
 */
function endDateModifier(){
    var $checkbox = $('input#endedAtCheckbox[type="checkbox"]');
    var $endedAt = $('input#add_project_endedAt');

    $checkbox.change(function () {
        if($checkbox.is(':checked')){
            $endedAt.prop("readonly", false);
        }else{
            $endedAt.prop("readonly", true);
        }
    });
}