tinymce.init({
    selector: 'textarea.article',
    height: 350,
    theme: 'modern',
    plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
    ],
    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
    toolbar2: 'preview link media image | forecolor backcolor emoticons | help',
    language: 'fr_FR'
});

tinymce.init({
    selector: 'textarea#commentaire',
    height: 150,
    theme: 'modern',
    plugins: [
    'advlist autolink lists charmap hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars fullscreen',
    'insertdatetime nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern help'
    ],
    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor emoticons | help',
    language: 'fr_FR'
});
