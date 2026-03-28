<template>
    <div class="pep-wrap">
        <!-- Üst Bar -->
        <div class="pep-topbar">
            <div class="pep-topbar-left">
                <span class="pep-id-badge">#{{ post.id }}</span>
                <span class="pep-label">Kurban Düzenle</span>
            </div>
            <div class="pep-topbar-right">
                <a :href="`/victims-posts-excel/${post.id}`" class="pep-btn pep-btn-green" title="Excel İndir">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                    </svg>
                    Excel
                </a>
                <button @click="saveForm" :disabled="isLoading" class="pep-btn pep-btn-dark">
                    <span v-if="isLoading" class="pep-spin"></span>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h3.75a.75.75 0 0 1 0 1.5H8.5v5a.5.5 0 0 1-1 0V8h-3.5a.5.5 0 0 1 0-1H7.5V2A2 2 0 0 1 9.5 0H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h1.5a.5.5 0 0 1 0 1H2z"/>
                    </svg>
                    {{ isLoading ? 'Kaydediliyor...' : 'Kaydet' }}
                </button>
                <button type="button" @click="$emit('close')" class="pep-btn pep-btn-close">✕ Kapat</button>
            </div>
        </div>

        <!-- Bilgi Satırı -->
        <div class="pep-info-row">
            <div class="pep-info-cell">
                <label>Küpe No</label>
                <input v-model="post.title" class="pep-input" placeholder="Küpe / İsim" />
            </div>
            <div class="pep-info-cell">
                <label>Fiyat (₺)</label>
                <input v-model="post.amount" type="number" class="pep-input" />
            </div>
            <div class="pep-info-cell pep-computed">
                <label>Hisse Fiyatı</label>
                <span>{{ fmtCurrency(post.amount / 7) }}</span>
            </div>
            <div class="pep-info-cell">
                <label>Kesim Günü</label>
                <input v-model="post.order_date" type="datetime-local" class="pep-input" />
            </div>
            <div class="pep-info-cell">
                <label>Kesim Sırası</label>
                <input v-model="post.order" type="number" class="pep-input" />
            </div>
            <div class="pep-info-cell">
                <label>Durum</label>
                <select v-model="post.status" class="pep-input">
                    <option value="pending">Satış Bekliyor</option>
                    <option value="sold">Satışta</option>
                    <option value="not_ready">Hazır Değil</option>
                    <option value="was_cut_off">Kesildi</option>
                </select>
            </div>
            <div class="pep-info-cell pep-info-cell-wide">
                <label>Kategori</label>
                <v-select multiple v-model="post.categories" :options="categoryList"
                          :reduce="c => c.id" label="name" placeholder="Seçin..." class="pep-vselect" />
            </div>
        </div>

        <!-- Not (collapsible) -->
        <div class="pep-note-bar">
            <button type="button" class="pep-note-toggle" @click="showNote = !showNote">
                <span>📝 Not</span>
                <span>{{ showNote ? '▲' : '▼' }}</span>
            </button>
            <div v-if="showNote" class="pep-note-body">
                <textarea v-model="post.content" class="pep-textarea" rows="3" placeholder="Not..."></textarea>
            </div>
        </div>

        <!-- Hissedar Tablosu -->
        <div class="pep-sh-section">
            <div class="pep-sh-header">
                <div class="pep-sh-title">
                    Hissedar Listesi
                    <span class="pep-sh-badge">{{ items.length }} / 7</span>
                </div>
                <button v-if="items.length < 7" type="button" @click="showAddForm = !showAddForm" class="pep-add-btn">
                    + Hissedar Ekle
                </button>
            </div>

            <!-- Ekleme Formu -->
            <div v-if="showAddForm" class="pep-add-form">
                <input v-model="newItem.full_name" class="pep-input" placeholder="İsim Soyisim *" />
                <input v-model="newItem.phone" class="pep-input" placeholder="Telefon *" />
                <input v-model="newItem.vekalet" class="pep-input" placeholder="Vekalet" />
                <input v-model="newItem.vekalet_phone" class="pep-input" placeholder="Vekalet Tel" />
                <input v-model="newItem.tax" type="number" class="pep-input" placeholder="Taksit" style="max-width:80px" />
                <button type="button" @click="addItem" class="pep-btn pep-btn-dark">Ekle</button>
                <button type="button" @click="showAddForm=false" class="pep-btn pep-btn-close">İptal</button>
            </div>

            <!-- Tablo -->
            <div class="pep-table-wrap">
                <table class="pep-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>İsim Soyisim</th>
                            <th>Telefon</th>
                            <th>Vekalet</th>
                            <th>Vekalet Tel</th>
                            <th>Taksit</th>
                            <th>1. Ödeme</th>
                            <th>2. Ödeme</th>
                            <th>3. Ödeme</th>
                            <th>Toplam</th>
                            <th>Kalan</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(item, idx) in items" :key="idx">
                            <tr class="pep-row" :class="{ 'pep-row-active': expandedIdx === idx }">
                                <td class="pep-td-no">{{ idx + 1 }}</td>
                                <td><input v-model="item.full_name" class="pep-td-input" /></td>
                                <td><input v-model="item.phone" class="pep-td-input" /></td>
                                <td><input v-model="item.vekalet" class="pep-td-input" /></td>
                                <td><input v-model="item.vekalet_phone" class="pep-td-input" /></td>
                                <td><input v-model="item.tax" type="number" class="pep-td-input pep-td-sm" /></td>
                                <td class="pep-pay-cell">
                                    <template v-if="item.paymentItems[0]">
                                        <span class="pep-pay-amt">{{ fmtMini(item.paymentItems[0].price) }}</span>
                                        <span class="pep-pay-type">{{ item.paymentItems[0].payment_type || '-' }}</span>
                                    </template>
                                    <span v-else class="pep-pay-empty">—</span>
                                </td>
                                <td class="pep-pay-cell">
                                    <template v-if="item.paymentItems[1]">
                                        <span class="pep-pay-amt">{{ fmtMini(item.paymentItems[1].price) }}</span>
                                        <span class="pep-pay-type">{{ item.paymentItems[1].payment_type || '-' }}</span>
                                    </template>
                                    <span v-else class="pep-pay-empty">—</span>
                                </td>
                                <td class="pep-pay-cell">
                                    <template v-if="item.paymentItems[2]">
                                        <span class="pep-pay-amt">{{ fmtMini(item.paymentItems[2].price) }}</span>
                                        <span class="pep-pay-type">{{ item.paymentItems[2].payment_type || '-' }}</span>
                                    </template>
                                    <span v-else class="pep-pay-empty">—</span>
                                </td>
                                <td class="pep-td-total">{{ fmtMini(totalPaid(item)) }}</td>
                                <td class="pep-td-remain" :class="totalPaid(item) >= sharePrice ? 'pep-green' : 'pep-red'">
                                    {{ fmtMini(sharePrice - totalPaid(item)) }}
                                </td>
                                <td class="pep-td-actions">
                                    <button type="button" @click="toggleExpand(idx)" class="pep-row-btn pep-row-btn-blue">
                                        {{ expandedIdx === idx ? '▲' : '▼' }}
                                    </button>
                                    <button type="button" @click="removeItem(idx)" class="pep-row-btn pep-row-btn-red">✕</button>
                                </td>
                            </tr>

                            <!-- Ödeme Paneli -->
                            <tr v-if="expandedIdx === idx" class="pep-expanded-row">
                                <td colspan="12">
                                    <div class="pep-payment-panel">
                                        <div class="pep-panel-header">
                                            <span>{{ idx + 1 }}. Hissedar Ödemeleri</span>
                                            <button type="button" @click="expandedIdx = null" class="pep-close-x">✕</button>
                                        </div>

                                        <!-- Mevcut ödemeler -->
                                        <div v-if="item.paymentItems.length" class="pep-existing-payments">
                                            <div v-for="(p, pi) in item.paymentItems" :key="pi" class="pep-pay-card">
                                                <div class="pep-pay-card-header">
                                                    <span>{{ pi + 1 }}. Ödeme</span>
                                                    <button type="button" @click="removePayment(idx, pi)" class="pep-del-pay">Sil</button>
                                                </div>
                                                <div class="pep-pay-grid">
                                                    <div><label>Tutar</label><input type="text" class="pep-input" v-model="p.price" /></div>
                                                    <div><label>Tarih</label><input type="datetime-local" class="pep-input" v-model="p.date" /></div>
                                                    <div><label>Taksit No</label><input type="number" class="pep-input" v-model="p.tax" /></div>
                                                    <div>
                                                        <label>Ödeme Şekli</label>
                                                        <select class="pep-input" v-model="p.payment_type">
                                                            <option value="">Seçin...</option>
                                                            <option value="Nakit Elden Alınan">Nakit Elden</option>
                                                            <option value="Nakit Eft">Nakit EFT</option>
                                                            <option value="Kredi Kartı">Kredi Kartı</option>
                                                        </select>
                                                    </div>
                                                    <div class="pep-note-col"><label>Not</label><input type="text" class="pep-input" v-model="p.note" /></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Yeni ödeme -->
                                        <div class="pep-new-payment">
                                            <div class="pep-new-pay-title">+ Yeni Ödeme</div>
                                            <div class="pep-pay-grid">
                                                <div><label>Tutar *</label><input type="text" class="pep-input" v-model="newPayment.price" /></div>
                                                <div><label>Tarih *</label><input type="datetime-local" class="pep-input" v-model="newPayment.date" /></div>
                                                <div><label>Taksit No</label><input type="number" class="pep-input" v-model="newPayment.tax" /></div>
                                                <div>
                                                    <label>Ödeme Şekli</label>
                                                    <select class="pep-input" v-model="newPayment.payment_type">
                                                        <option value="">Seçin...</option>
                                                        <option value="Nakit Elden Alınan">Nakit Elden</option>
                                                        <option value="Nakit Eft">Nakit EFT</option>
                                                        <option value="Kredi Kartı">Kredi Kartı</option>
                                                    </select>
                                                </div>
                                                <div class="pep-note-col"><label>Not</label><input type="text" class="pep-input" v-model="newPayment.note" /></div>
                                            </div>
                                            <div class="pep-pay-actions">
                                                <button type="button" @click="addPayment(idx)" class="pep-btn pep-btn-dark">Ödeme Kaydet</button>
                                                <button type="button" @click="saveForm" class="pep-btn pep-btn-green">Değişiklikleri Kaydet</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        <!-- Boş satırlar -->
                        <tr v-for="i in (7 - items.length)" :key="'e'+i" class="pep-empty-row">
                            <td class="pep-td-no pep-empty-no">{{ items.length + i }}</td>
                            <td colspan="10" class="pep-empty-cell">—</td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="pep-tfoot">
                            <td colspan="9" class="pep-tf-label">GENEL TOPLAM</td>
                            <td class="pep-td-total">{{ fmtMini(grandPaid) }}</td>
                            <td class="pep-red">{{ fmtMini(grandRemain) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, watchEffect, inject } from 'vue'
import usePosts from '@/composables/posts'
import useCategories from '@/composables/categories'

const props = defineProps({ postId: { type: [Number, String], required: true } })
const emit = defineEmits(['close', 'saved'])

const swal = inject('$swal')

const todayDate = () => {
    const n = new Date()
    return `${n.getFullYear()}-${String(n.getMonth()+1).padStart(2,'0')}-${String(n.getDate()).padStart(2,'0')}T${String(n.getHours()).padStart(2,'0')}:${String(n.getMinutes()).padStart(2,'0')}`
}

const items = ref([])
const showAddForm = ref(false)
const showNote = ref(false)
const expandedIdx = ref(null)
const newItem = ref({ full_name: '', phone: '', vekalet: '', vekalet_phone: '', tax: 0, paymentItems: [] })
const newPayment = ref({ price: '', date: todayDate(), tax: 0, note: '', payment_type: '' })

const post = reactive({ id: null, title: '', status: '', amount: '', order: '', order_date: '', content: '', categories: [], share_holders_json: [], thumbnail: '' })

const { post: postData, getPost, updatePost, isLoading } = usePosts()
const { categoryList, getCategoryList } = useCategories()

const sharePrice = computed(() => post.amount ? post.amount / 7 : 0)
const totalPaid = (item) => item.paymentItems.reduce((s, p) => s + (parseFloat(p.price) || 0), 0)
const grandPaid = computed(() => items.value.reduce((s, item) => s + totalPaid(item), 0))
const grandRemain = computed(() => items.value.reduce((s, item) => s + (sharePrice.value - totalPaid(item)), 0))

const fmtCurrency = (v) => new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY', maximumFractionDigits: 0 }).format(v || 0)
const fmtMini = (v) => new Intl.NumberFormat('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(parseFloat(v) || 0) + ' ₺'

onMounted(() => {
    getPost(props.postId)
    getCategoryList()
})

watchEffect(() => {
    if (!postData.value?.id) return
    post.id = postData.value.id
    post.title = postData.value.title
    post.status = postData.value.status
    post.order = postData.value.order
    post.order_date = postData.value.order_date
    post.amount = postData.value.amount
    post.content = postData.value.content
    post.thumbnail = postData.value.original_image
    post.categories = postData.value.categories
    items.value = postData.value.share_holders_json ?? []
})

function saveForm() {
    post.share_holders_json = items.value
    updatePost(post).then(() => {
        swal({ icon: 'success', title: 'Kaydedildi' })
        emit('saved')
    })
}

const toggleExpand = (idx) => {
    expandedIdx.value = expandedIdx.value === idx ? null : idx
}

const addPayment = (idx) => {
    if (!newPayment.value.price || !newPayment.value.date) {
        swal({ icon: 'warning', title: 'Tutar ve tarih zorunlu!' }); return
    }
    items.value[idx].paymentItems.push({ ...newPayment.value })
    newPayment.value = { price: '', date: todayDate(), tax: 0, note: '', payment_type: '' }
    saveForm()
}

const removePayment = (idx, pi) => {
    items.value[idx].paymentItems.splice(pi, 1)
    saveForm()
}

const addItem = () => {
    if (items.value.length >= 7) { swal({ icon: 'warning', title: 'En fazla 7 hissedar!' }); return }
    if (!newItem.value.full_name || !newItem.value.phone) {
        swal({ icon: 'warning', title: 'İsim ve telefon zorunludur!' }); return
    }
    items.value.push({ ...newItem.value, paymentItems: [] })
    newItem.value = { full_name: '', phone: '', vekalet: '', vekalet_phone: '', tax: 0, paymentItems: [] }
    showAddForm.value = false
    saveForm()
}

const removeItem = (idx) => {
    if (confirm('Bu hissedarı silmek istiyor musunuz?')) {
        items.value.splice(idx, 1)
        if (expandedIdx.value === idx) expandedIdx.value = null
        saveForm()
    }
}
</script>

<style scoped>
.pep-wrap {
    background: #fff;
    border-top: 3px solid #1a1f2e;
}

/* Top Bar */
.pep-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.65rem 1rem;
    background: #f8f9fc;
    border-bottom: 1px solid #e9ecef;
    flex-wrap: wrap;
    gap: 0.5rem;
}
.pep-topbar-left { display: flex; align-items: center; gap: 0.75rem; }
.pep-topbar-right { display: flex; align-items: center; gap: 0.4rem; }
.pep-id-badge { background: #1a1f2e; color: #fff; font-size: 0.72rem; font-weight: 800; padding: 0.2rem 0.55rem; border-radius: 0.3rem; }
.pep-label { font-size: 0.85rem; font-weight: 700; color: #1a1f2e; }

.pep-btn {
    display: inline-flex; align-items: center; gap: 0.35rem;
    padding: 0.4rem 0.85rem; border-radius: 0.4rem;
    font-size: 0.8rem; font-weight: 700; border: none; cursor: pointer;
    text-decoration: none; transition: opacity 0.15s;
    white-space: nowrap;
}
.pep-btn:hover { opacity: 0.82; }
.pep-btn-dark  { background: #1a1f2e; color: #fff; }
.pep-btn-green { background: #2f9e44; color: #fff; }
.pep-btn-close { background: #e9ecef; color: #495057; }
.pep-spin { width: 12px; height: 12px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: sp .6s linear infinite; display: inline-block; }
@keyframes sp { to { transform: rotate(360deg); } }

/* Info Row */
.pep-info-row {
    display: flex;
    flex-wrap: wrap;
    border-bottom: 1px solid #e9ecef;
}
.pep-info-cell {
    flex: 1;
    min-width: 130px;
    padding: 0.55rem 0.85rem;
    border-right: 1px solid #f0f0f0;
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}
.pep-info-cell:last-child { border-right: none; }
.pep-info-cell-wide { flex: 1.8; min-width: 180px; }
.pep-info-cell label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; color: #868e96; }
.pep-computed span { font-size: 0.9rem; font-weight: 700; color: #2f9e44; }
.pep-input {
    border: none; outline: none; font-size: 0.85rem; font-weight: 600; color: #1a1f2e;
    background: transparent; width: 100%; padding: 0;
    border-bottom: 1px solid transparent; transition: border-color 0.15s;
}
.pep-input:focus { border-bottom-color: #1a1f2e; }
select.pep-input { cursor: pointer; }
.pep-vselect { font-size: 0.78rem; }

/* Note */
.pep-note-bar { border-bottom: 1px solid #e9ecef; }
.pep-note-toggle {
    width: 100%; display: flex; align-items: center; justify-content: space-between;
    padding: 0.5rem 0.85rem; background: #fafafa; border: none; cursor: pointer;
    font-size: 0.8rem; font-weight: 600; color: #6c757d;
}
.pep-note-toggle:hover { background: #f0f0f0; }
.pep-note-body { padding: 0.5rem 0.85rem 0.75rem; }
.pep-textarea { width: 100%; border: 1px solid #dee2e6; border-radius: 0.4rem; padding: 0.5rem 0.65rem; font-size: 0.85rem; resize: vertical; outline: none; font-family: inherit; }
.pep-textarea:focus { border-color: #1a1f2e; }

/* Shareholder Section */
.pep-sh-section { }
.pep-sh-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 0.6rem 1rem; background: #f8f9fc; border-bottom: 1px solid #e9ecef;
}
.pep-sh-title { font-size: 0.875rem; font-weight: 800; color: #1a1f2e; display: flex; align-items: center; gap: 0.5rem; }
.pep-sh-badge { background: #e38d02; color: #fff; font-size: 0.7rem; font-weight: 700; padding: 0.15rem 0.5rem; border-radius: 1rem; }
.pep-add-btn { background: #1a1f2e; color: #fff; border: none; border-radius: 0.4rem; padding: 0.35rem 0.85rem; font-size: 0.78rem; font-weight: 700; cursor: pointer; }

.pep-add-form {
    display: flex; flex-wrap: wrap; gap: 0.5rem; padding: 0.75rem 1rem;
    background: #f0f4ff; border-bottom: 1px solid #dde4f5; align-items: flex-end;
}
.pep-add-form .pep-input { border: 1px solid #dee2e6; border-radius: 0.35rem; padding: 0.35rem 0.55rem; background: #fff; flex: 1; min-width: 130px; }

/* Table */
.pep-table-wrap { overflow-x: auto; }
.pep-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; min-width: 900px; }
.pep-table thead tr { background: #7a4500; }
.pep-table thead th { padding: 0.65rem 0.75rem; color: #fff; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; white-space: nowrap; }
.pep-row td { padding: 0.5rem 0.75rem; border-bottom: 1px solid #f1f3f5; vertical-align: middle; }
.pep-row:hover td { background: #fffbf0; }
.pep-row-active td { background: #f0f4ff !important; }
.pep-empty-row td { padding: 0.45rem 0.75rem; border-bottom: 1px solid #f8f8f8; }
.pep-td-no { text-align: center; font-weight: 700; font-size: 0.75rem; color: #adb5bd; }
.pep-empty-no { color: #dee2e6; }
.pep-empty-cell { color: #dee2e6; text-align: center; }
.pep-td-input { border: 1px solid transparent; border-radius: 0.3rem; padding: 0.28rem 0.45rem; font-size: 0.78rem; width: 100%; background: transparent; outline: none; transition: all 0.15s; min-width: 80px; }
.pep-td-input:hover, .pep-td-input:focus { border-color: #dee2e6; background: #fff; }
.pep-td-sm { max-width: 55px; min-width: 45px; }
.pep-pay-cell { }
.pep-pay-amt { display: block; font-weight: 700; color: #2f9e44; font-size: 0.75rem; }
.pep-pay-type { display: block; font-size: 0.68rem; color: #868e96; }
.pep-pay-empty { color: #dee2e6; font-size: 0.75rem; }
.pep-td-total { font-weight: 700; color: #2f9e44; white-space: nowrap; }
.pep-td-remain { font-weight: 700; white-space: nowrap; }
.pep-green { color: #2f9e44; }
.pep-red { color: #e03131; }
.pep-td-actions { white-space: nowrap; }
.pep-row-btn { border: none; border-radius: 0.35rem; padding: 0.3rem 0.6rem; font-size: 0.78rem; font-weight: 700; cursor: pointer; margin: 0 1px; transition: opacity 0.15s; }
.pep-row-btn:hover { opacity: 0.75; }
.pep-row-btn-blue { background: #dde4f5; color: #3b5bdb; }
.pep-row-btn-red  { background: #ffe0e0; color: #e03131; }

/* Tfoot */
.pep-tfoot td { padding: 0.65rem 0.75rem; background: #f1f3f5; font-weight: 700; border-top: 2px solid #dee2e6; font-size: 0.82rem; }
.pep-tf-label { text-align: right; color: #495057; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.3px; }

/* Expanded Payment Panel */
.pep-expanded-row td { padding: 0; background: #f0f4ff; }
.pep-payment-panel { padding: 1rem; }
.pep-panel-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 0.85rem; padding-bottom: 0.65rem; border-bottom: 1px solid #dde4f5;
    font-size: 0.82rem; font-weight: 700; color: #3b5bdb;
}
.pep-close-x { border: none; background: #e9ecef; border-radius: 0.35rem; width: 28px; height: 28px; cursor: pointer; font-size: 0.8rem; font-weight: 700; color: #495057; transition: all 0.15s; }
.pep-close-x:hover { background: #ffc9c9; color: #e03131; }

.pep-existing-payments { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 0.85rem; }
.pep-pay-card { background: #fff; border: 1px solid #dde4f5; border-radius: 0.5rem; overflow: hidden; min-width: 260px; flex: 1; }
.pep-pay-card-header { display: flex; align-items: center; justify-content: space-between; padding: 0.4rem 0.65rem; background: #e8edff; font-size: 0.75rem; font-weight: 700; color: #3b5bdb; }
.pep-del-pay { border: none; background: #ffe0e0; color: #e03131; font-size: 0.72rem; font-weight: 700; padding: 0.15rem 0.45rem; border-radius: 0.3rem; cursor: pointer; }
.pep-pay-grid { display: flex; flex-wrap: wrap; gap: 0.4rem; padding: 0.5rem 0.65rem; }
.pep-pay-grid > div { display: flex; flex-direction: column; gap: 0.15rem; flex: 1; min-width: 100px; }
.pep-pay-grid label { font-size: 0.68rem; font-weight: 600; color: #6c757d; }
.pep-pay-grid .pep-input { border: 1px solid #dee2e6; border-radius: 0.35rem; padding: 0.3rem 0.5rem; background: #fff; font-size: 0.8rem; }
.pep-note-col { flex: 2 !important; min-width: 160px !important; }

.pep-new-payment { background: #f0fff4; border: 1px dashed #b2f2bb; border-radius: 0.5rem; overflow: hidden; }
.pep-new-pay-title { padding: 0.4rem 0.65rem; font-size: 0.75rem; font-weight: 700; color: #2f9e44; border-bottom: 1px dashed #b2f2bb; }
.pep-new-payment .pep-pay-grid { }
.pep-new-payment .pep-input { border: 1px solid #dee2e6; border-radius: 0.35rem; padding: 0.3rem 0.5rem; background: #fff; font-size: 0.8rem; }
.pep-pay-actions { display: flex; gap: 0.5rem; padding: 0.5rem 0.65rem; border-top: 1px dashed #b2f2bb; }
</style>
