var $addUnexistingCompaniesButton = $('<button type="button" class="btn btn-dark add_contacts_link">Ajouter une Entreprise</button>');
var $newLinkLi = $('<li style="list-style-type: none; margin-top: 10px"></li>').append($addUnexistingCompaniesButton);
var $collectionHolder;


$(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.add-unexisting-companies');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    addUnexistingCompaniesForm($collectionHolder, $newLinkLi);

    $('.remove-btn').remove();

    $addUnexistingCompaniesButton.on('click', function(e){
        addUnexistingCompaniesForm($collectionHolder, $newLinkLi);
    });

});

function addUnexistingCompaniesForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    var $newFormLi = $('<li class="unexisting-companies-from" style="list-style-type: none; margin-top: 25px"></li>');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Ajouter une Contact" link li
    $newFormLi.append(newForm);

    // showOutAt($newFormLi);
    $newLinkLi.before($newFormLi);
    addUnexistingCompaniesFormDeleteLink($newFormLi);
}
function addUnexistingCompaniesFormDeleteLink($companieFormLi) {
    var $removeFormButton = $('<button type="button" class="remove-btn btn btn-dark">Supprimer</button>');
    $companieFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $companieFormLi.remove();
    });
}