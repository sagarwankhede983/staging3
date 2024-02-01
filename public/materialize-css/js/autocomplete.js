/**
 * Created by avinash on 27/01/16.
 */


$(document).ready(function() {
    $(function () {

        $( "#personincharge" ).autocomplete({
            source: "/search/autocomplete",
            minLength: 2,
            select: function(event, ui) {
                $('#personincharge').val(ui.item.value);
            },
            messages:{
                noResults:'',
                results:'',
            }
        });

        $( "#kco" ).autocomplete({
            source: "/kco/autocomplete",
            minLength: 2,
            select: function(event, ui) {
                $('#kco').val(ui.item.value);
            },
            messages:{
                noResults:'',
                results:'',
            }
        });

    });
});


