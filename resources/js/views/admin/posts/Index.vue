<template>
    <div>
        <!-- İstatistik Kartları -->
        <div class="row g-3 mb-4">
            <div class="col-md-4 col-lg-3">
                <div class="stat-card stat-orange">
                    <div class="stat-icon">₺</div>
                    <div class="stat-info">
                        <div class="stat-value">{{ formatCurrency(stats.totalAmount) }}</div>
                        <div class="stat-label">Toplam Varlık</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="stat-card stat-blue">
                    <div class="stat-icon">🐄</div>
                    <div class="stat-info">
                        <div class="stat-value">{{ stats.totalVictims ?? 0 }}</div>
                        <div class="stat-label">Toplam Kurban</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="stat-card stat-yellow">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-info">
                        <div class="stat-value">{{ stats.pendingVictims ?? 0 }}</div>
                        <div class="stat-label">Satış Bekleyen</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="stat-card stat-green">
                    <div class="stat-icon">✅</div>
                    <div class="stat-info">
                        <div class="stat-value">{{ stats.soldVictims ?? 0 }}</div>
                        <div class="stat-label">Satışta</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tablo Kartı -->
        <div class="card posts-card">
            <div class="posts-card-header">
                <div class="header-title-group">
                    <h5 class="posts-title">Kurbanlar</h5>
                    <span class="posts-subtitle">Tüm kurban kayıtlarını görüntüleyin ve yönetin</span>
                </div>
                <div class="header-actions">
                    <a class="action-btn action-btn-success" href="/posts-excel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                        </svg>
                        Excel İndir
                    </a>
                    <router-link v-if="can('post-create')" :to="{ name: 'posts.create' }" class="action-btn action-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2z"/>
                        </svg>
                        Yeni Kurban Ekle
                    </router-link>
                </div>
            </div>

            <div class="posts-filters">
                <div class="filter-row">
                    <div class="filter-search-global">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="search-icon">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.099zm-5.242 1.656a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"/>
                        </svg>
                        <input v-model="search_global" type="text" placeholder="Tümünde ara..." class="filter-input" />
                    </div>
                    <input v-model="search_title" type="text" placeholder="Küpe numarasına göre ara..." class="filter-input" />
                    <v-select multiple v-model="search_category" :options="categoryList"
                              :reduce="category => category.id" label="name"
                              placeholder="Kategori seç..." class="filter-vselect" />
                    <input v-model="search_content" type="text" placeholder="Nota göre ara..." class="filter-input" />
                </div>
                <div class="filter-status-row">
                    <button @click="updateOrdering(-1)" class="status-filter-btn status-danger">
                        <span class="status-dot"></span> Eksik Hisseli
                    </button>
                    <button @click="updateOrdering(-2)" class="status-filter-btn status-success">
                        <span class="status-dot"></span> Tamamlanmış Hisseli
                    </button>
                    <button @click="updateOrdering(-3)" class="status-filter-btn status-dark">
                        <span class="status-dot"></span> Tüm Kurbanlar
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="posts-table">
                    <thead>
                        <tr>
                            <th class="th-sortable" @click="updateOrdering('id')">
                                <span :class="{ 'active-col': orderColumn === 'id' }">ID</span>
                                <span class="sort-arrows">
                                    <span :class="{ active: orderDirection === 'asc' && orderColumn === 'id' }">↑</span>
                                    <span :class="{ active: orderDirection === 'desc' && orderColumn === 'id' }">↓</span>
                                </span>
                            </th>
                            <th class="th-sortable" @click="updateOrdering('title')">
                                <span :class="{ 'active-col': orderColumn === 'title' }">Küpe / İsim</span>
                                <span class="sort-arrows">
                                    <span :class="{ active: orderDirection === 'asc' && orderColumn === 'title' }">↑</span>
                                    <span :class="{ active: orderDirection === 'desc' && orderColumn === 'title' }">↓</span>
                                </span>
                            </th>
                            <th>Fiyat</th>
                            <th>Hisse Fiyatı</th>
                            <th>Kesim Sırası</th>
                            <th>Kesim Tarihi</th>
                            <th>Durum</th>
                            <th class="th-sortable" @click="updateOrdering('number_of_shares')">
                                <span :class="{ 'active-col': orderColumn === 'number_of_shares' }">Hissedar</span>
                                <span class="sort-arrows">
                                    <span :class="{ active: orderDirection === 'asc' && orderColumn === 'number_of_shares' }">↑</span>
                                    <span :class="{ active: orderDirection === 'desc' && orderColumn === 'number_of_shares' }">↓</span>
                                </span>
                            </th>
                            <th>Kategori</th>
                            <th class="th-sortable" @click="updateOrdering('created_at')">
                                <span :class="{ 'active-col': orderColumn === 'created_at' }">Eklenme Tarihi</span>
                                <span class="sort-arrows">
                                    <span :class="{ active: orderDirection === 'asc' && orderColumn === 'created_at' }">↑</span>
                                    <span :class="{ active: orderDirection === 'desc' && orderColumn === 'created_at' }">↓</span>
                                </span>
                            </th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="post in posts.data" :key="post.id">
                        <tr class="table-row" :class="{ 'row-expanded': expandedEdit === post.id }">
                            <td class="td-id">{{ post.id }}</td>
                            <td class="td-title">{{ post.title }}</td>
                            <td class="td-amount">{{ post.amount }}₺</td>
                            <td class="td-amount">{{ formattedAmount(post.amount) }}</td>
                            <td>{{ post.order }}</td>
                            <td>{{ formatDate(post.order_date) }}</td>
                            <td>
                                <div class="fw-bold" v-html="statusPreview(post.status)"></div>
                            </td>
                            <td>{{ post.number_of_shares }} Kişi</td>
                            <td>
                                <div v-for="category in post.categories" :key="category.id" class="category-tag">
                                    {{ category.name }}
                                </div>
                            </td>
                            <td>{{ post.created_at }}</td>
                            <td class="td-actions">
                                <button v-if="can('post-edit')"
                                        @click="expandedEdit = expandedEdit === post.id ? null : post.id"
                                        class="table-btn"
                                        :class="expandedEdit === post.id ? 'table-btn-active' : 'table-btn-primary'">
                                    {{ expandedEdit === post.id ? '▲ Kapat' : '▼ Düzenle' }}
                                </button>
                                <a :href="`/victims-posts-excel/${post.id}`" class="table-btn table-btn-success">
                                    Excel
                                </a>
                                <a href="#" v-if="can('post-delete')" @click.prevent="deletePost(post.id)"
                                   class="table-btn table-btn-danger">
                                    Sil
                                </a>
                            </td>
                        </tr>
                        <tr v-if="expandedEdit === post.id" class="edit-panel-row">
                            <td colspan="11" style="padding:0">
                                <PostEditPanel
                                    :postId="post.id"
                                    @close="expandedEdit = null"
                                    @saved="getPosts()"
                                />
                            </td>
                        </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="posts-pagination">
                <Pagination :data="posts" :limit="3"
                            @pagination-change-page="page => getPosts(page, search_category, search_id, search_title, search_content, search_global, orderColumn, orderDirection)" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import usePosts from '@/composables/posts'
