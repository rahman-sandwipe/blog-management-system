<template>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end">
                            <Link href="/ArticlePage" class="btn btn-success mx-3 btn-sm">
                                Back
                            </Link>
                        </div>
                        <form @submit.prevent="submit" enctype="multipart/form-data">
                            <div class="card-body">
                                <h4>Save Article</h4>
                                <hr />
                                <label for="title">Article Title:</label>
                                <input id="title" name="title" v-model="form.title" placeholder="Article title"
                                    class="form-control" type="text" />
                                <br />
                                <label for="content">Article Content:</label>
                                <textarea name="content" class="form-control" id="content" v-model="form.content" placeholder="Article content"></textarea>
                                <br />
                                <!-- visibility Dropdown -->
                                <div>
                                    <label for="visibility">Select visibility:</label>
                                    <select v-model="form.visibility" class="form-control" id="visibility">
                                        <option value="" disabled>Select a visibility</option>
                                        <option v-for="option in visibilityOptions" :key="option.id" :value="option.id">
                                            {{ option.name }}
                                        </option>
                                    </select>
                                </div>
                                <br />
                                <div>
                                    <label for="image">Article Image:</label> <br>
                                    <ImageUpload :articleImage="form.image" @image="(e)=>form.image = e"/>
                                </div>
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
import { useForm, usePage, router, Link } from '@inertiajs/vue3'
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster();
import { ref } from "vue";
import ImageUpload from './ImageUpload.vue'

const visibilityOptions = [
  { id: 'public', name: 'Public' },
  { id: 'private', name: 'Private' }
]
const urlParams = new URLSearchParams(window.location.search)
let id = ref(parseInt(urlParams.get('id')))

const form = useForm({ title: '', visibility: '', content: '', image: null, id: id.value || null })
const page = usePage()

let URL = "/create-article";
let list = page.props.article

if (id.value !== 0 && list !== null) {
    URL = "/update-article";
    form.id = list['id'];
    form.title = list['title'];
    form.visibility = list['visibility'];
    form.content = list['content'];
    form.image = list['image'];
}

function submit() {
    form.post(URL, {
        onSuccess: () => {
            if (page.props.flash.status === true) {
                toaster.success(page.props.flash.message);
                setTimeout(() => {
                    router.get("/articles")
                }, 500)
            } else {
                toaster.warning(page.props.flash.message)
            }
        }
    })
}

</script>
