<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-5 justify-center">
                <div class="card animated fadeIn w-100 p-3">
                    <form @submit.prevent="submit" enctype="multipart/form-data">
                        <h4>Profile Update</h4>
                        <hr />
                        <div class="from-group">
                            <label for="username">Username</label>
                            <input id="username" v-model="form.username" class="form-control" type="text" />
                        </div>

                        <div class="from-group">
                            <label>Email Address</label>
                            <input id="email" disabled v-model="form.email" placeholder="User Email" class="form-control" type="email" />
                        </div>

                        <div class="col-12 p-2">
                            <label for="image">Avatar:</label> <br>
                            <ImageUpload :userImage="form.image" @image="(e)=>form.image = e"/>
                        </div>

                        <div class="from-group">
                            <button type="submit" class="btn mt-3 w-100  btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useForm, usePage, router } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster();

const form = useForm({ username: "", email: "", image: "" });
const page = usePage();
import ImageUpload from './ImageUpload.vue'

form.username = page.props.user.username;
form.email = page.props.user.email;
form.image = page.props.user.image;

function submit() {
    if (form.username.length === 0) {
        toaster.error("Name is required");
    } else if (form.email.length === 0) {
        toaster.error("Email is required");
    } else {
        form.post("/user-update", {
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
