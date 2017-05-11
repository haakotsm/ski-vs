/**
 * Created by nguyen.duy.j.khac on 11.05.2017.
 */


console.log("script loaded");
$(document).ready(function () {
    $('a').on('click', function (e) {
        e.preventDefault();
        var pageRef = $(this).attr('href');
        callPage(pageRef)
    });
});

function callPage(pageRefInput) {
    $.ajax({
        url: pageRefInput,
        type: "GET",
        dataType: "text",

        success: function (response) {
            $('#main-view').html(response);
        },

        error: function (error) {
            console.log("page not loaded", error);
        },

        complete: function (xhr, status) {
            console.log(xhr, status);
            console.log("FÆRDI");
        }
    })
}


