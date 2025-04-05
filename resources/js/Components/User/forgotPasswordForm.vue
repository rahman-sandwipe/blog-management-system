<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 center-screen">
                <div class="card animated fadeIn w-90  p-4">
                    <form @submit.prevent="submit">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="../Assets/img/logo.svg" style="width: 45px !important;" />
                            </div>
                            <div class="text-center">
                                <h3>Welcome to our website</h3>
                                <p>Enter your email to receive a verification code</p>
                            </div>
                            <br/>
                            <label>Your email address</label>
                            <input id="email" v-model="form.email" placeholder="User Email" class="form-control" type="email"/>
                            <br/>

                            <button type="submit" class="btn mt-3 w-100  btn-success">Next</button>
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
    const toaster = createToaster({ position: "top-right" });

    const form = useForm({ email: "" });
    const page = usePage();

    function submit(){
        if(form.email.length === 0){
            toaster.warning("Email is required");
        }else{
            form.post("/forget-password", {
                onSuccess: () => {
                    if(page.props.flash.status === true){
                        router.get('/verify-otp');
                        toaster.success(page.props.flash.message);
                    }else{
                        toaster.error(page.props.flash.message);
                    }
                }
            });
        }
    }
</script>
