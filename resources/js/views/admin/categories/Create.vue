<template>
    <div>
        <div class="page-header mb-4">
            <div>
                <h4 class="page-title">Yeni Kategori Ekle</h4>
                <p class="page-subtitle">Yeni bir kategori oluşturun</p>
            </div>
            <router-link :to="{ name: 'categories.index' }" class="btn btn-outline-secondary btn-sm">
                ← Geri Dön
            </router-link>
        </div>

        <div class="row">
            <div class="col-md-7 col-lg-6">
                <div class="card admin-card">
                    <div class="card-body p-4">
                        <form @submit.prevent="submitForm">
                            <div class="mb-4">
                                <label for="category-name" class="form-label fw-semibold">Kategori Adı</label>
                                <input
                                    v-model="category.name"
                                    id="category-name"
                                    type="text"
                                    class="form-control"
                                    placeholder="Kategori adını girin..."
                                >
                                <div class="text-danger small mt-1" v-if="errors.name">{{ errors.name }}</div>
                                <div class="text-danger small mt-1">
                                    <div v-for="message in validationErrors?.name" :key="message">{{ message }}</div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button :disabled="isLoading" class="btn btn-primary-orange">
                                    <span v-if="isLoading" class="spinner-border spinner-border-sm me-2"></span>
                                    {{ isLoading ? 'Kaydediliyor...' : 'Kaydet' }}
                                </button>
                                <router-link :to="{ name: 'categories.index' }" class="btn btn-light">
                                    İptal
                                </router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import useCategories from '../../../composables/categories'
import { useForm, useField, defineRule } from 'vee-validate'
import { required, min } from '@/validation/rules'

defineRule('required', required)
defineRule('min', min)

const schema = { name: 'required|min:3' }
const { validate, errors } = useForm({ validationSchema: schema })
const { value: name } = useField('name', null, { initialValue: '' })
const { storeCategory, validationErrors, isLoading } = useCategories()

const category = reactive({ name })

function submitForm() {
    validate().then(form => { if (form.valid) storeCategory(category) })
}
</script>

<style scoped>
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.page-title {
    font-weight: 700;
    margin: 0;
    color: #1a1f2e;
}

.page-subtitle {
    color: #6c757d;
    font-size: 0.875rem;
    margin: 0;
}

.admin-card {
    border: none;
    border-radius: 0.75rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
}

.btn-primary-orange {
    background: #e38d02;
    color: #fff;
    border: none;
    padding: 0.5rem 1.25rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.875rem;
    transition: background 0.15s;
}

.btn-primary-orange:hover:not(:disabled) {
    background: #c97c02;
    color: #fff;
}

.btn-primary-orange:disabled {
    opacity: 0.65;
}
</style>
