<template>
    <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background: #e38d02">
        <div class="container">
            <router-link to="/" class="navbar-brand text-white fw-bold">Eyvan Kurban Hizmetleri</router-link>
            <a class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav mt-2 mt-lg-0 ms-auto">
                        <li class="nav-item ">
                            <router-link to="/" class="nav-link text-white fw-bold" aria-current="page">Anasayfa</router-link>
                        </li>
<!--                        <li class="nav-item">-->
<!--                            <router-link :to="{ name : 'public-posts.index'}" class="nav-link">Blog</router-link>-->
<!--                        </li>-->
                    <template v-if="!user?.name">
                        <li class="nav-item">
                            <router-link class="nav-link text-white fw-bold" to="/login"
                            >Giriş Yap</router-link
                            >
                        </li>
<!--                        <li class="nav-item">-->
<!--                            <router-link class="nav-link" to="/register">{{ $t('register') }}</router-link>-->
<!--                        </li>-->
                    </template>
                    <li v-if="user?.name" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ user.name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><router-link class="dropdown-item" to="/admin">Admin</router-link></li>
                            <li><router-link to="/admin/posts" class="dropdown-item">Post</router-link></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" @click="logout">Çıkış Yap</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import useAuth from "@/composables/auth";
import {computed} from "vue";
import LocaleSwitcher from "../components/LocaleSwitcher.vue";
import {useAuthStore} from "@/store/auth";
const auth = useAuthStore()

const user = computed(() => auth.user);
const { processing, logout } = useAuth();
</script>
