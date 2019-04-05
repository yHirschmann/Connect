var $addContactsButton = $('<button type="button" class="btn btn-dark add_contacts_link">Ajouter un Contact</button>');
var $newLinkLi = $('<li style="list-style-type: none; margin-top: 10px"></li>').append($addContactsButton);
var $collectionHolder;

$(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.add-contacts');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    addContactsForm($collectionHolder, $newLinkLi);

    $('.remove-btn').remove();
    $addContactsButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addContactsForm($collectionHolder, $newLinkLi);
    });
});

function addContactsForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    var $newFormLi = $('<li class="contacts-from" style="list-style-type: none; margin-top: 25px"></li>');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Ajouter une Contact" link li
    $newFormLi.append(newForm);

    // showOutAt($newFormLi);
    $newLinkLi.before($newFormLi);
    addContactsFormDeleteLink($newFormLi);
}

//Add a delete button for each new contacts form added
function addContactsFormDeleteLink($contactsFormLi) {
    var $removeFormButton = $('<button type="button" class="remove-btn btn btn-dark">Supprimer</button>');
    $contactsFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $contactsFormLi.remove();
    });
}


