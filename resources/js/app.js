/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
/* Vue.component('modal', {
    template: '#modal-template'
  }); */

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    //el: '#app',
    el: "#vue-crud-wrapper",

    data: {
        newDeveloper: { 'fname': '','lname': '','email': '','phone': '','address': '', 'avatar': '' },
        developers: [],
        hasError: true,
        //hasDeleted: true,
        //showModal: false,
        e_fname: '',
        e_lname: '',
        e_id: '',
        e_email: '',
        e_phone: '',
        e_address: '',
        e_avatar: '',
        deleteItems: [],
        //select: '',
        all_select: false
    },

    mounted: function mounted() {
        this.getDevelopers();
    },

    methods: {
        // create operation
        createDeveloper: function createDeveloper() {
            var _this = this;
            var input = this.newDeveloper;

            /* const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            } */
            
            if (input['fname'] == '' || input['lname'] == '' || input['email'] == '' || input['phone'] == '' || input['address'] == '' ) {
              this.hasError = false;
            } else {
              this.hasError = true;
              axios.post('/storeDeveloper', input).then(function (response) {
                _this.newDeveloper = { 'fname': '','lname': '','email': '','phone': '','address': '','avatar':'' };
                _this.getDevelopers();
              });
            }
        },

        // avatar image
        onFileChange(event){
            this.newDeveloper.avatar = event.target.files[0];
        },

        // read operation
        getDevelopers: function getDevelopers() {
            var _this = this;
      
            axios.get('/readDeveloper').then(function (response) {
              _this.developers = response.data;
            });
        },

        setVal(val_id, val_fname, val_lname, val_email, val_phone, val_address) {
            this.e_id = val_id;
            this.e_fname = val_fname;
            this.e_lname = val_lname;
            this.e_email = val_email;
            this.e_phone = val_phone;
            this.e_address = val_address;
            //this.e_avatar = val_avatar;
        },

        // update operation
        editDeveloper: function(){
            var _this = this;
            var id_val_1 = document.getElementById('e_id');
            var fname_val_1 = document.getElementById('e_fname');
            var lname_val_1 = document.getElementById('e_lname');
            var email_val_1 = document.getElementById('e_email');
            var phone_val_1 = document.getElementById('e_phone');
            var address_val_1 = document.getElementById('e_address');
            //var avatar_val_1 = document.getElementById('e_avatar');
            //var model = document.getElementById('myModal').value;
            axios.post('/editDeveloper/' + id_val_1.value, {val_1: fname_val_1.value, val_2: lname_val_1.value, val_3: email_val_1.value, val_4: phone_val_1.value, val_5: address_val_1.value})
               .then(response => {
                 _this.getDevelopers();
                 $('#myModal').modal('hide');
            });
        },

        // delete operation
        deleteDeveloper: function deleteDeveloper(dev) {
            var _this = this;
            axios.post('/deleteDeveloper/' + dev.id).then(function (response) {
                _this.getDevelopers();
                //$('#delModal').modal('hide');
            });
        },

        // allow multiple deletion
        select_all_via_check_box(){
            if(this.all_select == false){
                this.all_select = true;
                this.developers.forEach(dev => {
                  this.deleteItems.push(dev.id);
                });
            }else{
                this.all_select = false;
                this.deleteItems = [];
            }
        },

        deleteUser() {
            axios.post('/deleteDevelopers/'+this.deleteItems)
                 .then((response) => {
                    this.getDevelopers();
                    this.deleteItems = [];
                    this.all_select == true ? 
                         this.all_select = false : this.all_select = true;
                 })
        },

    },

});
