const mail = {

    message : document.querySelector('.message'),

    uri : "sendmail",

    init: function() {
        const submit = document.querySelector('form');
        console.log(submit);
        submit.addEventListener('submit', mail.controlMail);
    },

    controlMail: function(event)
    {
        event.preventDefault();
      
        const name = document.querySelector('#message_name').value;
        console.log(name);
        const email = document.querySelector('#message_email').value;
        const message = document.querySelector('#message_content').value;
        const token = document.querySelector('#message__token').value;
        console.log(message);
       // const checkbox = document.querySelector('.cv__form__element-checkbox').checked;
       // console.log(name);
        //console.log(email);
       // console.log(text);
       // console.log(checkbox);
       //if (!name || !email || !message || checkbox === false)
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
                console.log(message.status)
                    mail.successMessage(message.success);
                    console.log('mail ok');

                    mail.cleanForm();
               } else {
                console.log(message.status)

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