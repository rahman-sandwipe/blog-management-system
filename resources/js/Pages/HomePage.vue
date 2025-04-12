<script setup>
import { Link } from '@inertiajs/vue3';
import NavLayout from '../Layout/NavLayout.vue';
defineProps({
  posts: Array
});
</script>

<template>
    <NavLayout>
        <div class="container">
            <div class="row justify-content-center">

                <div v-if="posts.length">
                    <div v-for="post in posts" :key="post.id" class="mb-4 p-4 border rounded">
                        <h2 class="text-xl font-semibold">{{ post.title }}</h2>
                        <p>{{ post.content }}</p>
                        <span class="text-sm text-gray-500">Visibility: {{ post.visibility }}</span>
                    </div>
                </div>
                <div v-else>
                    <p>No posts found.</p>
                </div>


                <div class="col-md-4 center-screen">
                    <div class="card">
                        <img src="https://picsum.photos/300/200" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 center-screen">
                    <div class="card">
                        <img src="https://picsum.photos/300/200" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 center-screen">
                    <div class="card">
                        <img src="https://picsum.photos/300/200" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                        </div>
                    </div>
                </div>
                
                
                <div class="col-md-4 center-screen">
                    <div class="card" style="width: 18rem;">
                        <img src="https://picsum.photos/300/200" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 center-screen">
                    <div class="card" style="width: 18rem;">
                        <img src="https://picsum.photos/300/200" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 center-screen">
                    <div class="card" style="width: 18rem;">
                        <img src="https://picsum.photos/300/200" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                
                
                <div class="col-md-4 center-screen">
                    <div class="card" style="width: 18rem;">
                        <img src="https://picsum.photos/300/200" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 center-screen">
                    <div class="card" style="width: 18rem;">
                        <img src="https://picsum.photos/300/200" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 center-screen">
                    <div class="card" style="width: 18rem;">
                        <img src="https://picsum.photos/300/200" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </NavLayout>
</template>
