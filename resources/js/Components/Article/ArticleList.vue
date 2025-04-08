<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h3>Article</h3>
                        </div>
                        <hr />
                        <div class="float-end">
                            <Link href="/create-article?id=0" class="btn btn-success mx-3 btn-sm">
                                Add Article
                            </Link>
                        </div>
                        <div>
                            <input placeholder="Search..." class="form-control mb-2 w-auto form-control-sm" type="text"
                                v-model="searchValue">
                            <EasyDataTable
                                buttons-pagination
                                alternating
                                :headers="Header"
                                :items="Item"
                                :rows-per-page="10"
                                :search-field="searchField"
                                :items-selected="itemsSelected"
                                :search-value="searchValue" show-index>
                                <template #item-image="{ image }" class="pt-2 pb-2">
                                    <img :src="image" :alt="image" alt="" height="auto" width="40px">
                                </template>
                                <template #item-action="{ id }">
                                    <Link class="btn btn-success mx-3 btn-sm" :href="`/create-article?id=${id}`">Edit
                                    </Link>
                                    <button class="btn btn-danger btn-sm" @click="DeleteClick(id)">Delete</button>
                                </template>
                            </EasyDataTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { usePage, router, Link } from '@inertiajs/vue3'
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({position: "top-right"});
import { ref } from "vue";
let page = usePage()

const Header = [
    { text: "Image", value: "image" },
    { text: "Title", value: "title" },
    { text: "Content", value: "content" },
    { text: "Visibility", value: "visibility" },
    { text: "Action", value: "action" },
];


const Item = ref(page.props.articles)
const searchValue = ref()
const itemsSelected = ref<Item[]>([]);
const visibilityOptions = [
  { id: 'public', name: 'Public' },
  { id: 'private', name: 'Private' }
]
const DeleteClick = (id) => {
    let text = "Do you want to delete";
    if (confirm(text) === true) {
        router.get(`/delete-article/${id}`)
        toaster.success('Article Deleted Successfully');
    } else {
        text = "You canceled!";
    }
}
</script>
