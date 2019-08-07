$(document).ready(function () {
    var dt = require( 'datatables.net');
    var labelContact = 'contact';
    var labelProjet = 'Projet';
    $('#projects-table').DataTable({
        'language':{
            "lengthMenu": "Afficher _MENU_ "+labelProjet,
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
    $('#contacts-table').DataTable({
        'language':{
            "lengthMenu": "Afficher _MENU_ "+labelContact,
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