const app = {

    // apiUrl: "https://testapi.mathieusiaudeau.fr/api/",
    apiUrl: "http://localhost:8081/api/",

    httpHeaders: new Headers(),

    init: function()
    {
        app.httpHeaders.append("Content-Type", "application/json");

        mail.init();
  
    }
}

app.init();