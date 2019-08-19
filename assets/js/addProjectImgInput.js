require('../css/addProject.css');

var $divFileName = $('<div id="imageFileName"></div>');
var $label = $('<label id="imgInput-label" class="btn btn-dark" for="add_project_file_0_file_file">Ajouter une Photo</label>');
var $image = $('<img id="projectImage" class="border border-dark rounded" src="" alt="">');
var $collectionHolder, $imgInput;

/**
 * main
 */
$(document).ready(function () {
    $collectionHolder = $('#image-project-holder');
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    addImgInput($collectionHolder);

    $imgInput = $('input', $collectionHolder);
    $imgInput.parent().append($label);
    $imgInput.on('change',function(){
        showImage(this);
    });
});

/**
 * Transforms the prototype into HTML elements and make them appends to the collectionHolder
 * @param $collectionHolder
 */
function addImgInput($collectionHolder) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    $collectionHolder.append(newForm);
}

/**
 * Called on file input change, show the image instead of  the input
 * @param input
 */
function showImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var file = input.files[0];
        reader.onload = function(e) {
            $image.attr('src', e.target.result);
            $image.attr('alt', e.target.result);
            setFileName(file);
            setLabel();
        };
        reader.readAsDataURL(file);
    }
    removeImage(input);
}

/**
 * set the fileName of the divFileName
 * @param file
 */
function setFileName(file){
    $divFileName.html("");
    $divFileName.append(file.name);
}

/**
 * modify the label to display the image instead of the button
 */
function setLabel(){
    $label.attr('class', "labelImgSet");
    $label.html("");
    $label.append($image);
}

/**
 * add a button under the image view that allow to reset the file input
 * @param input
 */
function removeImage(input){
    var $deleteButton = $('<input type="button" class="btn btn-dark" value="Supprimer">');
    $deleteButton.click(function () {
        var $input = $(input);
        $input.val('');
        $label.attr('class', "btn btn-dark");
        $label.html("Ajouter une Photo");
        $deleteButton.remove()
    });
    $collectionHolder.append($deleteButton);
}