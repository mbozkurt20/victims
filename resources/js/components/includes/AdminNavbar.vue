<template>
    <nav class="admin-navbar">
        <div class="navbar-left">
            <button class="toggler-btn d-md-none" @click="$emit('toggle-sidebar')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>
        </div>

        <div class="navbar-right">
            <div class="dropdown">
                <button class="user-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">{{ userInitial }}</div>
                    <span class="user-name d-none d-md-inline">{{ user.name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li class="dropdown-header text-muted small px-3 py-2">{{ user.email }}</li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <router-link :to="{ name: 'profile.index' }" class="dropdown-item">
                            Profil
                        </router-link>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="javascript:void(0)"
                           :class="{ 'opacity-50': processing }" @click="logout">
                            Çıkış Yap
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { computed } from 'vue'
import useAuth from '@/composables/auth'
import { useAuthStore } from '@/store/auth'

const auth = useAuthStore()
const user = computed(() => auth.user)
const userInitial = computed(() => user.value?.name?.charAt(0)?.toUpperCase() || '?')
const { processing, logout } = useAuth()
</script>

<style scoped>
.admin-navbar {
    height: 56px;
    background: #e38d02;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 1.25rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
    position: sticky;
    top: 0;
    z-index: 200;
}

.toggler-btn {
    background: none;
    border: none;
    color: #fff;
    padding: 0.25rem;
    cursor: pointer;
}

.user-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.15);
    border: none;
    border-radius: 2rem;
    padding: 0.35rem 0.85rem 0.35rem 0.4rem;
    color: #fff;
    cursor: pointer;
    transition: background 0.15s;
}

.user-btn:hover {
    background: rgba(255,255,255,0.25);
}

.user-btn::after {
    filter: brightness(0) invert(1);
}

.user-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
}

.user-name {
    font-weight: 600;
    font-size: 0.875rem;
}

.dropdown-menu {
    border-radius: 0.75rem;
    min-width: 200px;
    margin-top: 0.5rem;
}

.dropdown-item {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
    border-radius: 0.4rem;
    margin: 0 0.25rem;
}

.dropdown-item:hover {
    background: #f5f5f5;
}
</style>
