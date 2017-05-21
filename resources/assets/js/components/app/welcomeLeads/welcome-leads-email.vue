<template>
    <form name="sentMessage" id="contactForm" novalidate>
        <div class="row control-group">
            <div class="form-group col-xs-12 floating-label-form-group controls">
                <label>Email Address</label>
                <input type="text" autocomplete="off" class="form-control" placeholder="Enter Email Address" id="email" v-model="email"/>

                <div v-if="emailError" v-bind="emailError">
                    <ul>
                        <li id="emailError" class="alert alert-danger mt-error">{{emailError}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <br>
        <div id="success"></div>
        <div class="row">
            <div class="form-group col-xs-12">
                <button @click="formPost" type="submit" class="btn btn-success btn-lg">Send</button>
            </div>
        </div>
    </form>
</template>
<style>
    .mt-error {
        margin-top: 2rem;
    }
</style>
<script>

    let sweet = require('sweetalert');

    export default {
        props: ['csrf'],
        data(){
            return{
                leads: [],
                email: null,
                emailError: false
            }
        },
        mounted() {
            console.log('welcome-leads-email Component is  ready.');

            let self = this;

            // remove error text once user enters email field.
            $('#email').focus(function(){
                self.emailError = false;
                $('#email').css('caret-color', 'red');
            });

        },
        methods: {
            formPost: function(e) {
                e.preventDefault();

                let self = this;

                axios
                    .post('/welcomeEmail', {
                        email: self.email,
                        _token: self.csrf
                    })
                    .then(function (response) {
                        self.email = null;
                        self.emailError = false;
                        sweet({
                            title: "Thanks!",
                            text: "Email Sent...",
                            timer: 4000,
                            showConfirmButton: true
                        });
                    })
                    .catch(function (error) {
                        if (typeof error.response.data.email !== 'undefined') {
                            self.emailError = error.response.data.email[0]
                        } else {
                            // get sweet alert error.
                            function getErrorLocation(){
                                try { throw Error('') } catch(err) { return err; }
                            }
                            let local = getErrorLocation();
                            let msg = local.stack;
                            sweet(error.message, msg, "error");
                        }
                    })
                ;
            }
        },
        computed: {

        }
    }
</script>
