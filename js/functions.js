function showInfo(msg) {
    Swal.fire(
        'Information',
        msg,
        'success'
    );
}

function showError(msg) {
    Swal.fire(
        'Error',
        msg,
        'error'
    );

    function setGammeStyle(gamme) {
        style="";

        switch(gamme) {

            case "A": 
               style="green";
               break;

            case "B": 
            style="orange";
               break ;

            case "C":
            style="red"; 
               break;
        }
        return style;
    }
}