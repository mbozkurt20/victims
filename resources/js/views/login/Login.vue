<template>
    <div class=""  style="background-image: url('/images/21.jpg');background-size: cover; background-repeat: no-repeat; background-position: center;">
       <div class="container">
           <div class="row justify-content-center align-items-center min-vh-100">
               <div class="col-md-6 col-lg-5">
                   <div class="card shadow-lg border-0">
                       <div class="card-body p-5 rounded-3"  style="background: #e38d02">
                           <h3 class="card-title mb-4 text-center text-white fw-bold">Giriş Yap</h3>
                           <form @submit.prevent="submitLogin">
                               <!-- Email -->
                               <div class="mb-3">
                                   <label for="email" class="form-label text-white fw-bold">{{ $t('email') }}</label>
                                   <input v-model="loginForm.email" id="email" type="email" class="form-control" autofocus autocomplete="username">
                                   <div class="text-white fw-bold mt-1" v-if="validationErrors?.email">
                                       <div v-for="message in validationErrors.email">{{ message }}</div>
                                   </div>
                               </div>

                               <!-- Password -->
                               <div class="mb-3">
                                   <label for="password" class="form-label text-white fw-bold">Şifre</label>
                                   <input v-model="loginForm.password" id="password" type="password" class="form-control" autocomplete="current-password">
                                   <div class="text-danger mt-1" v-if="validationErrors?.password">
                                       <div v-for="message in validationErrors.password">{{ message }}</div>
                                   </div>
                               </div>

                               <!-- Remember Me -->
                               <div class="form-check mb-3">
                                   <input class="form-check-input" type="checkbox" id="flexCheckIndeterminate" v-model="loginForm.remember">
                                   <label class="form-check-label text-white fw-bold" for="flexCheckIndeterminate">Beni Hatırla</label>
                               </div>

                               <!-- Button -->
                               <div class="d-grid">
                                   <button class="btn btn-outline-light fw-bold" :class="{ 'opacity-50': processing }" :disabled="processing">
                                       Giriş Yap
                                   </button>
                               </div>

                               <!-- Optional Link -->
                               <!--
                               <div class="mt-3 text-center">
                                   <router-link :to="{ name: 'auth.forgot-password' }">Şifremi Unuttum</router-link>
                               </div>
                               -->
                           </form>
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </div>

</template>

<script setup>

import useAuth from '@/composables/auth'

const { loginForm, validationErrors, processing, submitLogin } = useAuth();

</script>
