<template>
    <div>
        <div class="page-header mb-4">
            <div>
                <h4 class="page-title">Yeni Kurban Ekle</h4>
                <p class="page-subtitle">Yeni bir kurban kaydı oluşturun</p>
            </div>
            <a href="/admin/posts" class="btn btn-outline-secondary btn-sm">← Listeye Dön</a>
        </div>

        <form @submit.prevent="submitForm">
            <div class="row g-4">
                <!-- Sol: Kurban Bilgileri -->
                <div class="col-md-8">
                    <div class="card admin-card">
                        <div class="card-header-section">
                            <h6 class="section-title">Kurban Bilgileri</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Küpe Numarası / İsim</label>
                                    <input v-model="post.title" type="text" class="form-control" placeholder="Küpe numarası veya isim girin">
                                    <div class="text-danger small mt-1">{{ errors.title }}</div>
                                    <div class="text-danger small mt-1">
                                        <div v-for="msg in validationErrors?.title" :key="msg">{{ msg }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Fiyat (₺)</label>
                                    <input v-model="post.amount" type="number" class="form-control" placeholder="0">
                                    <div class="text-danger small mt-1">{{ errors.amount }}</div>
                                    <div class="text-danger small mt-1">
                                        <div v-for="msg in validationErrors?.amount" :key="msg">{{ msg }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Kesim Sırası</label>
                                    <input v-model="post.order" type="number" class="form-control" placeholder="0">
                                    <div class="text-danger small mt-1">{{ errors.order }}</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Kesim Tarihi</label>
                                    <input v-model="post.order_date" type="datetime-local" class="form-control">
                                    <div class="text-danger small mt-1">{{ errors.order_date }}</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Durum</label>
                                    <select v-model="post.status" class="form-select">
                                        <option value="">Seçin...</option>
                                        <option value="pending">Satış Bekliyor</option>
                                        <option value="sold">Satışta</option>
                                        <option value="not_ready">Hazır Değil</option>
                                    </select>
                                    <div class="text-danger small mt-1">{{ errors.status }}</div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Not</label>
                                    <TextEditorComponent v-model="post.content"/>
                                    <div class="text-danger small mt-1">{{ errors.content }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sağ: İşlemler -->
                <div class="col-md-4">
                    <div class="card admin-card mb-3">
                        <div class="card-header-section">
                            <h6 class="section-title">İşlemler</h6>
                        </div>
                        <div class="card-body p-4">
                            <button :disabled="isLoading" class="btn btn-primary-orange w-100 mb-2">
                                <span v-if="isLoading" class="spinner-border spinner-border-sm me-2"></span>
                                {{ isLoading ? 'Kaydediliyor...' : 'Kaydet' }}
                            </button>
                            <a href="/admin/posts" class="btn btn-light w-100">Listeye Dön</a>
                        </div>
                    </div>

                    <div class="card admin-card mb-3">
                        <div class="card-header-section">
                            <h6 class="section-title">Küpe (Kategori)</h6>
                        </div>
                        <div class="card-body p-4">
                            <v-select multiple v-model="post.categories" :options="categoryList"
                                      :reduce="cat => cat.id" label="name" placeholder="Küpe seçin..."/>
                            <div class="text-danger small mt-1">{{ errors.categories }}</div>
                            <div class="text-danger small mt-1">
                                <div v-for="msg in validationErrors?.categories" :key="msg">{{ msg }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card admin-card">
                        <div class="card-header-section">
                            <h6 class="section-title">Fotoğraf</h6>
                        </div>
                        <div class="card-body p-4">
                            <PhotoUploadButton v-model="post.thumbnail"/>
                            <div class="text-danger small mt-1">
                                <div v-for="msg in validationErrors?.thumbnail" :key="msg">{{ msg }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue'
import TextEditorComponent from '@/components/TextEditorComponent.vue'
import PhotoUploadButton from '@/components/PhotoUploadButton.vue'
import useCategories from '@/composables/categories'
import usePosts from '@/composables/posts'
import { useForm, useField, defineRule } from 'vee-validate'
import { required, min } from '@/validation/rules'

defineRule('required', required)
defineRule('min', min)

const schema = {
    title: 'required|min:1',
    order: 'required',
    order_date: 'required',
    status: 'required',
    amount: 'required',
    content: 'required|min:5',
    categories: 'required'
}

const { validate, errors } = useForm({ validationSchema: schema })
const { value: title } = useField('title', null, { initialValue: '' })
const { value: status } = useField('status', null, { initialValue: '' })
const { value: number_of_shares } = useField('number_of_shares', null, { initialValue: 0 })
const { value: amount } = useField('amount', null, { initialValue: '' })
const { value: order } = useField('order', null, { initialValue: '' })
const { value: order_date } = useField('order_date', null, { initialValue: '' })
const { value: content } = useField('content', null, { initialValue: '' })
const { value: categories } = useField('categories', null, { initialValue: '', label: 'category' })
const { categoryList, getCategoryList } = useCategories()
const { storePost, validationErrors, isLoading } = usePosts()

const post = reactive({
    title, status, number_of_shares, amount, order, order_date, content, categories, thumbnail: ''
})

function submitForm() {
    validate().then(form => { if (form.valid) storePost(post) })
}

onMounted(() => getCategoryList())
</script>

<style scoped>
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.page-title { font-weight: 700; margin: 0; color: #1a1f2e; }
.page-subtitle { color: #6c757d; font-size: 0.875rem; margin: 0; }

.admin-card {
    border: none;
    border-radius: 0.75rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    overflow: hidden;
}

.card-header-section {
    padding: 0.85rem 1.25rem;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.section-title {
    margin: 0;
    font-weight: 600;
    font-size: 0.875rem;
    color: #495057;
}

.btn-primary-orange {
    background: #e38d02;
    color: #fff;
    border: none;
    padding: 0.55rem 1.25rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.875rem;
    transition: background 0.15s;
}
.btn-primary-orange:hover:not(:disabled) { background: #c97c02; color: #fff; }
.btn-primary-orange:disabled { opacity: 0.65; }
</style>
