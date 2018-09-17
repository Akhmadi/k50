export default {
    el: '#app',
    data: {
        search:{
            isPanelVisible: false,
            value: '',
            items: [],
            tmr: null
        },
        menuWrapper:{
            isVisible: false
        },
        studentRegisterForm: {
            data: {},
            state: 'hidden'
        },
        loginForm:{
            data: {},
            state: 'hidden'
        },
        messages: [],
        subscribeEmail: '',
        feedbackForm: {
            name: null,
            email: null,
            subject: null,
            text: null
        }
    },
    computed:{
        searchGroups(){
            let groups = [];

            this.search.items.forEach((item)=>{
                if (groups.indexOf(item.type) < 0 ) groups.push(item.type);
            })

            return groups;
        }
    },
    beforeMount(){
        if (messages.length){
            let tmr = setTimeout(()=>{
                for( var i = 0; i <= messages.length - 1; i++){
                    if (messages[i].length > 0 ) this.showMessage(messages[i]);
                };

                clearTimeout(tmr);
             }, 1000);
        }
    },

    methods: {
        validateEmail(email) {
            let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        },

        clearFeedback(){
            this.feedbackForm.name = null;
            this.feedbackForm.email = null;
            this.feedbackForm.subject = null;
            this.feedbackForm.text = null;
        },

        checkFeedback(){

            return this.feedbackForm.name &&
                this.feedbackForm.email &&
                this.feedbackForm.subject &&
                this.feedbackForm.text;
        },

        feedback(){
            if (this.checkFeedback()){

                axios.post(baseUrl + '/api/feedback', this.feedbackForm )
                    .then((resp)=>{
                        this.showMessage('Спасибо за обратную связь!');
                        this.clearFeedback();
                    })
                    .catch((err)=>{
                        this.showMessage('Возникли проблемы, мы уже занимаемся решением!');
                        console.log( err );
                    });


            } else {
                this.showMessage('Заполните поля формы обратной связи!');
            }
        },
        subscribe(){

            if (this.validateEmail(this.subscribeEmail)){

                axios.post(baseUrl + '/api/subscribe', { email: this.subscribeEmail })
                    .then((resp)=>{
                        this.showMessage('Спасибо за подписку, будем держать вас в курсе!');
                    })
                    .catch((err)=>{
                        this.showMessage('Возникли проблемы, мы уже занимаемся решением!');
                        console.log( err );
                    });

                this.subscribeEmail = '';
            } else {
                this.showMessage('Введите верный e-mail адрес!');
            }
        },

        deleteMessage(message){
            message.visible = false;
            clearTimeout(message.tmr);

            if (this.messages.indexOf(message) >= 0) {
                this.messages.splice(this.messages.indexOf(message), 1);
            }
        },

        showMessage(messageText){

            let message = { text: messageText, tmr: null, visible: true, id: Math.random() };
            this.messages.push( message );

            // message.tmr = setTimeout(()=>{
            //     this.deleteMessage(message);
            // }, 3000);
        },
        // sendStudentRegistrationForm(){
        //     let fd  = new FormData();
        //
        //     Object.keys( this.studentRegisterForm.data).forEach((k)=>{
        //         fd.append(k , this.studentRegisterForm.data[k]);
        //     });
        //
        //     console.log('fd' , fd);
        //     axios.post(studentRegisterUrl, fd)
        //         .then(()=>{
        //             alert('ok');
        //         })
        //         .catch((err)=>{
        //             alert(err);
        //         });
        // },

        setFormFile(e){
            let inputName = e.target.getAttribute('name');

            this.$set(this.studentRegisterForm.data, inputName, e.target.files[0]);
        },

        searchItemsByGroup(group){
            return this.search.items.filter((i)=>{
                return i.type === group;
            });
        },
        toggleSearchPanel(){
            this.search.isPanelVisible = !this.search.isPanelVisible;
        },
        toggleMenuWrapper(){
            this.menuWrapper.isVisible = !this.menuWrapper.isVisible;
        },

        doSearch(){
            axios.get( baseUrl + '/api/search/' + this.search.value)
                .then((resp)=>{
                    this.search.items = resp.data.items;
                }).catch((err)=>{
                    console.log('search error:', err);
            });

        },
        // toggleStudentForm(){
        //     this.studentRegisterForm.state = this.studentRegisterForm.state === 'hidden' ? 'visible' : 'hidden';
        // },
        // toggleLoginForm(){
        //
        // },
        searchValueChanged(e){
            try{

                if (this.search.tmr) {
                    clearTimeout(this.search.tmr);
                }

                if (e.target.value.trim() !== '') {

                    this.search.tmr = setTimeout(()=>{

                        this.search.items = [];
                        this.doSearch();
                    }, 1000);
                } else {

                    this.search.items = [];
                }
            } catch (e) {
                console.log('searchValueChanged', e);
            }
        }
    }

}
