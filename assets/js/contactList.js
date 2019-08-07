$(document).ready(function () {
    var dt = require( 'datatables.net');
    var label = 'contact';
    $('#contacts-table').DataTable({
        'language':{
            "lengthMenu": "Afficher _MENU_ "+label,
            "emptyTable": "Aucun résultat correspondant à votre recherche",
            "zeroRecords": "",
            "info": "_PAGE_ sur _PAGES_",
            "search": 'Recherche',
            "infoEmpty": "",
            "infoFiltered": "(filtré de _MAX_ résultats)",
            "paginate": {
                "next":       "Suivant",
                "previous":   "Précédent",
            },
        },
    });
});