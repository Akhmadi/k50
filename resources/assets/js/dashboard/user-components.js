Vue.component('students', require('./students.vue') );
Vue.component('student-editpanel', require('./student-editpanel.vue') );

AdminManager.registerMiddleware( (event, options, next)=>{

    if (event == 'editpanel:on:mount' && options.crud.code == 'students') {

        options.addComponents(
            [
                {
                    id: 'student-editpanel-1',
                    name: 'student-editpanel',
                    options: { }
                }
            ]
        );
    }

    next();
});


let userComponent = {
    id: 'students-1',
    name: 'students',
    options: {
        isModal: false,
    }
};

Bus.$on('user:students:mount', ()=> AdminManager.mountComponent( userComponent , true) );
