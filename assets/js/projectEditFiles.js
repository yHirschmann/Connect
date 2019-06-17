var $collectionHolder;

/**
 * main
 */
$(document).ready(function(){
    initDeleteAction();
    $collectionHolder = $('div#file-collection');
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    addFileForm($collectionHolder);
});

function addFileForm($collectionHolder){
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');


    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have

    var $newFormLi = $(prototype.replace(/__name__/g, index));
    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Ajouter une Contact" link li
    setCss($newFormLi);
    setLabel($newFormLi);
    setDeletBtn($newFormLi);
    $collectionHolder.append($newFormLi);
    console.log($newFormLi);
    feather.replace();
}

function setLabel($newFormLi){
    var $fileInput = $newFormLi.find('input');
    var $label = $('<label for="'+ $fileInput.attr('id')+'" style="min-width: 5em;min-height: 5em;"><span data-feather="file-plus"></span></label>');
    $fileInput.parent().append($label);
    $fileInput.on('change',function(){
        var $last = $collectionHolder.children().last();
        if($last !== $newFormLi && $last.find('input').get(0).files.length !== 0){
            addFileForm($collectionHolder);
        }
        var $label = $newFormLi.find('label');
        $label.children().remove();
        $label.append('<span data-feather="file-text"></span>');
        feather.replace();
        showFileName($newFormLi);
    });
}

function showFileName($newFormLi){
    var $body = $newFormLi.find('div.card-body');
    var $divFileName = $('<div class="file-name-link"></div>');
    var fileName = $body.find('input').get(0).files[0].name;
    if(!$body.find('div.file-name-link').length){
        $divFileName.append(fileName);
        $body.append($divFileName);
    }else{
        $divFileName = $('div.file-name-link');
        $divFileName.html('');
        $divFileName.append(fileName);
    }
}

function setCss($newFormLi) {
    var $first = $newFormLi.first();

    $first.addClass('card shadow-sm bg-light mb-3');
    $first.css({'max-width' : '10em'});

    var $next = $first.children().first();
    $next.addClass('card-body text-wrap');
}

function setDeletBtn($newFormLi){
    var $removeFormButton = $('<div class="file-remove-input" style="margin-bottom: 10px"><button type="button" class="remove-btn btn btn-dark">Supprimer</button></div>');
    $newFormLi.append($removeFormButton);

    $removeFormButton.on('click', function (e) {
        $newFormLi.remove();
        addFileForm($collectionHolder);
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
    let $rmBtnList = $('input.remove-file-input');
    $rmBtnList.each(function () {
        setDeleteAction($(this));
    });
}