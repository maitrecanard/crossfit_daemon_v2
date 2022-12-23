const mail = {

    message : document.querySelector('.message'),

    uri : "sendmail",

    init: function() {
        const submit = document.querySelector('form');
        submit.addEventListener('submit', mail.controlMail);
    },

    controlMail: function(event)
    {
        event.preventDefault();
      
        const name = document.querySelector('#message_name').value;
        const email = document.querySelector('#message_email').value;
        const message = document.querySelector('#message_content').value;
        const token = document.querySelector('#message__token').value;
        console.log(message);

        if (!name || !email || !message || !token ) 
        {
            const contentMessage = 'Veuillez renseigner tous les champs'
            mail.erreurMessage(contentMessage);
        } 
 
        mail.sendMail(name,email,message,token);
        
    },

    clearErrorMessage: function() {
        mail.message.classList.remove('error');
    },

    
    clearSuccessMessage: function() {
        mail.message.classList.remove('success');
        mail.message.textContent = "";
    },

    sendMail: function(name,email,message,token)
    {
        const data = {
            "name" : name,
            "email" : email,
            "content" : message,
            "token" :token
            //"checkbox" : checkbox
        }

        const config = {
            method: "POST",
            mode: "cors",
            cache: "no-cache",
            headers: app.httpHeaders,
            body: JSON.stringify(data)
        }

        const fullUrl = app.apiUrl + mail.uri;
        fetch(fullUrl, config)
        .then(function(response){
            return  response.json();
        })
        .then(
            function(message)
            {
                
               if (message.status === 201)
               {
                    mail.successMessage(message.success);

                    mail.cleanForm();
               } else {
                   mail.erreurMessage(message.errors);
                   mail.cleanForm();
               }
            });


        
    },

    erreurMessage: function(content) {
        mail.message.textContent = content;
        mail.message.classList.add('error');
        setTimeout(mail.clearErrorMessage, 3000);
    },

    successMessage: function(content) {
        mail.message.textContent = content + ' nous vous invitons à vérifier vos spams';
        mail.message.classList.add('success');
        setTimeout(mail.clearSuccessMessage, 3000);
    },

    cleanForm: function()
    {
        const form = document.querySelector('form');
        form.reset();
    }

}