//TODO allow adds for projectContacts

/**
 * main
 */
$(document).ready(function () {
    initDeleteAction();
});

/**
 * allow to remove files from the project
 * @param $rmBtn
 */
function setDeleteAction($rmBtn){
    $rmBtn.click(function () {
        $rmBtn.parent().parent().remove();
    });
}

/**
 * Set the delete action on existing remove file buttons
 */
function initDeleteAction(){
    let $rmBtnList = $('input.remove-contact-input');
    $rmBtnList.each(function () {
        setDeleteAction($(this));
    });
}