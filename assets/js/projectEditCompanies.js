var $collectionHolder;
var $newLinkTd;
var $addNewCompanieButton = $('<input class="btn btn-dark add-companie-input" type="button" value="Ajouter une entreprise">');

/**
 * main
 */
$(document).ready(function () {
    initDeleteAction();
    $collectionHolder = $('tbody.new-companies-table');
    $collectionHolder.children().remove();
    $newLinkTd = $('td.add-companie-btn').append($addNewCompanieButton);

    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    $addNewCompanieButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addCompaniesForm($collectionHolder)
    });
});

function addCompaniesForm($collectionHolder){
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    var $newFormTr = $('<tr>' +
        '                   <td class="companie-selector"></td>' +
        '                   <td class="delete-companie"></td>' +
        '               </tr>');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Ajouter une Contact" link li
    $newFormTr.find('td.companie-selector').append(newForm);

    // showOutAt($newFormLi);
    $collectionHolder.append($newFormTr);
    addCompaniesFormDeleteLink($newFormTr);
}

function addCompaniesFormDeleteLink($newFormTr){
    var $removeFormButton = $('<button type="button" class="btn btn-dark remove-companie-input">Supprimer</button>');
    $newFormTr.find('td.delete-companie').append($removeFormButton);
    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $newFormTr.remove();
    });
}

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