<template>
    <v-layout column fill-height justify-start>
        <v-flex class="layout align-center">
            <p class="title">Программа {{ program ? program.title : ''}}</p>
            <v-spacer></v-spacer>
            <v-btn
                    :disabled="loading"
                    color="accent"
                    @click="getProgram"
                    flat
                    :loading="loading"
            >
                Обновить список
            </v-btn>
        </v-flex>
        <v-flex xs12 fill-height style="position: relative">
            <div class="scroll-container layout row wrap align-start">
                <v-flex xs12 v-show="program && program.students.length === 0 && !loading">
                    <v-subheading>Список пуст</v-subheading>
                </v-flex>

                <v-flex xs12 v-if="program" class="layout row wrap">

                    <v-flex xs12 md3 :key="student.id" v-for="student in program.students" class="px-1 py-1">
                        <v-card>
                            <v-card-title>
                                {{ student.name }}
                            </v-card-title>
                            <v-card-actions>
                                <v-menu offset-y>
                                    <v-btn
                                            :disabled="loading"
                                            slot="activator"
                                            icon
                                    >
                                        <v-icon color="accent" >more_vert</v-icon>
                                    </v-btn>
                                    <v-list>
                                        <v-list-tile>
                                            <v-list-tile-title>
                                                <a :href="student.printUrl" target="_blank" >Печать анкеты</a>
                                            </v-list-tile-title>
                                        </v-list-tile>

                                        <v-list-tile :key="file" v-for="(file, index) in student.meta.files">
                                            <v-list-tile-title>
                                                <a :href="file" target="_blank" :download="student.name + '_file_' + (index + 1)" >Файл {{ index+1 }}</a>
                                            </v-list-tile-title>
                                        </v-list-tile>
                                    </v-list>
                                </v-menu>

                                <v-spacer></v-spacer>
                                <v-tooltip top>
                                    <v-btn
                                            :disabled="loading"
                                            slot="activator"
                                            icon
                                            @click="approveStudent(student)"
                                    >
                                        <v-icon color="success" >done</v-icon>
                                    </v-btn>
                                    <span>Подтвердить</span>
                                </v-tooltip>
                                <v-tooltip top>
                                    <v-btn
                                            :disabled="loading"
                                            slot="activator"
                                            icon
                                            @click="dialog = !dialog"
                                    >
                                        <v-icon color="error" >clear</v-icon>
                                    </v-btn>
                                    <span>Отказать</span>
                                                                   
                                    <v-dialog v-model="dialog" persistent max-width="590">
                                        <v-card>
                                        <v-card-title class="headline">Укажите причину отказа</v-card-title>
                                        <v-card-text>
                                            <v-flex xs12>
                                            <v-select
                                                :items="reasons"
                                                v-model="selectedReason"
                                                :menu-props="{ maxHeight: '400' }"
                                                label="Выберите причину отказа"
                                                persistent-hint
                                                :search-input.sync="searchInput"
                                            ></v-select>
                                            <v-text-field
                                                v-show="selectedReason=='Указать свою причину'"
                                                v-model="ownReason"
                                                label="Причина"
                                                outline
                                            ></v-text-field>
                                            </v-flex>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn flat @click.native="dialog = false">Отмена</v-btn>
                                            <v-btn :disabled=isSelected flat color="error" @click.native="rejectStudent(student)">Отказать</v-btn>
                                        </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </v-tooltip> 
                            </v-card-actions>                            
                        </v-card>
                    </v-flex>

                </v-flex>
            </div>


        </v-flex>


    </v-layout>
</template>

<script>
    export default {
        name: 'students',
        props: [ 'options' ],
        data: function () {
            return {
                program: null,
                loading: false,
                dialog: false,
                selectedReason: [],
                reasons: [
                    'Отказ студенту по возрасту', 
                    'Студент отказался в участии перед стартом проекта',
                    'Студент отказался в участии во время проекта', 
                    'Указать свою причину'],
                ownReason: ""
            }
        },
        computed: {
            isSelected(){
                return (this.selectedReason.length>0) ? ((this.selectedReason=='Указать свою причину' && this.ownReason.length == 0) ? true : false) : true;
            }
        },
        methods: {
            removeStudent(student){
                this.program.students = _.filter(this.program.students, (s)=>s.id !== student.id);
            },
            approveStudent(student){
                this.loading = true;
                axios.post(App.baseUrl + '/api/students/approve', {student: student}).then(()=>{
                    AdminManager.showSuccess(`Студент ${student.name} подвержден`);
                    this.removeStudent(student);
                    this.loading = false;
                }).catch((err)=>{
                    AdminManager.showError('Ошибка действия');
                    console.log(err);
                    this.loading = false;
                });
            },
            rejectStudent(student){
                this.loading = true;
                var rejectReason = (this.selectedReason=='Указать свою причину') ? this.ownReason : this.selectedReason;
                axios.post(App.baseUrl + '/api/students/reject', {params: {student: student, reason: rejectReason} } ).then(()=>{
                    AdminManager.showSuccess(`Студенту ${student.name} отказано в участии`);
                    this.removeStudent(student);
                    this.dialog = false;
                    this.loading = false;
                }).catch((err)=>{
                    AdminManager.showError('Ошибка действия');
                    console.log(err);
                    this.loading = false;
                });
            },
            getProgram(){
                this.loading = true;
                axios.get(App.baseUrl + '/api/students').then((res)=>{

                    res.data.program.students = _.map( res.data.program.students, s=>{

                        s.meta = JSON.parse(s.meta);

                        s.printUrl = App.baseUrl + '/student/print/' + s.id;

                        s.meta.files = s.meta.files
                            ? _.map( JSON.parse(s.meta.files), f=> App.baseUrl + f)
                            : [];

                        return s;
                    });

                    this.program = res.data.program;

                    this.loading = false;
                }).catch((err)=>{
                    AdminManager.showError('Ошибка загрузки списка');
                    console.log(err);
                    this.loading = false;
                });
            }
        },
        beforeMount(){
            this.getProgram();
        },
    }
</script>