import useCategories from '@/composables/categories'
import { useAbility } from '@casl/vue'
import PostEditPanel from '@/components/PostEditPanel.vue'

const search_category = ref('')
const search_id = ref('')
const search_title = ref('')
const search_content = ref('')
const search_global = ref('')
const orderColumn = ref('created_at')
const orderDirection = ref('desc')
const expandedEdit = ref(null)
const { posts, getPosts, deletePost } = usePosts()
const { categoryList, getCategoryList } = useCategories()
const { can } = useAbility()

const stats = ref({})

onMounted(() => {
    getPosts()
    getCategoryList()
    getStatistics()
})

const getStatistics = async () => {
    try {
        const res = await axios.get('/api/statistics')
        stats.value = res.data
    } catch (err) {}
}

const formatCurrency = (val) => {
    if (!val) return '0 ₺'
    return new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY', maximumFractionDigits: 0 }).format(val)
}

const formattedAmount = (amount) => {
    return new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(amount / 7)
}

const formatDate = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString.replace(' ', 'T'))
    const day = String(date.getDate()).padStart(2, '0')
    const month = String(date.getMonth() + 1).padStart(2, '0')
    const year = date.getFullYear()
    const hours = String(date.getHours()).padStart(2, '0')
    const minutes = String(date.getMinutes()).padStart(2, '0')
    return `${day}-${month}-${year} ${hours}:${minutes}`
}

