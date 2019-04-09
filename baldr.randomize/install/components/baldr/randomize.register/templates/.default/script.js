$.validator.addMethod( "phoneRU", function( phone_number, element ) {
    let ruPhone_number = phone_number.replace( /\(|\)|\s+|-/g, "" );
    return this.optional(element) || ruPhone_number.length > 9 && /^([0-9]){10}$/.test( ruPhone_number );
}, "Введите корректный номер телефона" );

$(document).ready(function(){
    $("#ol-register").validate({
        rules:{
            companyName:{
                required: true,
                minlength: 4,
            },
            personName:{
                required: true,
                minlength: 4,
            },
            email:{
                required: true,
            },
            phone:{
                required: true,
                phoneRU: true,
            },
            confirmRules:{
                required: true,
            },
            confirmOrder:{
                required: true,
            }

        },
    });

});