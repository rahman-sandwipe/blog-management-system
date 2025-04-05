<script setup>
import { Link } from '@inertiajs/vue3'
</script>
<template>
    <div class="container">
        <div class="row border-bottom">
            <div class="col-2 pt-2">
                <img src="../Assets/img/logo.svg" width="40" />
            </div>

            <div class="col-5 text-center">
                <nav class="navbar navbar-expand">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Abouts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Tags Releted</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contacts</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-3 pt-2">
                <form >
                    <input class="form-control-sm" type="search" placeholder="Search" aria-label="Search">
                </form>
            </div>
            <div class="col-2 pt-2">
                <div class="btn-group" role="group">
                    <button class="btn btn-outline-success btn-sm" type="button">
                        <Link href="/login" >Login</Link>
                    </button>
                    <button class="btn btn-outline-success btn-sm" type="button">
                        <Link href="/register">Register</Link>
                    </button>
                </div>
            </div>
        </div>

        <main>
            <slot></slot>
        </main>
    </div>
</template>