<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-5 justify-content-center">
                <div class="card animated fadeIn w-100 p-3 mt-5">
                    <form @submit.prevent="submit" enctype="multipart/form-data">
                        <h4>Profile Update</h4>
                        <hr />
                        <div class="from-group mt-3">
                            <label>Email Address</label>
                            <input id="email" disabled v-model="form.email" placeholder="User Email" class="form-control" type="email" />
                        </div>

                        <div class="from-group mt-3">
                            <label for="password">Password</label>
                            <input id="password" v-model="form.password" class="form-control" type="text" />
                        </div>
                        
                        <div class="from-group mt-3">
                            <label for="confirm_password">Confirm Password</label>
                            <input id="confirm_password" v-model="form.confirm_password" class="form-control" type="text" />
                        </div>

                        <div class="from-group mt-3">
                            <button type="submit" class="btn mt-3 w-100  btn-success">Update</button>
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
    const toaster = createToaster();

const form = useForm({ password: "" , confirm_password: ""});
const page = usePage();

form.email = page.props.user.email;

function submit() {
    if (form.password.length === 0) {
        toaster.error("Password is required");
    }else if (form.password.length < 5) {
        toaster.error("Password must be 5 characters");
    }else if (form.confirm_password.length === 0) {
        toaster.error("Confirm Password is required");
    }else if (form.confirm_password.length < 5) {
        toaster.error("Confirm Password must be 5 characters");
    }else if (form.password !== form.confirm_password) {
        toaster.error("Password and Confirm Password does not match");
    }else {
        form.post("/change-password", {
            onSuccess: () => {
                if (page.props.flash.status === true) {
                    toaster.success(page.props.flash.message);
                } else {
                    toaster.error(page.props.flash.message);
                }
            }
        });
    }
}
</script>
