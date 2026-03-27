<template>
    <div>
        <div class="page-header mb-4">
            <div>
                <h4 class="page-title">Kurban Düzenle</h4>
                <p class="page-subtitle">Kurban bilgilerini ve hissedar kayıtlarını yönetin</p>
            </div>
            <a href="/admin/posts" class="btn btn-outline-secondary btn-sm">← Listeye Dön</a>
        </div>

        <!-- Kurban Bilgileri Formu -->
        <form @submit.prevent="submitForm">
            <div class="row g-4 mb-4">
                <div class="col-md-8">
                    <div class="card admin-card">
                        <div class="card-header-section">
                            <h6 class="section-title">Kurban Bilgileri</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Küpe Numarası / İsim</label>
                                    <input v-model="post.title" type="text" class="form-control" placeholder="Küpe numarası veya isim">
                                    <div class="text-danger small mt-1">{{ errors.title }}</div>
                                    <div class="text-danger small mt-1">
                                        <div v-for="msg in validationErrors?.title" :key="msg">{{ msg }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Fiyat (₺)</label>
                                    <input v-model="post.amount" type="number" class="form-control">
                                    <div class="text-danger small mt-1">{{ errors.amount }}</div>
                                    <div class="text-danger small mt-1">
                                        <div v-for="msg in validationErrors?.amount" :key="msg">{{ msg }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Kesim Sırası</label>
                                    <input v-model="post.order" type="number" class="form-control">
                                    <div class="text-danger small mt-1">{{ errors.order }}</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Kesim Tarihi</label>
                                    <input v-model="post.order_date" type="datetime-local" class="form-control">
                                    <div class="text-danger small mt-1">{{ errors.order_date }}</div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Hissedar Sayısı</label>
                                    <input disabled v-model="post.number_of_shares" type="number" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Durum</label>
                                    <select v-model="post.status" class="form-select">
                                        <option value="pending">Satış Bekliyor</option>
                                        <option value="sold">Satışta</option>
                                        <option value="not_ready">Hazır Değil</option>
                                        <option value="was_cut_off">Kesildi</option>
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
                            <DropZone v-model="post.thumbnail"/>
                            <div class="text-danger small mt-1">
                                <div v-for="msg in validationErrors?.thumbnail" :key="msg">{{ msg }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Hissedar Bilgileri -->
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card admin-card">
                    <div class="card-header-section d-flex justify-content-between align-items-center">
                        <h6 class="section-title">Hissedar Listesi</h6>
                        <span class="badge-count">{{ items.length }} / 7 Hissedar</span>
                    </div>
                    <div class="card-body p-4">
                        <div v-if="!items.length" class="empty-state">
                            <p class="text-muted text-center mb-0">Henüz hissedar eklenmemiş.</p>
                        </div>

                        <div v-for="(item, index) in items" :key="index" class="hissedar-card mb-4">
                            <div class="hissedar-header">
                                <span class="hissedar-num">{{ index + 1 }}. Hissedar</span>
                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeItem(index)">Sil</button>
                            </div>

                            <div class="hissedar-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">İsim Soyisim</label>
                                        <input v-model="item.full_name" type="text" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">Telefon</label>
                                        <input v-model="item.phone" type="text" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">Taksit Sayısı</label>
                                        <input v-model="item.tax" type="number" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">Vekalet İsim Soyisim</label>
                                        <input v-model="item.vekalet" type="text" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">Vekalet Telefon</label>
                                        <input v-model="item.vekalet_phone" type="text" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="payment-summary">
                                            <div class="pay-item text-success">
                                                <span class="pay-label">Ödenen</span>
                                                <span class="pay-val">{{ formattedAmountt(totalPaid(item)) }}</span>
                                            </div>
                                            <div class="pay-item text-danger">
                                                <span class="pay-label">Kalan</span>
                                                <span class="pay-val">{{ formattedAmountt(post.amount - totalPaid(item)) }}</span>
                                            </div>
                                            <div class="pay-item text-secondary">
                                                <span class="pay-label">İşlem</span>
                                                <span class="pay-val">{{ item.paymentItems.length }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ödeme Ekle -->
                                <div class="payment-add-section mt-3">
                                    <h6 class="sub-section-title">Ödeme Hareketi Ekle</h6>
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <label class="form-label small">Ödenen Ücret</label>
                                            <input type="text" class="form-control form-control-sm" v-model="paymentNewItem.price">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small">Ödeme Tarihi</label>
                                            <input type="datetime-local" class="form-control form-control-sm" v-model="paymentNewItem.date">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small">Taksit No</label>
                                            <input type="number" class="form-control form-control-sm" v-model="paymentNewItem.tax">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small">Ödeme Şekli</label>
                                            <select class="form-select form-select-sm" v-model="paymentNewItem.payment_type">
                                                <option value="">Seçin...</option>
                                                <option value="Nakit Elden Alınan">Nakit Elden Alınan</option>
                                                <option value="Nakit Eft">Nakit EFT</option>
                                                <option value="Kredi Kartı">Kredi Kartı</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small">Not</label>
                                            <textarea class="form-control form-control-sm" rows="2" v-model="paymentNewItem.note"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-sm btn-outline-success" @click="paymentAddItem(index)">
                                                + Ödeme Ekle
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ödeme Geçmişi -->
                                <div v-if="item.paymentItems.length" class="payment-history mt-3">
                                    <h6 class="sub-section-title">Ödeme Geçmişi</h6>
                                    <div v-for="(pItem, i) in item.paymentItems" :key="i" class="payment-row">
                                        <div class="row g-2 align-items-end">
                                            <div class="col-md-3">
                                                <label class="form-label small">Ödenen Ücret</label>
                                                <input type="text" class="form-control form-control-sm" v-model="pItem.price">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small">Ödeme Tarihi</label>
                                                <input type="datetime-local" class="form-control form-control-sm" v-model="pItem.date">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small">Taksit No</label>
                                                <input type="number" class="form-control form-control-sm" v-model="pItem.tax">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small">Ödeme Şekli</label>
                                                <select class="form-select form-select-sm" v-model="pItem.payment_type">
                                                    <option value="Nakit Elden Alınan">Nakit Elden Alınan</option>
                                                    <option value="Nakit Eft">Nakit EFT</option>
                                                    <option value="Kredi Kartı">Kredi Kartı</option>
                                                </select>
                                            </div>
                                            <div class="col-md-1 text-end">
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="paymentRemoveItem(index, i)">Sil</button>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small">Not</label>
                                                <textarea class="form-control form-control-sm" rows="1" v-model="pItem.note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hissedar Ekle -->
            <div class="col-md-4">
                <div class="card admin-card" style="position: sticky; top: 80px;">
                    <div class="card-header-section">
                        <h6 class="section-title">Hissedar Ekle</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="price-badge mb-4">
                            <span class="price-label">Hisse Fiyatı</span>
                            <span class="price-value">{{ formattedAmount(post.amount) }}</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold small">İsim Soyisim *</label>
                                <input v-model="newItem.full_name" type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Telefon *</label>
                                <input v-model="newItem.phone" type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Vekalet İsim Soyisim *</label>
                                <input v-model="newItem.vekalet" type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Vekalet Telefon *</label>
                                <input v-model="newItem.vekalet_phone" type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Taksit Sayısı</label>
                                <input v-model="newItem.tax" type="number" class="form-control form-control-sm">
                            </div>
                            <div class="col-12">
                                <button type="button" @click="addItem" class="btn btn-primary-orange w-100">
                                    + Hissedar Ekle
                                </button>
                                <p class="text-muted small mt-2 mb-0">En fazla 7 hissedar eklenebilir.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { inject, onMounted, reactive, ref, watchEffect } from 'vue'
import { useRoute } from 'vue-router'
import useCategories from '@/composables/categories'
import usePosts from '@/composables/posts'
import { useForm, useField, defineRule } from 'vee-validate'
import { required, min } from '@/validation/rules'
import TextEditorComponent from '@/components/TextEditorComponent.vue'
import DropZone from '@/components/DropZone.vue'

defineRule('required', required)
defineRule('min', min)

const swal = inject('$swal')

const todayDate = () => {
    const now = new Date()
    return `${now.getFullYear()}-${String(now.getMonth()+1).padStart(2,'0')}-${String(now.getDate()).padStart(2,'0')}T${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}`
}

const items = ref([])
const newItem = ref({ full_name: '', phone: '', vekalet: '', vekalet_phone: '', tax: 0, paymentItems: [] })
const paymentNewItem = ref({ price: '', date: todayDate(), tax: 0, note: '', payment_type: '' })

const schema = {
    title: 'required|min:1',
    status: 'required',
    amount: 'required',
    content: 'required|min:5',
    categories: 'required'
}

const { validate, errors, resetForm } = useForm({ validationSchema: schema })
const { value: title } = useField('title', null, { initialValue: '' })
const { value: status } = useField('status', null, { initialValue: '' })
const { value: number_of_shares } = useField('number_of_shares', null, { initialValue: 1 })
const { value: amount } = useField('amount', null, { initialValue: '' })
const { value: order } = useField('order', null, { initialValue: '' })
const { value: order_date } = useField('order_date', null, { initialValue: '' })
const { value: share_holders_json } = useField('share_holders_json', null, { initialValue: items.value })
const { value: content } = useField('content', null, { initialValue: '' })
const { value: categories } = useField('categories', null, { initialValue: '', label: 'category' })
const { categoryList, getCategoryList } = useCategories()
const { post: postData, getPost, updatePost, validationErrors, isLoading } = usePosts()

const post = reactive({
    title, status, number_of_shares, amount, order, order_date, content, categories, share_holders_json, thumbnail: ''
})

const route = useRoute()

const totalPaid = (item) => item.paymentItems.reduce((sum, p) => sum + (parseFloat(p.price) || 0), 0)

const formattedAmountt = (val) => new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(val)
const formattedAmount = (val) => new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(val / 7)

function submitForm() {
    post.share_holders_json = items.value
    validate().then(form => {
        if (form.valid) updatePost(post).then(() => {
            swal({ icon: 'success', title: 'Kurban Bilgileri Kaydedildi' })
        })
    })
}

onMounted(() => {
    getPost(route.params.id)
    getCategoryList()
})

watchEffect(() => {
    post.id = postData.value.id
    post.title = postData.value.title
    post.status = postData.value.status
    post.order = postData.value.order
    post.order_date = postData.value.order_date
    post.amount = postData.value.amount
    post.number_of_shares = postData.value.number_of_shares
    post.content = postData.value.content
    post.thumbnail = postData.value.original_image
    post.categories = postData.value.categories
    post.share_holders_json = postData.value.share_holders_json
    items.value = postData.value.share_holders_json ?? []
})

const paymentAddItem = (index) => {
    if (paymentNewItem.value.price && paymentNewItem.value.date) {
        items.value[index].paymentItems.push({ ...paymentNewItem.value })
        swal({ icon: 'success', title: 'Ödeme Hareketi Eklendi' })
        paymentNewItem.value = { price: '', date: todayDate(), tax: 0, note: '', payment_type: '' }
        submitForm()
    } else {
        swal({ icon: 'warning', title: 'Lütfen zorunlu alanları doldurun!' })
    }
}

const paymentRemoveItem = (index, i) => {
    items.value[index].paymentItems.splice(i, 1)
    submitForm()
}

const addItem = () => {
    if (items.value.length >= 7) {
        swal({ icon: 'warning', title: 'En fazla 7 hissedar eklenebilir!' })
        return
    }
    if (newItem.value.full_name && newItem.value.phone && newItem.value.vekalet && newItem.value.vekalet_phone) {
        items.value.push({ ...newItem.value, paymentItems: [] })
        swal({ icon: 'success', title: `${newItem.value.full_name} hissedar olarak eklendi` })
        newItem.value = { full_name: '', phone: '', vekalet: '', vekalet_phone: '', tax: 0, paymentItems: [] }
        submitForm()
    } else {
        swal({ icon: 'warning', title: 'Lütfen zorunlu alanları doldurun!' })
    }
}

const removeItem = (index) => {
    if (confirm('Bu hissedarı silmek istediğinize emin misiniz?')) {
        items.value.splice(index, 1)
        submitForm()
    }
}
</script>

<style scoped>
.page-header { display: flex; align-items: center; justify-content: space-between; }
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
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.section-title { margin: 0; font-weight: 600; font-size: 0.875rem; color: #495057; }

.badge-count {
    font-size: 0.75rem;
    background: #e38d02;
    color: #fff;
    padding: 0.25rem 0.6rem;
    border-radius: 1rem;
    font-weight: 600;
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

.empty-state {
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
}

.hissedar-card {
    border: 1px solid #e9ecef;
    border-radius: 0.75rem;
    overflow: hidden;
}

.hissedar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 1rem;
    background: #f0f4ff;
    border-bottom: 1px solid #e9ecef;
}

.hissedar-num {
    font-weight: 600;
    font-size: 0.875rem;
    color: #3b5bdb;
}

.hissedar-body { padding: 1rem; }

.payment-summary {
    display: flex;
    flex-direction: column;
    gap: 4px;
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 0.6rem 0.75rem;
    height: 100%;
    justify-content: center;
}

.pay-item { display: flex; justify-content: space-between; font-size: 0.8rem; }
.pay-label { font-weight: 500; }
.pay-val { font-weight: 700; }

.sub-section-title {
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #6c757d;
    margin-bottom: 0.75rem;
}

.payment-add-section {
    background: #f8fff8;
    border: 1px dashed #b7e4c7;
    border-radius: 0.5rem;
    padding: 0.75rem;
}

.payment-history { }

.payment-row {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    border: 1px solid #e9ecef;
}

.price-badge {
    background: linear-gradient(135deg, #e38d02, #f5a623);
    border-radius: 0.75rem;
    padding: 1rem;
    text-align: center;
}

.price-label {
    display: block;
    color: rgba(255,255,255,0.85);
    font-size: 0.8rem;
    font-weight: 500;
    margin-bottom: 4px;
}

.price-value {
    display: block;
    color: #fff;
    font-size: 1.3rem;
    font-weight: 700;
}
</style>
