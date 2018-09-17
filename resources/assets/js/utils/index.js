export default {
    onReady(cb){
        if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading"){
            cb();
        } else {
            document.addEventListener('DOMContentLoaded', cb);
        }
    },
    forEach(arr, cb) {
        for (let i = 0; i < arr.length; i++)
            cb(arr[i], i);
    },
    sharer(){
        let _sharer = {
            vkontakte: (purl, ptitle, pimg, text)=>{
                url  = 'http://vkontakte.ru/share.php?';
                url += 'url='          + encodeURIComponent(purl);
                url += '&title='       + encodeURIComponent(ptitle);
                url += '&description=' + encodeURIComponent(text);
                url += '&image='       + encodeURIComponent(pimg);
                url += '&noparse=true';
                _sharer.popup(url);
            },
            odnoklassniki: (purl, text)=> {
                let url  = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1';
                url += '&st.comments=' + encodeURIComponent(text);
                url += '&st._surl='    + encodeURIComponent(purl);
                _sharer.popup(url);
            },
            facebook: (purl, ptitle, pimg, text)=> {

                let url  = 'http://www.facebook.com/sharer.php?';
                // url += '&p[title]='     + encodeURIComponent(ptitle);
                // url += '&p[summary]='   + encodeURIComponent(text);
                url += '&u='       + encodeURIComponent(purl);
                // url += '&p[images][0]=' + encodeURIComponent(pimg);

                _sharer.popup(url);
            },
            twitter: (purl, ptitle)=> {
                let url  = 'http://twitter.com/share?';
                url += 'text='      + encodeURIComponent(ptitle);
                url += '&url='      + encodeURIComponent(purl);
                url += '&counturl=' + encodeURIComponent(purl);
                _sharer.popup(url);
            },
            mailru: (purl, ptitle, pimg, text)=> {
                let url  = 'http://connect.mail.ru/share?';
                url += 'url='          + encodeURIComponent(purl);
                url += '&title='       + encodeURIComponent(ptitle);
                url += '&description=' + encodeURIComponent(text);
                url += '&imageurl='    + encodeURIComponent(pimg);
                _sharer.popup(url);
            },
            linkedin: (purl, ptitle, pimg, text)=>{
                let url  = 'https://www.linkedin.com/shareArticle?';
                url += 'mini='          + encodeURIComponent('true');
                url += '&url='          + encodeURIComponent(purl);
                url += '&title='       + encodeURIComponent(ptitle);
                url += '&summary=' + encodeURIComponent(text);
                _sharer.popup(url);
            },

            popup: (url)=> {
                window.open(url,'','toolbar=0,status=0,width=626,height=436');
            }
        };

        return _sharer;
    }
}