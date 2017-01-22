$('#kommentti').keypress(function(e){
    if(e.which == 13){
        $('#lisaa_kommentti').submit();
        return false; 
    }
});