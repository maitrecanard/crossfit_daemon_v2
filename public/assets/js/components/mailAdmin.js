const mailAdmin = {

    url: 'http://localhost:8080/api/',
    span: document.querySelector('#newmail'),

    init: function() {
        console.log('ok');
      //  mail.searchNewMail;
        setTimeout(mailAdmin.searchNewMail,0000);
        setInterval(mailAdmin.searchNewMail,1000);

    },

    searchNewMail: function() {
        const conf = {
            method: "GET",
            mode: 'cors',
            cache: 'no-cache'
        }
        const paramUrl = 'getnewmail';


        fetch(mailAdmin.url + paramUrl, conf)
        .then(function(response){
            return response.json();
        }).then(function(reception){
      
            
            if (reception.mail == 0) {
                
                if(mailAdmin.span) {
                    mailAdmin.span.remove();
                }

            } else {
                
                if(mailAdmin.span) {
                    mailAdmin.span.remove();
                }
         
                const spanNewMail = document.querySelector('#messagesDropdown');
                const span = document.createElement('span');
                span.setAttribute('id','newmail');
                span.classList.add('badge','badge-danger','badge-counter');
                spanNewMail.appendChild(span);
                span.textContent = reception.mail;
            }
        })
    }

}