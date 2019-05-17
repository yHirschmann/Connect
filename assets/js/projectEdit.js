require('../css/projectEdit.css');

/**
 * main
 */
$(document).ready(function () {
    $('input[type="submit"]').nextUntil('input[type="hidden"]').remove();
});

//TODO display new image on project-img change
//TODO allow modifictation on endDate input on checkbox status change
