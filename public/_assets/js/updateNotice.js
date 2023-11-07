function updateNotice(e)
    {
        e.preventDefault();
        let noticeLink = e.currentTarget;
        let link = noticeLink.href;
        fetch(link)
            .then(res=>res.json())
            .then(function(res) {
                let icon = e.target;
                if(res.status == 1) {
                    if(icon.classList == "bi bi-file-earmark"){
                        icon.classList.remove('bi-file-earmark');
                        icon.classList.add('bi-file-earmark-pdf-fill');
                    }
                } else {
                    console.log('no update');
                }
            });        
    }
let notices = document.getElementsByClassName('notice');
for(let notice of notices)
{
    notice.addEventListener('click', updateNotice);
}