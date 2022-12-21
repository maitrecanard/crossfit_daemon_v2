const mentions = {

    divMention: document.querySelector('.mentions'),
    close: document.querySelector('.close_mentions'),
    
    init: function()
    {
        const mention =  document.querySelector('.mention');
        mention.addEventListener('click', mentions.openMentions);
    },

    openMentions: function(event)
    {
        mentions.divMention.classList.add('open');
        mentions.divMention.classList.remove('close');
        mentions.close.addEventListener('click', mentions.closeMentions);
    },

    closeMentions: function(event) {
        
        mentions.divMention.classList.add('close');
        mentions.divMention.classList.remove('open');
    }
}