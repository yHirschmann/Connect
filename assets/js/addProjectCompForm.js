var $addCompaniesButton = $('<button type="button" class="btn btn-dark add_companies_link">Ajouter un Companie</button>');
var $newLinkLi = $('<li style="list-style-type: none; margin-top: 10px"></li>').append($addCompaniesButton);
var $collectionHolder;

$(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.add-companies');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    addCompaniesForm($collectionHolder, $newLinkLi);

    $('.remove-btn').remove();
    $addCompaniesButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addCompaniesForm($collectionHolder, $newLinkLi);
    });
});

function addCompaniesForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    var $newFormLi = $('<li class="companies-from" style="list-style-type: none; margin-top: 25px"></li>');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Ajouter une Companie" link li
    $newFormLi.append(newForm);

    // showOutAt($newFormLi);
    $newLinkLi.before($newFormLi);
    addCompaniesFormDeleteLink($newFormLi);
}

//Add a delete button for each new companies form added
function addCompaniesFormDeleteLink($companiesFormLi) {
    var $removeFormButton = $('<button type="button" class="remove-btn btn btn-dark">Supprimer</button>');
    $companiesFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $companiesFormLi.remove();
    });
}


