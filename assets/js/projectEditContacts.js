var $collectionHolder;
var $newLinkTd;
var $addNewContactButton = $('<input class="btn btn-dark add-contact-input" type="button" value="Ajouter un Contact">');

/**
 * main
 */
$(document).ready(function () {
    initDeleteAction();
    $collectionHolder = $('tbody.new-contact-table');
    $collectionHolder.children().remove();

    $newLinkTd = $('td.add-contact-btn').append($addNewContactButton);

    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    $addNewContactButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addContactsForm($collectionHolder)
    });
});

function addContactsForm($collectionHolder){
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    var $newFormTr = $('<tr>' +
        '                   <td class="contact-selector"></td>' +
        '                   <td class="delete-contact"></td>' +
        '               </tr>');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Ajouter une Contact" link li
    $newFormTr.find('td.contact-selector').append(newForm);

    // showOutAt($newFormLi);
    $collectionHolder.append($newFormTr);
    addCompaniesFormDeleteLink($newFormTr);
}

function addCompaniesFormDeleteLink($newFormTr){
    var $removeFormButton = $('<button type="button" class="btn btn-dark remove-companie-input">Supprimer</button>');
    $newFormTr.find('td.delete-contact').append($removeFormButton);
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
    let $rmBtnList = $('input.remove-contact-input');
    $rmBtnList.each(function () {
        setDeleteAction($(this));
    });
}