const mail = {

    form : document.querySelector('.form_message'),
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

        if (!name || !email || !message || !token ) 
        {
            const contentMessage = 'Veuillez renseigner tous les champs'
            mail.erreurMessage(contentMessage);
        } 
 
        mail.sendMail(name,email,message,token);
        
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
                console.log(message.errors);
                   mail.erreurMessage(message.errors);
               }
            });


        
    },

    erreurMessage: function(content) {
        if(content.email)
        {
            mail.message.textContent = content.email;
        } else 
        {
            mail.message.textContent = content;
        }
       
        mail.message.classList.add('alert-error');
        mail.form.classList.add('form_opa');
        setTimeout(mail.clearErrorMessage, 2000);
    },

    successMessage: function(content) {
        mail.message.textContent = content + ' nous vous invitons à vérifier vos spams';
        mail.message.classList.add('alert-success');
        mail.form.classList.add('form_opa');
        setTimeout(mail.clearSuccessMessage, 5000);
    },

    clearErrorMessage: function() {
        mail.message.classList.remove('alert-error');
        mail.form.classList.remove('form_opa');
       
    },

    
    clearSuccessMessage: function() {
        mail.message.classList.remove('alert-success');
        mail.form.classList.remove('form_opa');
        
    },


    cleanForm: function()
    {
        const form = document.querySelector('form');
        form.reset();
    }

}