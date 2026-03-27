<template>
    <div class="login-wrapper" style="background-image: url('/images/21.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;">
        <div class="login-overlay"></div>
        <div class="container position-relative">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-md-5 col-lg-4">
                    <div class="login-card">
                        <div class="login-header text-center mb-4">
                            <img src="/images/logo.png" alt="Logo" class="login-logo mb-3" onerror="this.style.display='none'">
                            <h4 class="text-white fw-bold mb-1">Hoş Geldiniz</h4>
                            <p class="text-white-50 small">Hesabınıza giriş yapın</p>
                        </div>

                        <form @submit.prevent="submitLogin" autocomplete="off">
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label text-white fw-semibold small">E-Posta</label>
                                <input
                                    v-model="loginForm.email"
                                    id="email"
                                    type="email"
                                    class="form-control login-input"
                                    placeholder="ornek@mail.com"
                                    autofocus
                                    autocomplete="username"
                                >
                                <div class="text-warning small mt-1" v-if="validationErrors?.email">
                                    <div v-for="message in validationErrors.email" :key="message">{{ message }}</div>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label text-white fw-semibold small">Şifre</label>
                                <div class="input-group">
                                    <input
                                        v-model="loginForm.password"
                                        id="password"
                                        :type="showPassword ? 'text' : 'password'"
                                        class="form-control login-input"
                                        placeholder="••••••••"
                                        autocomplete="current-password"
                                    >
                                    <button type="button" class="input-group-text login-input-icon" @click="showPassword = !showPassword">
                                        {{ showPassword ? 'Gizle' : 'Göster' }}
                                    </button>
                                </div>
                                <div class="text-warning small mt-1" v-if="validationErrors?.password">
                                    <div v-for="message in validationErrors.password" :key="message">{{ message }}</div>
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="remember" v-model="loginForm.remember">
                                <label class="form-check-label text-white-50 small" for="remember">Beni Hatırla</label>
                            </div>

                            <!-- Button -->
                            <div class="d-grid">
                                <button
                                    class="btn login-btn fw-bold"
                                    :disabled="processing"
                                >
                                    <span v-if="processing" class="spinner-border spinner-border-sm me-2"></span>
                                    <span>{{ processing ? 'Giriş yapılıyor...' : 'Giriş Yap' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import useAuth from '@/composables/auth'

const { loginForm, validationErrors, processing, submitLogin } = useAuth()
const showPassword = ref(false)
</script>

<style scoped>
.login-wrapper {
    position: relative;
    min-height: 100vh;
}

.login-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
}

.login-card {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 1.25rem;
    padding: 2.5rem 2rem;
}

.login-logo {
    max-height: 64px;
    object-fit: contain;
}

.login-input-icon {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
    font-size: 0.75rem;
    cursor: pointer;
}

.login-input {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
}

.login-input::placeholder {
    color: rgba(255, 255, 255, 0.35);
}

.login-input:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.4);
    color: #fff;
    box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.1);
}

.login-btn {
    background: #e38d02;
    color: #fff;
    border: none;
    padding: 0.65rem;
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: background 0.2s;
}

.login-btn:hover:not(:disabled) {
    background: #c97c02;
    color: #fff;
}

.login-btn:disabled {
    opacity: 0.7;
}
</style>
