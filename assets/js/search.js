
$(document).ready(function () {
    var dt = require( 'datatables.net');
    var labelContact = 'contact';
    var labelCompanie = 'entreprise';
    var labelProject = 'projet';
    $('#contacts-table').DataTable({
        'pageLength':5,
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

    $('#companies-table').DataTable({
        'pageLength':5,
        'language':{
            "lengthMenu": "Afficher _MENU_ "+labelCompanie,
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

    $('#projects-table').DataTable({
        'pageLength':5,
        'language':{
            "lengthMenu": "Afficher _MENU_ "+labelProject,
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