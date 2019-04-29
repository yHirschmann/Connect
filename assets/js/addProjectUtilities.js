var $checkbox, $endedAt;

$(document).ready(function() {
    $checkbox = $('input#endedAtCheckbox[type="checkbox"]');
    $endedAt = $('input#add_project_endedAt');

    $checkbox.change(function () {
        if($checkbox.is(':checked')){

            $endedAt.prop("readonly", false);
        }else{
            $endedAt.prop("readonly", true);
        }
    });
});