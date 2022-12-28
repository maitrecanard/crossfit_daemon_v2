const blog = {

    uri:"blog",

    init: function() {
        blog.loadBlog();
    },

    loadBlog: function() {
        const config = {
            method: "GET",
            mode:"cors",
            cache:"no-cache"
        };

        const fullUrl = app.apiUrl + blog.uri;
        fetch(fullUrl, config)
        .then(
            function(response){
                return response.json();
            }
        )
        .then(
            function(data){
  
               for(const blog of data)
                {
                    blog.blogTemplate(data['title'],data['date'], data['text'],data['img']);
              }
            }
        )
    },

    blogTemplate: function(title,date,text,img){
        const blogTemplate = document.querySelector('#blog');
        const documentFragment = blogTemplate.content.cloneNode(true);
        const blog = documentFragment.firstElementChild;

        const h4 = blog.querySelector('h4');
        h4.textContent = title;

        const blogDate = blog.querySelector('.blog__content__info__date');
        blogDate.textContent = date;

        const textBlog = blog.querySelector('.blog__content__text');
        textBlog.textContent = text;

        const imgBlog = blog.querySelector('.blog__content__img');
        imgBlog.textContent = img;
        const main = document.querySelector('#main');
        main.append(blog);
    }
}