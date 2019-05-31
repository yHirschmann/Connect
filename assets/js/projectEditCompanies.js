//TODO allow adds for projectCompanies

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
    let $rmBtnList = $('input.remove-companie-input');
    $rmBtnList.each(function () {
        setDeleteAction($(this));
    });
}