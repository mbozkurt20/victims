<template>
    <div>
        <!-- Üst Bar -->
        <div class="top-bar mb-3">
            <div class="top-bar-left">
                <a href="/admin/posts" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Listeye Dön
                </a>
                <h5 class="page-title">Kurban Düzenle</h5>
            </div>
            <div class="top-bar-right">
                <a :href="`/victims-posts-excel/${post.id}`" class="action-btn action-btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                    </svg>
                    Excel İndir
                </a>
                <button @click="submitForm" :disabled="isLoading" class="action-btn action-btn-primary">
                    <span v-if="isLoading" class="spin"></span>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
                    </svg>
                    {{ isLoading ? 'Kaydediliyor...' : 'Kaydet' }}
                </button>
            </div>
        </div>

        <!-- Kurban Bilgi Başlık Tablosu (Excel Görünümü) -->
        <div class="info-header-card mb-3">
            <div class="info-header-row">
                <div class="info-cell info-cell-accent">
                    <span class="info-label">Küpe No</span>
                    <input v-model="post.title" class="info-input" placeholder="Küpe / İsim" />
                    <div class="field-error">{{ errors.title }}</div>
                </div>
                <div class="info-cell">
                    <span class="info-label">KURBAN FİYATI</span>
                    <div class="info-input-wrap">
                        <input v-model="post.amount" type="number" class="info-input" placeholder="0" />
                        <span class="info-unit">₺</span>
                    </div>
                </div>
                <div class="info-cell info-cell-muted">
                    <span class="info-label">HİSSE FİYATI</span>
                    <span class="info-value-computed">{{ formattedAmount(post.amount) }}</span>
                </div>
                <div class="info-cell">
                    <span class="info-label">Kesim Günü</span>
                    <input v-model="post.order_date" type="datetime-local" class="info-input" />
                </div>
                <div class="info-cell">
                    <span class="info-label">Kesim Sırası</span>
                    <input v-model="post.order" type="number" class="info-input" placeholder="0" />
                </div>
                <div class="info-cell">
                    <span class="info-label">Durum</span>
                    <select v-model="post.status" class="info-select">
                        <option value="pending">Satış Bekliyor</option>
                        <option value="sold">Satışta</option>
                        <option value="not_ready">Hazır Değil</option>
                        <option value="was_cut_off">Kesildi</option>
                    </select>
                </div>
                <div class="info-cell">
                    <span class="info-label">Kategori</span>
                    <v-select multiple v-model="post.categories" :options="categoryList"
                              :reduce="cat => cat.id" label="name" placeholder="Seçin..." class="info-vselect" />
                </div>
                <div class="info-cell info-cell-sm">
                    <span class="info-label">Hissedar</span>
                    <span class="info-value-computed">{{ items.length }} / 7</span>
                </div>
            </div>
            <!-- Not Alanı -->
            <div class="info-note-row">
                <span class="info-label">Not</span>
                <TextEditorComponent v-model="post.content" />
            </div>
        </div>

        <!-- Hissedar Tablosu -->
        <div class="shareholders-card">
            <div class="shareholders-card-header">
                <div class="sh-header-left">
                    <h6 class="sh-title">Hissedar Listesi</h6>
                    <span class="sh-badge">{{ items.length }} / 7</span>
                </div>
                <button v-if="items.length < 7" type="button" @click="showAddForm = !showAddForm" class="add-shareholder-btn">
                    + Hissedar Ekle
                </button>
            </div>

            <!-- Hissedar Ekleme Formu -->
            <div v-if="showAddForm" class="add-form-row">
                <div class="add-form-grid">
                    <div class="add-form-field">
                        <label>İsim Soyisim *</label>
                        <input v-model="newItem.full_name" type="text" class="form-input" placeholder="Ad Soyad" />
                    </div>
                    <div class="add-form-field">
                        <label>Telefon *</label>
                        <input v-model="newItem.phone" type="text" class="form-input" placeholder="05xx xxx xx xx" />
                    </div>
                    <div class="add-form-field">
                        <label>Vekalet *</label>
                        <input v-model="newItem.vekalet" type="text" class="form-input" placeholder="Vekalet isim..." />
                    </div>
                    <div class="add-form-field">
                        <label>Vekalet Tel *</label>
                        <input v-model="newItem.vekalet_phone" type="text" class="form-input" placeholder="05xx xxx xx xx" />
                    </div>
                    <div class="add-form-field">
                        <label>Taksit Sayısı</label>
                        <input v-model="newItem.tax" type="number" class="form-input" placeholder="0" />
                    </div>
                    <div class="add-form-field add-form-actions">
                        <button type="button" @click="addItem" class="action-btn action-btn-primary">Ekle</button>
                        <button type="button" @click="showAddForm = false" class="action-btn action-btn-ghost">İptal</button>
                    </div>
                </div>
            </div>

            <!-- Tablo -->
            <div class="table-wrap">
                <table class="sh-table">
                    <thead>
                        <tr class="sh-thead-accent">
                            <th class="th-no">#</th>
                            <th>İsim Soyisim</th>
                            <th>İrtibat No</th>
                            <th>Vekalet</th>
                            <th>Vekalet Tel</th>
                            <th>Taksit</th>
                            <th class="th-payment">1. Ödeme</th>
                            <th class="th-payment">2. Ödeme</th>
                            <th class="th-payment">3. Ödeme</th>
                            <th class="th-total">TOPLAM</th>
                            <th class="th-remain">KALAN</th>
                            <th class="th-actions">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dolu satırlar -->
                        <template v-for="(item, index) in items" :key="index">
                            <tr class="sh-row" :class="{ 'sh-row-expanded': expandedRow === index }">
                                <td class="td-no">{{ index + 1 }}</td>
                                <td>
                                    <input v-model="item.full_name" class="td-input" placeholder="İsim Soyisim" />
                                </td>
                                <td>
                                    <input v-model="item.phone" class="td-input" placeholder="Telefon" />
                                </td>
                                <td>
                                    <input v-model="item.vekalet" class="td-input" placeholder="Vekalet İsim" />
                                </td>
                                <td>
                                    <input v-model="item.vekalet_phone" class="td-input" placeholder="Vekalet Tel" />
                                </td>
                                <td>
                                    <input v-model="item.tax" type="number" class="td-input td-input-sm" placeholder="0" />
                                </td>
                                <!-- 1. Ödeme -->
                                <td class="td-payment">
                                    <div v-if="item.paymentItems[0]" class="payment-cell-filled">
                                        <span class="pc-amount">{{ formatMini(item.paymentItems[0].price) }}</span>
                                        <span class="pc-type">{{ item.paymentItems[0].payment_type || '-' }}</span>
                                    </div>
                                    <span v-else class="empty-payment">0,00 TL</span>
                                </td>
                                <!-- 2. Ödeme -->
                                <td class="td-payment">
                                    <div v-if="item.paymentItems[1]" class="payment-cell-filled">
                                        <span class="pc-amount">{{ formatMini(item.paymentItems[1].price) }}</span>
                                        <span class="pc-type">{{ item.paymentItems[1].payment_type || '-' }}</span>
                                    </div>
                                    <span v-else class="empty-payment">0,00 TL</span>
                                </td>
                                <!-- 3. Ödeme -->
                                <td class="td-payment">
                                    <div v-if="item.paymentItems[2]" class="payment-cell-filled">
                                        <span class="pc-amount">{{ formatMini(item.paymentItems[2].price) }}</span>
                                        <span class="pc-type">{{ item.paymentItems[2].payment_type || '-' }}</span>
                                    </div>
                                    <span v-else class="empty-payment">0,00 TL</span>
                                </td>
                                <td class="td-total">{{ formattedAmountt(totalPaid(item)) }}</td>
                                <td class="td-remain" :class="remainClass(item)">{{ formattedAmountt(sharePrice - totalPaid(item)) }}</td>
                                <td class="td-actions-cell">
                                    <button type="button" @click="toggleRow(index)" class="row-btn row-btn-blue" :title="expandedRow === index ? 'Kapat' : 'Ödemeler'">
                                        {{ expandedRow === index ? '▲' : '▼' }}
                                    </button>
                                    <button type="button" @click="removeItem(index)" class="row-btn row-btn-red" title="Sil">✕</button>
                                </td>
                            </tr>

                            <!-- Genişletilmiş Ödeme Satırı -->
                            <tr v-if="expandedRow === index" class="sh-expanded-row">
                                <td colspan="12">
                                    <div class="expanded-content">
                                        <div class="expanded-close-bar">
                                            <span class="expanded-close-label">{{ index + 1 }}. Hissedar Ödemeleri</span>
                                            <button type="button" @click="expandedRow = null" class="expanded-close-btn" title="Kapat">✕</button>
                                        </div>
                                        <!-- Mevcut Ödemeler -->
                                        <div v-if="item.paymentItems.length" class="payments-grid">
                                            <div v-for="(pItem, i) in item.paymentItems" :key="i" class="payment-edit-card">
                                                <div class="payment-edit-header">
                                                    <span class="payment-edit-num">{{ i + 1 }}. Ödeme</span>
                                                    <button type="button" @click="paymentRemoveItem(index, i)" class="pec-delete">Sil</button>
                                                </div>
                                                <div class="payment-edit-grid">
                                                    <div>
                                                        <label>Tutar</label>
                                                        <input type="text" class="form-input" v-model="pItem.price" placeholder="0" />
                                                    </div>
                                                    <div>
                                                        <label>Tarih</label>
                                                        <input type="datetime-local" class="form-input" v-model="pItem.date" />
                                                    </div>
                                                    <div>
                                                        <label>Taksit No</label>
                                                        <input type="number" class="form-input" v-model="pItem.tax" />
                                                    </div>
                                                    <div>
                                                        <label>Ödeme Şekli</label>
                                                        <select class="form-input" v-model="pItem.payment_type">
                                                            <option value="">Seçin...</option>
                                                            <option value="Nakit Elden Alınan">Nakit Elden</option>
                                                            <option value="Nakit Eft">Nakit EFT</option>
                                                            <option value="Kredi Kartı">Kredi Kartı</option>
                                                        </select>
                                                    </div>
                                                    <div class="payment-note-field">
                                                        <label>Not</label>
                                                        <input type="text" class="form-input" v-model="pItem.note" placeholder="Not..." />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Yeni Ödeme Ekle -->
                                        <div class="new-payment-form">
                                            <div class="npf-header">+ Yeni Ödeme Ekle</div>
                                            <div class="payment-edit-grid">
                                                <div>
                                                    <label>Tutar *</label>
                                                    <input type="text" class="form-input" v-model="paymentNewItem.price" placeholder="0" />
                                                </div>
                                                <div>
                                                    <label>Tarih *</label>
                                                    <input type="datetime-local" class="form-input" v-model="paymentNewItem.date" />
                                                </div>
                                                <div>
                                                    <label>Taksit No</label>
                                                    <input type="number" class="form-input" v-model="paymentNewItem.tax" />
                                                </div>
                                                <div>
                                                    <label>Ödeme Şekli</label>
                                                    <select class="form-input" v-model="paymentNewItem.payment_type">
                                                        <option value="">Seçin...</option>
                                                        <option value="Nakit Elden Alınan">Nakit Elden</option>
                                                        <option value="Nakit Eft">Nakit EFT</option>
                                                        <option value="Kredi Kartı">Kredi Kartı</option>
                                                    </select>
                                                </div>
                                                <div class="payment-note-field">
                                                    <label>Not</label>
                                                    <input type="text" class="form-input" v-model="paymentNewItem.note" placeholder="Not..." />
                                                </div>
                                            </div>
                                            <div class="npf-actions">
                                                <button type="button" @click="paymentAddItem(index)" class="action-btn action-btn-primary">Ödeme Kaydet</button>
                                                <button type="button" @click="submitForm" class="action-btn action-btn-ghost">Değişiklikleri Kaydet</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        <!-- Boş Satırlar (7'ye tamamla) -->
                        <tr v-for="i in (7 - items.length)" :key="'empty-' + i" class="sh-row sh-row-empty">
                            <td class="td-no td-no-empty">{{ items.length + i }}</td>
                            <td colspan="10" class="td-empty-cell">—</td>
                            <td class="td-actions-cell"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="sh-tfoot">
                            <td colspan="9" class="tf-label">GENEL TOPLAM</td>
                            <td class="tf-total">{{ formattedAmountt(grandTotalPaid) }}</td>
                            <td class="tf-remain">{{ formattedAmountt(grandTotalRemaining) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Fotoğraf (alt kısım) -->
        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <div class="bottom-card">
                    <div class="bottom-card-header">Fotoğraf</div>
                    <div class="p-3">
                        <PhotoUploadButton v-model="post.thumbnail" />
                        <div class="field-error" v-for="msg in validationErrors?.thumbnail" :key="msg">{{ msg }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { inject, onMounted, reactive, ref, watchEffect, computed } from 'vue'
import { useRoute } from 'vue-router'
import useCategories from '@/composables/categories'
import usePosts from '@/composables/posts'
import { useForm, useField, defineRule } from 'vee-validate'
import { required, min } from '@/validation/rules'
import TextEditorComponent from '@/components/TextEditorComponent.vue'
import PhotoUploadButton from '@/components/PhotoUploadButton.vue'

defineRule('required', required)
defineRule('min', min)

const swal = inject('$swal')

const todayDate = () => {
    const now = new Date()
    return `${now.getFullYear()}-${String(now.getMonth()+1).padStart(2,'0')}-${String(now.getDate()).padStart(2,'0')}T${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}`
}

const items = ref([])
const showAddForm = ref(false)
const expandedRow = ref(null)
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

const sharePrice = computed(() => post.amount ? post.amount / 7 : 0)
const totalPaid = (item) => item.paymentItems.reduce((sum, p) => sum + (parseFloat(p.price) || 0), 0)
const grandTotalPaid = computed(() => items.value.reduce((sum, item) => sum + totalPaid(item), 0))
const grandTotalRemaining = computed(() => items.value.reduce((sum, item) => sum + (sharePrice.value - totalPaid(item)), 0))

const remainClass = (item) => {
    const remain = sharePrice.value - totalPaid(item)
    if (remain <= 0) return 'td-remain-done'
    return 'td-remain-pending'
}

const formattedAmountt = (val) => new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(val || 0)
const formattedAmount = (val) => new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format((val || 0) / 7)
const formatMini = (val) => {
    const n = parseFloat(val) || 0
    return new Intl.NumberFormat('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(n) + ' ₺'
}

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

const toggleRow = (index) => {
    expandedRow.value = expandedRow.value === index ? null : index
}

const paymentAddItem = (index) => {
    if (paymentNewItem.value.price && paymentNewItem.value.date) {
        items.value[index].paymentItems.push({ ...paymentNewItem.value })
        paymentNewItem.value = { price: '', date: todayDate(), tax: 0, note: '', payment_type: '' }
        submitForm()
        swal({ icon: 'success', title: 'Ödeme Eklendi' })
    } else {
        swal({ icon: 'warning', title: 'Tutar ve tarih zorunludur!' })
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
        newItem.value = { full_name: '', phone: '', vekalet: '', vekalet_phone: '', tax: 0, paymentItems: [] }
        showAddForm.value = false
        submitForm()
        swal({ icon: 'success', title: 'Hissedar eklendi' })
    } else {
        swal({ icon: 'warning', title: 'Zorunlu alanları doldurun!' })
    }
}

const removeItem = (index) => {
    if (confirm('Bu hissedarı silmek istediğinize emin misiniz?')) {
        items.value.splice(index, 1)
        if (expandedRow.value === index) expandedRow.value = null
        submitForm()
    }
}
</script>

<style scoped>
/* Top Bar */
.top-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
}
.top-bar-left { display: flex; align-items: center; gap: 1rem; }
.top-bar-right { display: flex; align-items: center; gap: 0.5rem; }
.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    color: #6c757d;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    padding: 0.35rem 0.75rem;
    border-radius: 0.4rem;
    border: 1px solid #dee2e6;
    background: #fff;
    transition: all 0.15s;
}
.back-btn:hover { color: #1a1f2e; border-color: #adb5bd; }
.page-title { margin: 0; font-size: 1.1rem; font-weight: 700; color: #1a1f2e; }

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1.1rem;
    border-radius: 0.5rem;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: opacity 0.15s, transform 0.1s;
    white-space: nowrap;
}
.action-btn:hover { opacity: 0.85; transform: translateY(-1px); }
.action-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
.action-btn-primary { background: #1a1f2e; color: #fff; }
.action-btn-success  { background: #2f9e44; color: #fff; }
.action-btn-ghost { background: #f1f3f5; color: #495057; border: 1px solid #dee2e6; }

.spin {
    width: 14px; height: 14px;
    border: 2px solid rgba(255,255,255,0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
    display: inline-block;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Info Header Card (Excel başlık) */
.info-header-card {
    background: #fff;
    border-radius: 0.875rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    overflow: hidden;
}
.info-header-row {
    display: flex;
    flex-wrap: wrap;
    border-bottom: 1px solid #e9ecef;
}
.info-cell {
    flex: 1;
    min-width: 140px;
    padding: 0.85rem 1rem;
    border-right: 1px solid #e9ecef;
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
}
.info-cell:last-child { border-right: none; }
.info-cell-accent { background: #fffbf0; }
.info-cell-muted { background: #f8f9fc; }
.info-cell-sm { flex: 0 0 100px; min-width: 80px; }
.info-label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #868e96;
}
.info-input {
    border: none;
    outline: none;
    font-size: 0.9rem;
    font-weight: 600;
    color: #1a1f2e;
    background: transparent;
    width: 100%;
    padding: 0;
}
.info-input:focus { color: #1a1f2e; }
.info-input-wrap { display: flex; align-items: center; gap: 4px; }
.info-unit { font-size: 0.85rem; color: #6c757d; font-weight: 500; }
.info-value-computed {
    font-size: 0.95rem;
    font-weight: 700;
    color: #2f9e44;
}
.info-select {
    border: none;
    outline: none;
    font-size: 0.875rem;
    font-weight: 600;
    color: #1a1f2e;
    background: transparent;
    padding: 0;
    cursor: pointer;
    width: 100%;
}
.info-vselect { font-size: 0.8rem; }
.info-note-row {
    padding: 0.85rem 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    max-height: 220px;
    overflow: hidden;
}
.field-error { font-size: 0.75rem; color: #e03131; margin-top: 2px; }

/* Shareholders Card */
.shareholders-card {
    background: #fff;
    border-radius: 0.875rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    overflow: hidden;
}
.shareholders-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.85rem 1.25rem;
    background: #f8f9fc;
    border-bottom: 1px solid #e9ecef;
}
.sh-header-left { display: flex; align-items: center; gap: 0.75rem; }
.sh-title { margin: 0; font-weight: 800; font-size: 1rem; color: #1a1f2e; letter-spacing: -0.2px; }
.sh-badge {
    background: #e38d02;
    color: #fff;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.2rem 0.6rem;
    border-radius: 1rem;
}
.add-shareholder-btn {
    display: inline-flex;
    align-items: center;
    background: #1a1f2e;
    color: #fff;
    border: none;
    border-radius: 0.5rem;
    padding: 0.45rem 1rem;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.15s;
}
.add-shareholder-btn:hover { opacity: 0.85; }

/* Add Form Row */
.add-form-row {
    padding: 1rem 1.25rem;
    background: #f0f4ff;
    border-bottom: 1px solid #dde4f5;
}
.add-form-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: flex-end;
}
.add-form-field {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    flex: 1;
    min-width: 140px;
}
.add-form-field label { font-size: 0.75rem; font-weight: 600; color: #495057; }
.add-form-actions { flex-direction: row; gap: 0.5rem; flex: 0 0 auto; min-width: auto; }

.form-input {
    border: 1px solid #dee2e6;
    border-radius: 0.4rem;
    padding: 0.4rem 0.65rem;
    font-size: 0.85rem;
    outline: none;
    background: #fff;
    width: 100%;
    transition: border-color 0.15s;
}
.form-input:focus { border-color: #1a1f2e; }

/* Table */
.table-wrap { overflow-x: auto; }
.sh-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.82rem;
    min-width: 1000px;
}
.sh-thead-accent {
    background: linear-gradient(to right, #7a4500, #a05c00);
    color: #fff;
}
.sh-thead-accent th {
    padding: 0.75rem 0.75rem;
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    border: none;
    white-space: nowrap;
}
.th-no { width: 36px; text-align: center; }
.th-payment { min-width: 110px; }
.th-total { min-width: 100px; background: rgba(0,0,0,0.1); }
.th-remain { min-width: 100px; }
.th-actions { width: 80px; text-align: center; }

.sh-row td { padding: 0.55rem 0.75rem; border-bottom: 1px solid #f1f3f5; vertical-align: middle; }
.sh-row:hover td { background: #fffbf0; }
.sh-row-expanded td { background: #f0f4ff !important; }

.sh-row-empty td { background: #fafafa; color: #dee2e6; }
.td-no { text-align: center; font-weight: 700; font-size: 0.8rem; color: #adb5bd; }
.td-no-empty { color: #dee2e6; }
.td-empty-cell { color: #dee2e6; font-size: 0.8rem; text-align: center; }

.td-input {
    border: 1px solid transparent;
    border-radius: 0.35rem;
    padding: 0.3rem 0.5rem;
    font-size: 0.82rem;
    width: 100%;
    background: transparent;
    outline: none;
    transition: border-color 0.15s, background 0.15s;
    min-width: 90px;
}
.td-input:hover, .td-input:focus { border-color: #dee2e6; background: #fff; }
.td-input-sm { min-width: 50px; max-width: 60px; }

.td-payment { }
.payment-cell-filled {
    display: flex;
    flex-direction: column;
    gap: 1px;
}
.pc-amount { font-weight: 700; color: #2f9e44; font-size: 0.8rem; }
.pc-type { font-size: 0.7rem; color: #868e96; }
.empty-payment { color: #dee2e6; font-size: 0.8rem; }

.td-total { font-weight: 700; color: #2f9e44; text-align: right; }
.td-remain { font-weight: 700; text-align: right; }
.td-remain-done { color: #2f9e44; }
.td-remain-pending { color: #e03131; }

.td-actions-cell { text-align: center; white-space: nowrap; }
.row-btn {
    border: none;
    border-radius: 0.4rem;
    padding: 0.35rem 0.7rem;
    font-size: 0.82rem;
    font-weight: 700;
    cursor: pointer;
    transition: opacity 0.15s;
    margin: 0 2px;
}
.row-btn:hover { opacity: 0.75; }
.row-btn-blue { background: #dde4f5; color: #3b5bdb; }
.row-btn-red { background: #ffe0e0; color: #e03131; }

/* Footer */
.sh-tfoot td {
    padding: 0.75rem 0.75rem;
    background: #f1f3f5;
    font-weight: 700;
    font-size: 0.85rem;
    border-top: 2px solid #dee2e6;
}
.tf-label { text-align: right; color: #495057; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.3px; }
.tf-total { text-align: right; color: #2f9e44; }
.tf-remain { text-align: right; color: #e03131; }

/* Expanded Row */
.sh-expanded-row td { padding: 0; background: #f0f4ff; }
.expanded-content { padding: 1.25rem; }
.expanded-close-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #dde4f5;
}
.expanded-close-label { font-size: 0.85rem; font-weight: 700; color: #3b5bdb; }
.expanded-close-btn {
    border: none;
    background: #e9ecef;
    border-radius: 0.4rem;
    width: 30px;
    height: 30px;
    cursor: pointer;
    font-size: 0.85rem;
    font-weight: 700;
    color: #495057;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s, color 0.15s;
}
.expanded-close-btn:hover { background: #ffc9c9; color: #e03131; }

.payments-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.25rem;
}
.payment-edit-card {
    background: #fff;
    border: 1px solid #dde4f5;
    border-radius: 0.6rem;
    overflow: hidden;
    min-width: 280px;
    flex: 1;
}
.payment-edit-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 0.75rem;
    background: #e8edff;
    border-bottom: 1px solid #dde4f5;
}
.payment-edit-num { font-size: 0.8rem; font-weight: 700; color: #3b5bdb; }
.pec-delete {
    border: none;
    background: #ffe0e0;
    color: #e03131;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.15rem 0.5rem;
    border-radius: 0.3rem;
    cursor: pointer;
}

.payment-edit-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    padding: 0.75rem;
}
.payment-edit-grid > div {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
    flex: 1;
    min-width: 110px;
}
.payment-edit-grid label { font-size: 0.72rem; font-weight: 600; color: #6c757d; }
.payment-note-field { flex: 2 !important; min-width: 180px !important; }

.new-payment-form {
    background: #f0fff4;
    border: 1px dashed #b2f2bb;
    border-radius: 0.6rem;
    overflow: hidden;
}
.npf-header {
    padding: 0.5rem 0.75rem;
    font-size: 0.8rem;
    font-weight: 700;
    color: #2f9e44;
    border-bottom: 1px dashed #b2f2bb;
}
.new-payment-form .payment-edit-grid { padding: 0.75rem; }
.npf-actions {
    padding: 0.75rem;
    padding-top: 0;
    display: flex;
    gap: 0.5rem;
}

/* Bottom Cards */
.bottom-card {
    background: #fff;
    border-radius: 0.875rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    overflow: hidden;
}
.bottom-card-header {
    padding: 0.75rem 1rem;
    background: #f8f9fc;
    border-bottom: 1px solid #e9ecef;
    font-size: 0.875rem;
    font-weight: 700;
    color: #495057;
}
</style>
