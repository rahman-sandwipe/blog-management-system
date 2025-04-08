<template>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end">
                            <Link href="/TagPage" class="btn btn-success mx-3 btn-sm">
                            Back
                            </Link>
                        </div>
                        <form @submit.prevent="submit">
                            <div class="card-body">
                                <h4>Save Tag</h4>
                                <input id="name" v-model="form.name" name="name" placeholder="Tag Name"
                                    class="form-control" type="text" />
                                <br />
                                <button type="submit" class="btn w-100 btn-success">Save Change</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm, usePage, router } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
import { ref } from "vue";

const urlParams = new URLSearchParams(window.location.search);
let id = ref(parseInt(urlParams.get("id")));

const form = useForm({ name: "", id: id });
const page = usePage();

let URL = "/create-tag";
let tag = page.props.tag;

if (id.value !== 0 && tag !== null) {
    URL = "/update-tag";
    form.name = tag.name;
}

function submit() {
    if (form.name.length === 0) {
        toaster.warning("Name is required");
    } else {
        form.post(URL, {
            onSuccess: () => {
                if (page.props.flash.status === true) {
                    router.get('/TagPage');
                    toaster.success(page.props.flash.message);
                } else {
                    toaster.error(page.props.flash.message);
                }
            }
        });
    }
}

</script>
