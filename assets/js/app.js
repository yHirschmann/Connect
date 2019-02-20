/*
 * Welcome to your app's pages JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');
//require('bootstrap');


// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');
const feather = require('feather-icons');

(function () {
    'use strict';
    feather.replace();
}());

$(document).ready(function () {
    var i = 1;

    $('#sidebar').toggleClass('nav-active');

    $('#btn-vNav').on('click', function () {
        $('#sidebar').toggleClass('nav-active');
        $('#content').toggleClass('content-active');
    });

    $("#btn-add-article").click(function () {
        window.location.replace("/ajouter");
    });

    $('#btnfile'+i).on('change',function(){
        i = addNewInputFile('#btnfile'+i, i)
    });
});

function addNewInputFile(btnfileId, i) {
    $('#feather'+i).html('<span id="feather'+i+'" data-feather="save"></span>');
    i+= 1;
    $('.btn-add-files').append('<!----><label class="btn btn-outline-primary Up-file">' +
        '<input id="btnfile'+i+'" type="file" hidden>' +
        '<span id="feather'+i+'" data-feather="plus"></span></label>'
    );
    $('#btnfile'+i).on('change',function(){
        i = addNewInputFile('#btnfile'+i, i)
    });
    feather.replace();
    console.log(i);
    return i;
}