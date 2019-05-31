var $addFilesButton = $('<button type="button" class="btn btn-dark add_files_link">Ajouter un autre Fichier</button>');
var $newLinkLi = $('<li style="list-style-type: none; margin-top: 10px"></li>').append($addFilesButton);
var _URL = window.URL || window.webkitURL;
var $collectionHolder;

//addButton & Delete button must not be displayed until the user add a file
$(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.add-files');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    addFilesForm($collectionHolder, $newLinkLi);

    $addFilesButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addFilesForm($collectionHolder, $newLinkLi);
    });
});

function addFilesForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    var $newFormLi = $('<li class="files-from" style="list-style-type: none; margin-top: 25px"></li>');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Ajouter une Contact" link li
    $newFormLi.append(newForm);
    $newLinkLi.before($newFormLi);
    setLabel($newFormLi);
    addFilesFormDeleteLink($newFormLi);
}

//Add a delete button for each new files form added
function addFilesFormDeleteLink($filesFormLi) {
    var $removeFormButton = $('<button type="button" class="remove-btn btn btn-dark">Supprimer</button>');
    $filesFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $filesFormLi.remove();
    });
}

function setLabel($newFormLi){
    var $fileInputLabel = $('<label class="fileInput-label btn btn-dark"></label>');
    var $emptyFileSpan = $('<span data-feather="file-plus"></span>');
    var $fullFileSpan = $('<span data-feather="file-text"></span>');
    var $divFileName = $('<div class="FileName"></div>');
    var $vichFile = $newFormLi.find('div.vich-file');
    var $fileInput = $vichFile.find('input');
    var $tmpLabel =  $fileInputLabel;

    $vichFile.append($divFileName);
    $fileInput.on('change',function(){
        var $img = $('<img class="border border-dark rounded projectFiles" src="" alt="">');
        var file = $fileInput.prop('files')[0];
        var fileType = file.type;

        if(fileType.toString() === "image/png" || fileType.toString() === "image/jpeg") {
            var reader = new FileReader();
            reader.onload = function(e) {
                $img.attr('id', e.target.result);
                $img.attr('src', e.target.result);
                $img.attr('alt', e.target.result);
                $divFileName.attr('id',e.target.result);
            };
            $divFileName.html(file.name);
            $fileInputLabel.children().remove();
            $fileInputLabel.attr("class", null);
            $fileInputLabel.append($img);
            reader.readAsDataURL(file);
        }else{
            $fileInputLabel.attr("class", "fileInput-label btn btn-dark");
            $divFileName.attr('id',file.name);
            $divFileName.html(file.name);
            $fileInputLabel.html($fullFileSpan);
            feather.replace();
        }
    });

    $tmpLabel.append($emptyFileSpan);
    $tmpLabel.attr("for", $fileInput.attr("id"));
    $vichFile.prepend($tmpLabel);
    feather.replace();
}
