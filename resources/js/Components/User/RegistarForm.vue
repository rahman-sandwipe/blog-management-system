<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6 center-screen mt-3">
                <div class="card animated fadeIn w-100 p-3">
                    <form @submit.prevent="submit" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="../Assets/img/logo.svg" style="width: 45px !important;" />
                            </div>
                            <div class="text-center">
                                <h3>Welcome to our website</h3>
                                <p>Sign up to get started</p>
                            </div>
                            <div class="container-fluid m-0 p-0">
                                <div class="row">
                                    <div class="col-12 p-2">
                                        <label>Username</label>
                                        <input id="username" v-model="form.username" placeholder="username" class="form-control" type="text" />
                                    </div>

                                    <div class="col-12 p-2">
                                        <label>Email Address</label>
                                        <input id="email" v-model="form.email" placeholder="User Email" class="form-control" type="email" />
                                    </div>

                                    <div class="col-12 p-2">
                                        <label>Password</label>
                                        <input id="password" v-model="form.password" placeholder="User Password" class="form-control" type="password" />
                                    </div>

                                    <div class="col-12 p-2">
                                        <label for="image">Product Image:</label> <br>
                                        <ImageUpload :productImage="form.image" @image="(e)=>form.image = e"/>
                                    </div>

                                    <div class="col-12 p-2">
                                        <button type="submit" class="btn mt-3 w-100  btn-success">Register</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { Link, useForm, usePage, router } from "@inertiajs/vue3";
    import { createToaster } from "@meforma/vue-toaster";
    const toaster = createToaster({
        position: "top-right",
        duration: 2000,
    });

    const form = useForm({ username: "", email: "", password: "" , image: ""});
    const page = usePage();
    import ImageUpload from './ImageUpload.vue'

    function submit(){
        if(form.username.length === 0){
            toaster.warning("Username is required");
        }else if(form.email.length === 0){
            toaster.warning("Email is required");
        }else if(form.password.length === 0){
            toaster.warning("Password is required");
        }else{
            form.post("/register", {
                onSuccess: () => {
                    if(page.props.flash.status === true){
                        router.get('/dashboard');
                        toaster.success("Registration successful");
                    }else{
                        toaster.error(page.props.flash.message);
                    }
                }
            });
        }
    }
</script>
