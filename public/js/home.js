$(function()
{

    /* form validation */
    const username = $('#user_form_username');
    const usernameHelp = $('#usernameHelp');

    const firstname = $('#user_form_firstname');
    const firstnameHelp = $('#firstnameHelp');

    const lastname = $('#user_form_lastname');
    const lastnameHelp = $('#lastnameHelp');

    const password = $('#user_form_password_first');
    const password2 = $('#user_form_password_second');
    const passwordHelp = $('#passwordHelp');

    const email = $('#user_form_email');
    const emailHelp = $('#emailHelp');

    const country = $('#user_form_country');
    const countryHelp = $('#countryHelp');
    let valid = 0;

    // username
    username.keyup(function ()
    {
        if (username.val().length <= 3)
        {
            username.addClass('is-invalid');
            username.prev().addClass('text-danger');

            username.removeClass('is-valid');
            username.prev().removeClass('text-success');
            
            usernameHelp.show();
        }
        else
        {
            username.removeClass('is-invalid');
            username.prev().removeClass('text-danger');

            username.addClass('is-valid');
            username.prev().addClass('text-success');
            
            usernameHelp.hide();
        }
    });
    username.on('focus', function() {

        if (username.val().length <= 3)
        {
            username.addClass('is-invalid');
            username.prev().addClass('text-danger');
            usernameHelp.show();
        }
    });
    username.on('focusout', function() {
        usernameHelp.hide();
    });

    // firstname
    firstname.keyup(function ()
    {
        if (firstname.val().length <= 3)
        {
            firstname.addClass('is-invalid');
            firstname.prev().addClass('text-danger');

            firstname.removeClass('is-valid');
            firstname.prev().removeClass('text-success');
            
            firstnameHelp.show();
        }
        else
        {
            firstname.removeClass('is-invalid');
            firstname.prev().removeClass('text-danger');

            firstname.addClass('is-valid');
            firstname.prev().addClass('text-success');
            
            firstnameHelp.hide();
        }
    });
    firstname.on('focus', function() {

        if (firstname.val().length <= 3)
        {
            firstname.addClass('is-invalid');
            firstname.prev().addClass('text-danger');
            firstnameHelp.show();
        }
    });
    firstname.on('focusout', function() {
        firstnameHelp.hide();
    });

    // lastname
    lastname.keyup(function ()
    {
        if (lastname.val().length <= 3)
        {
            lastname.addClass('is-invalid');
            lastname.prev().addClass('text-danger');

            lastname.removeClass('is-valid');
            lastname.prev().removeClass('text-success');
            
            lastnameHelp.show();
        }
        else
        {
            lastname.removeClass('is-invalid');
            lastname.prev().removeClass('text-danger');

            lastname.addClass('is-valid');
            lastname.prev().addClass('text-success');
            
            lastnameHelp.hide();
        }
    });
    lastname.on('focus', function() {

        if (lastname.val().length <= 3)
        {
            lastname.addClass('is-invalid');
            lastname.prev().addClass('text-danger');
            lastnameHelp.show();
        }
    });
    lastname.on('focusout', function() {
        lastnameHelp.hide();
    });

    // password
    regex = new RegExp('^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9!?@#$%^&*()_]+){8,20}$');
    regex1 = new RegExp('([A-Z]+)');
    regex2 = new RegExp('([0-9]+)');

    password.keyup(function ()
    {
        // green up first check
        if (password.val() == password2.val() && password.val().length != 0 && password2.val().length != 0)
        {
            $('.pw-check-1').addClass('text-success');
            $('.pw-check-1').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-1').removeClass('text-success');
            $('.pw-check-1').addClass('text-danger');
        }
        // green up second check
        if (password.val().length >= 8)
        {
            $('.pw-check-2').addClass('text-success');
            $('.pw-check-2').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-2').removeClass('text-success');
            $('.pw-check-2').addClass('text-danger');
        }
        // green up third check
        if (regex1.test(password.val()))
        {
            $('.pw-check-3').addClass('text-success');
            $('.pw-check-3').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-3').removeClass('text-success');
            $('.pw-check-3').addClass('text-danger');
        }
        // green up forth check
        if (regex2.test(password.val()))
        {
            $('.pw-check-4').addClass('text-success');
            $('.pw-check-4').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-4').removeClass('text-success');
            $('.pw-check-4').addClass('text-danger');
        }

        // checking if password length is minimum 8
        // or if password contains the required regex
        if (password.val().length < 8 || !regex.test(password.val()))
        {
            password.addClass('is-invalid');
            password.prev().addClass('text-danger');
            password2.addClass('is-invalid');
            password2.prev().addClass('text-danger');

            password.removeClass('is-valid');
            password.prev().removeClass('text-success');
            password2.removeClass('is-valid');
            password2.prev().removeClass('text-success');
            
            passwordHelp.show();
        }
        else
        {
            password.removeClass('is-invalid');
            password.prev().removeClass('text-danger');
            password2.removeClass('is-invalid');
            password2.prev().removeClass('text-danger');

            password.addClass('is-valid');
            password.prev().addClass('text-success');
            password2.addClass('is-valid');
            password2.prev().addClass('text-success');
            
            passwordHelp.hide();
        }

        // check if password matches
        if (password.val() != password2.val() || password2.val().length < 8 || password.val().length < 8 || password.val().length == 0 || password2.val().length == 0 || !regex.test(password.val()) || !regex.test(password2.val()))
        {
            password.addClass('is-invalid');
            password.prev().addClass('text-danger');
            password2.addClass('is-invalid');
            password2.prev().addClass('text-danger');

            password.removeClass('is-valid');
            password.prev().removeClass('text-success');
            password2.removeClass('is-valid');
            password2.prev().removeClass('text-success');
            
            passwordHelp.show();
        }
        else
        {
            password.removeClass('is-invalid');
            password.prev().removeClass('text-danger');
            password2.removeClass('is-invalid');
            password2.prev().removeClass('text-danger');

            password.addClass('is-valid');
            password.prev().addClass('text-success');
            password2.addClass('is-valid');
            password2.prev().addClass('text-success');
            
            passwordHelp.hide();
        }
    });
    password.on('focus', function() 
    {
        // green up first check
        if (password2.val() == password.val() && password.val().length != 0 && password2.val().length != 0)
        {
            $('.pw-check-1').addClass('text-success');
            $('.pw-check-1').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-1').removeClass('text-success');
            $('.pw-check-1').addClass('text-danger');
        }
        // green up second check
        if (password.val().length >= 8)
        {
            $('.pw-check-2').addClass('text-success');
            $('.pw-check-2').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-2').removeClass('text-success');
            $('.pw-check-2').addClass('text-danger');
        }
        // green up third check
        if (regex1.test(password.val()))
        {
            $('.pw-check-3').addClass('text-success');
            $('.pw-check-3').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-3').removeClass('text-success');
            $('.pw-check-3').addClass('text-danger');
        }
        // green up forth check
        if (regex2.test(password.val()))
        {
            $('.pw-check-4').addClass('text-success');
            $('.pw-check-4').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-4').removeClass('text-success');
            $('.pw-check-4').addClass('text-danger');
        }

        if (password.val().length < 8 || !regex.test(password.val()))
        {
            password.addClass('is-invalid');
            password.prev().addClass('text-danger');
            password2.addClass('is-invalid');
            password2.prev().addClass('text-danger');
            passwordHelp.show();
        }
    });
    password.on('focusout', function() {
        passwordHelp.hide();
    });
    // password 2
    password2.keyup(function ()
    {
        // green up first check
        if (password2.val() == password.val() && password.val().length != 0 && password2.val().length != 0)
        {
            $('.pw-check-1').addClass('text-success');
            $('.pw-check-1').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-1').removeClass('text-success');
            $('.pw-check-1').addClass('text-danger');
        }
        // green up second check
        if (password2.val().length >= 8)
        {
            $('.pw-check-2').addClass('text-success');
            $('.pw-check-2').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-2').removeClass('text-success');
            $('.pw-check-2').addClass('text-danger');
        }
        // green up third check
        if (regex1.test(password2.val()))
        {
            $('.pw-check-3').addClass('text-success');
            $('.pw-check-3').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-3').removeClass('text-success');
            $('.pw-check-3').addClass('text-danger');
        }
        // green up forth check
        if (regex2.test(password2.val()))
        {
            $('.pw-check-4').addClass('text-success');
            $('.pw-check-4').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-4').removeClass('text-success');
            $('.pw-check-4').addClass('text-danger');
        }

        if (password2.val().length < 8 || !regex.test(password2.val()))
        {
            password2.addClass('is-invalid');
            password2.prev().addClass('text-danger');
            password.addClass('is-invalid');
            password.prev().addClass('text-danger');

            password2.removeClass('is-valid');
            password2.prev().removeClass('text-success');
            password.removeClass('is-valid');
            password.prev().removeClass('text-success');
            
            passwordHelp.show();
        }
        else
        {
            password2.addClass('is-invalid');
            password2.prev().addClass('text-danger');
            password.addClass('is-invalid');
            password.prev().addClass('text-danger');

            password2.removeClass('is-valid');
            password2.prev().removeClass('text-success');
            password.removeClass('is-valid');
            password.prev().removeClass('text-success');
            
            passwordHelp.hide();
        }

        // check if password matches
        if (password2.val() != password.val() || password2.val().length < 8 || password.val().length < 8 || password.val().length == 0 || password2.val().length == 0 || !regex.test(password.val()) || !regex.test(password2.val()))
        {
            password2.addClass('is-invalid');
            password2.prev().addClass('text-danger');
            password.addClass('is-invalid');
            password.prev().addClass('text-danger');

            password2.removeClass('is-valid');
            password2.prev().removeClass('text-success');
            password.removeClass('is-valid');
            password.prev().removeClass('text-success');
            
            passwordHelp.show();
        }
        else
        {
            password2.removeClass('is-invalid');
            password2.prev().removeClass('text-danger');
            password.removeClass('is-invalid');
            password.prev().removeClass('text-danger');

            password2.addClass('is-valid');
            password2.prev().addClass('text-success');
            password.addClass('is-valid');
            password.prev().addClass('text-success');
            
            passwordHelp.hide();
        }
    });
    password2.on('focus', function() 
    {
        // green up first check
        if (password.val() == password2.val() && password1.val().length != 0 && password2.val().length != 0)
        {
            $('.pw-check-1').addClass('text-success');
            $('.pw-check-1').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-1').removeClass('text-success');
            $('.pw-check-1').addClass('text-danger');
        }
        // green up second check
        if (password2.val().length >= 8)
        {
            $('.pw-check-2').addClass('text-success');
            $('.pw-check-2').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-2').removeClass('text-success');
            $('.pw-check-2').addClass('text-danger');
        }
        // green up third check
        if (regex1.test(password2.val()))
        {
            $('.pw-check-3').addClass('text-success');
            $('.pw-check-3').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-3').removeClass('text-success');
            $('.pw-check-3').addClass('text-danger');
        }
        // green up forth check
        if (regex2.test(password2.val()))
        {
            $('.pw-check-4').addClass('text-success');
            $('.pw-check-4').removeClass('text-danger');
        }
        else
        {
            $('.pw-check-4').removeClass('text-success');
            $('.pw-check-4').addClass('text-danger');
        }

        if (password2.val().length < 8 || !regex.test(password2.val()))
        {
            password2.addClass('is-invalid');
            password2.prev().addClass('text-danger');
            password.addClass('is-invalid');
            password.prev().addClass('text-danger');
            passwordHelp.show();
        }
    });
    password2.on('focusout', function() {
        passwordHelp.hide();
    });

    // email
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }

    email.keyup(function ()
    {
        if (!isValidEmailAddress(email.val()))
        {
            email.addClass('is-invalid');
            email.prev().addClass('text-danger');

            email.removeClass('is-valid');
            email.prev().removeClass('text-success');
            
            emailHelp.show();
        }
        else
        {
            email.removeClass('is-invalid');
            email.prev().removeClass('text-danger');

            email.addClass('is-valid');
            email.prev().addClass('text-success');
            
            emailHelp.hide();
        }
    });
    email.on('focus', function() {

        if (!isValidEmailAddress(email.val()))
        {
            email.addClass('is-invalid');
            email.prev().addClass('text-danger');
            emailHelp.show();
        }
    });
    email.on('focusout', function() {
        emailHelp.hide();
    });

    // country
    const countries = [
        "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"
    ];    

    $.each(countries, function(key, value)
    {
        $('.countries').append('<li>'+ value +'</li>');
    });
    
    country.keyup(function ()
    {
        if ($.inArray(country.val(), countries) < 0)
        {
            country.addClass('is-invalid');
            country.prev().addClass('text-danger');

            country.removeClass('is-valid');
            country.prev().removeClass('text-success');
            
            countryHelp.show();

            let value = $(this).val().toLowerCase();

            $('.countries li').filter(function (){
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        }
        else
        {
            country.removeClass('is-invalid');
            country.prev().removeClass('text-danger');

            country.addClass('is-valid');
            country.prev().addClass('text-success');
            
            countryHelp.hide();
        }
    });
    country.on('focus', function() {

        if (!isValidEmailAddress(country.val()))
        {
            country.addClass('is-invalid');
            country.prev().addClass('text-danger');
            countryHelp.show();
        }
    });
    country.on('focusout', function() {
        countryHelp.hide();
    });


});