const updateOrdering = (column) => {
    orderColumn.value = column
    orderDirection.value = (orderDirection.value === 'asc') ? 'desc' : 'asc'
    getPosts(1, search_category.value, search_id.value, search_title.value, search_content.value, search_global.value, orderColumn.value, orderDirection.value)
}

watch(search_category, (current) => {
    getPosts(1, current, search_id.value, search_title.value, search_content.value, search_global.value)
})
watch(search_id, (current) => {
    getPosts(1, search_category.value, current, search_title.value, search_content.value, search_global.value)
})
watch(search_title, (current) => {
    getPosts(1, search_category.value, search_id.value, current, search_content.value, search_global.value)
})
watch(search_content, (current) => {
    getPosts(1, search_category.value, search_id.value, search_title.value, current, search_global.value)
})
watch(search_global, _.debounce((current) => {
    getPosts(1, search_category.value, search_id.value, search_title.value, search_content.value, current)
}, 200))

const statusPreview = (status) => {
    if (status === 'sold') return '<span class="text-success">Satışta</span>'
    if (status === 'not_ready') return '<span class="text-danger">Hazır Değil</span>'
    if (status === 'pending') return '<span class="text-warning">Satış Bekliyor</span>'
    if (status === 'was_cut_off') return '<span class="text-warning">Kesildi</span>'
}
</script>

