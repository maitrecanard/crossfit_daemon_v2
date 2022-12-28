const app = {

    // apiUrl: "https://testapi.mathieusiaudeau.fr/api/",
    apiUrl: "https://test2023.crossfitdaemon.fr/api/",

    httpHeaders: new Headers(),

    init: function()
    {
        app.httpHeaders.append("Content-Type", "application/json");

        mail.init();
  
    }
}

app.init();