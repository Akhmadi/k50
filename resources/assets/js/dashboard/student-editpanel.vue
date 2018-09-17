<template>
    <v-layout row color="primary">
        <v-flex xs12 class="layout">
            <v-spacer></v-spacer>
            <v-btn
                    :href="printUrl"
                    color="accent"
                    target="_blank"
            >Печать анкеты</v-btn>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: 'student-editpanel',
        props: [ 'options', 'crud', 'item' ],
        data: function () {
            return {}
        },
        computed: {
            printUrl(){
                return App.baseUrl + '/student/print/' + (this.item ? this.item.id : '')
            }
        },
    }
</script>