<style scoped>
/* Stat Cards */
.stat-card {
    border-radius: 0.75rem;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
}
.stat-orange { background: linear-gradient(135deg, #e38d02, #f5a623); color: #fff; }
.stat-blue   { background: linear-gradient(135deg, #3b5bdb, #5c7cfa); color: #fff; }
.stat-yellow { background: linear-gradient(135deg, #f59f00, #fcc419); color: #fff; }
.stat-green  { background: linear-gradient(135deg, #2f9e44, #40c057); color: #fff; }
.stat-icon {
    font-size: 1.75rem;
    width: 48px;
    height: 48px;
    background: rgba(255,255,255,0.2);
    border-radius: 0.6rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.stat-value { font-size: 1.3rem; font-weight: 700; line-height: 1; }
.stat-label { font-size: 0.8rem; opacity: 0.85; margin-top: 4px; }

/* Posts Card */
.posts-card {
    border: none;
    border-radius: 0.875rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    overflow: hidden;
}

.posts-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    background: #fff;
    border-bottom: 1px solid #e9ecef;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-title-group { display: flex; flex-direction: column; gap: 2px; }
.posts-title { font-size: 1.15rem; font-weight: 700; color: #1a1f2e; margin: 0; }
.posts-subtitle { font-size: 0.8rem; color: #6c757d; }

.header-actions { display: flex; gap: 0.625rem; flex-wrap: wrap; }

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.55rem 1.1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: opacity 0.15s, transform 0.1s;
}
.action-btn:hover { opacity: 0.88; transform: translateY(-1px); }
.action-btn-primary { background: #1a1f2e; color: #fff; }
.action-btn-success  { background: #2f9e44; color: #fff; }

/* Filters */
.posts-filters {
    padding: 1rem 1.5rem;
    background: #f8f9fc;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}
.filter-row {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    align-items: center;
}
.filter-search-global {
    position: relative;
    display: flex;
    align-items: center;
}
.search-icon {
    position: absolute;
    left: 0.65rem;
    color: #adb5bd;
    pointer-events: none;
}
.filter-search-global .filter-input { padding-left: 2.1rem; }

.filter-input {
    height: 38px;
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    padding: 0 0.75rem;
    font-size: 0.85rem;
    background: #fff;
    outline: none;
    transition: border-color 0.15s;
    min-width: 180px;
}
.filter-input:focus { border-color: #1a1f2e; }

.filter-vselect {
    min-width: 200px;
    font-size: 0.85rem;
}

.filter-status-row {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}
.status-filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.9rem;
    border-radius: 2rem;
    font-size: 0.8rem;
    font-weight: 600;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.15s;
    background: #fff;
}
.status-filter-btn .status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    display: inline-block;
}
.status-danger  { color: #c92a2a; border-color: #ffc9c9; }
.status-danger .status-dot { background: #fa5252; }
.status-danger:hover { background: #fff5f5; }
.status-success { color: #2f9e44; border-color: #b2f2bb; }
.status-success .status-dot { background: #40c057; }
.status-success:hover { background: #f0fff4; }
.status-dark    { color: #1a1f2e; border-color: #dee2e6; }
.status-dark .status-dot { background: #1a1f2e; }
.status-dark:hover { background: #f1f3f5; }

/* Table */
.posts-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}
.posts-table thead tr {
    background: #f1f3f5;
}
.posts-table thead th {
    padding: 0.8rem 1rem;
    font-size: 0.775rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: #495057;
    border-bottom: 2px solid #e9ecef;
    white-space: nowrap;
}
.th-sortable {
    cursor: pointer;
    user-select: none;
}
.th-sortable:hover { background: #e9ecef; }
.active-col { color: #1a1f2e; }
.sort-arrows { margin-left: 4px; color: #adb5bd; font-size: 0.7rem; }
.sort-arrows .active { color: #1a1f2e; }

.table-row td {
    padding: 0.85rem 1rem;
    border-bottom: 1px solid #f1f3f5;
    color: #495057;
    vertical-align: middle;
}
.table-row:last-child td { border-bottom: none; }
.table-row:hover td { background: #f8f9fc; }

.td-id { font-weight: 600; color: #868e96; font-size: 0.8rem; }
.td-title { font-weight: 600; color: #1a1f2e; }
.td-amount { font-weight: 600; color: #2f9e44; font-variant-numeric: tabular-nums; }

.category-tag {
    display: inline-block;
    background: rgba(59,91,219,0.1);
    color: #3b5bdb;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.15rem 0.5rem;
    border-radius: 0.3rem;
    margin: 1px 0;
}

/* Action Buttons in Table */
.td-actions { white-space: nowrap; }
.table-btn {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.85rem;
    border-radius: 0.4rem;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    margin-right: 0.35rem;
    transition: opacity 0.15s, transform 0.1s;
}
.table-btn:last-child { margin-right: 0; }
.table-btn:hover { opacity: 0.82; transform: translateY(-1px); }
.table-btn-primary { background: #3b5bdb; color: #fff; }
.table-btn-success  { background: #2f9e44; color: #fff; }
.table-btn-danger   { background: #e03131; color: #fff; }
.table-btn-active   { background: #1a1f2e; color: #fff; }

.row-expanded td { background: #f0f4ff !important; }
.edit-panel-row td { border-bottom: 3px solid #1a1f2e; }

/* Pagination */
.posts-pagination {
    padding: 1rem 1.5rem;
    background: #fff;
    border-top: 1px solid #e9ecef;
}
</style>
