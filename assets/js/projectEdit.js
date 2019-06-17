require('../css/projectEdit.css');
var $checkbox, $endDateInput, $imgProject, $imgInput;

/**
 * main
 */
$(document).ready(function () {
    $('input[type="submit"]').nextUntil('input[type="hidden"]').remove();
    $imgProject = $('img#project-img');
    $imgInput = $('input#edit_project_form_imageFile_file');
    $endDateInput = $('input#edit_project_form_endedAt');

    endDateModifier();
    $imgInput.on('change',function(){
        showImage(this);
    });
});

function endDateModifier(){
    $checkbox = $('input#endDateModifier-checkbox');
    $checkbox.on("change", function () {
        if($checkbox.is(":checked")){
            $endDateInput.prop("readonly", false);
        }else{
            $endDateInput.prop("readonly", true);
        }
    });
}

function showImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var file = input.files[0];

        reader.onload = function(e) {
            $imgProject.attr('src', e.target.result);
            $imgProject.attr('alt', e.target.result);
        };
        reader.readAsDataURL(file);
    }
}