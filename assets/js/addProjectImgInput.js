require('../css/addProject.css');
var $divFileName = $('<div id="imageFileName"></div>');
var $image = $('<img id="projectImage" class="border border-dark rounded" src="" alt="">');
var $imgInput, $label, $parent;

$(document).ready(function () {
    $imgInput = $('#add_project_imageFile_file');
    $label = $imgInput.next();
    $parent = $imgInput.parent();

    $parent.append($divFileName);
    $imgInput.on('change',function(){
        showImage(this);
    });
});

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
