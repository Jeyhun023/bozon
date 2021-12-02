$( document ).ready(function() {
    $('[id=input-tags]').tagify();


    // $('.js-example-basic-single').select2();
    // $('.js-example-basic-multiple').select2();



    tinymce.init({
        selector: '.mytextarea'
    });
})
