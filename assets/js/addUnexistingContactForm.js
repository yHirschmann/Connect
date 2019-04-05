var $addUnexistingContactsButton = $('<button type="button" class="btn btn-dark add_contacts_link">Ajouter un Contact</button>');
var $newLinkLi = $('<li style="list-style-type: none; margin-top: 10px"></li>').append($addUnexistingContactsButton);
var $collectionHolder;


$(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.add-unexisting-contacts');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    addUnexistingContactsForm($collectionHolder, $newLinkLi);

    $('.remove-btn').remove();

    $addUnexistingContactsButton.on('click', function(e){
        addUnexistingContactsForm($collectionHolder, $newLinkLi);
    });

});

function addUnexistingContactsForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    var $newFormLi = $('<li class="unexisting-contacts-from" style="list-style-type: none; margin-top: 25px"></li>');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Ajouter une Contact" link li
    $newFormLi.append(newForm);

    // showOutAt($newFormLi);
    $newLinkLi.before($newFormLi);
    addUnexistingContactsFormDeleteLink($newFormLi);
}
function addUnexistingContactsFormDeleteLink($contactFormLi) {
    var $removeFormButton = $('<button type="button" class="remove-btn btn btn-dark">Supprimer</button>');
    $contactFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $contactFormLi.remove();
    });
}