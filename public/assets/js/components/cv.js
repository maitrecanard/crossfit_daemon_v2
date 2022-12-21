const cv = {

    uri: "cv",

    init: function()
    {
        cv.loadCv();
    },

    loadCv: function()
    {
        const config = {
            method: "GET",
            mode: "cors",
            cache: "no-cache"
        };

        const fullUrl = app.apiUrl + cv.uri;
        fetch(fullUrl, config)
        .then(
            function(response){
                return response.json();
            }
        )
        .then(
            function(data)
            {
                cv.cvTemplate();
            }
        )
    },

    cvTemplate: function()
    {
        
    }

}