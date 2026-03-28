<template>
    <div>
        <div class="page-header mb-4">
            <div>
                <h4 class="page-title">Kategoriler</h4>
                <p class="page-subtitle">Tüm kategorileri görüntüleyin ve yönetin</p>
            </div>
            <router-link v-if="can('category-create')" :to="{ name: 'categories.create' }" class="btn btn-primary-orange">
                + Kategori Ekle
            </router-link>
        </div>

        <div class="card admin-card">
            <div class="card-body p-0">
                <!-- Arama -->
                <div class="table-toolbar">
                    <input v-model="search_global" type="text" placeholder="Ara..." class="form-control search-input">
                </div>

                <div class="table-responsive">
                    <table class="table admin-table mb-0">
                        <thead>
                            <tr>
                                <th @click="updateOrdering('id')" class="sortable">
                                    ID
                                    <span class="sort-icon" v-if="orderColumn === 'id'">{{ orderDirection === 'asc' ? '↑' : '↓' }}</span>
                                </th>
                                <th @click="updateOrdering('title')" class="sortable">
                                    Başlık
                                    <span class="sort-icon" v-if="orderColumn === 'title'">{{ orderDirection === 'asc' ? '↑' : '↓' }}</span>
                                </th>
                                <th @click="updateOrdering('created_at')" class="sortable">
                                    Oluşturulma Tarihi
                                    <span class="sort-icon" v-if="orderColumn === 'created_at'">{{ orderDirection === 'asc' ? '↑' : '↓' }}</span>
                                </th>
                                <th>İşlemler</th>
                            </tr>
                            <tr class="filter-row">
                                <th><input v-model="search_id" type="text" class="form-control form-control-sm" placeholder="ID ara"></th>
                                <th><input v-model="search_title" type="text" class="form-control form-control-sm" placeholder="Başlık ara"></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in categories.data" :key="category.id">
                                <td class="text-muted small fw-semibold">#{{ category.id }}</td>
                                <td class="fw-semibold">{{ category.name }}</td>
                                <td class="text-muted small">{{ formatDate(category.created_at) }}</td>
                                <td>
                                    <div class="action-btns">
                                        <router-link
                                            v-if="can('category-edit')"
                                            :to="{ name: 'categories.edit', params: { id: category.id } }"
                                            class="table-btn table-btn-primary"
                                        >
                                            Düzenle
                                        </router-link>
                                        <button
                                            v-if="can('category-delete')"
                                            @click="deleteCategory(category.id)"
                                            class="table-btn table-btn-danger"
                                        >
                                            Sil
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!categories.data?.length">
                                <td colspan="4" class="text-center text-muted py-4">Kayıt bulunamadı</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-3 border-top" v-if="categories.data?.length">
                    <Pagination
                        :data="categories"
                        :limit="3"
                        @pagination-change-page="page => getCategories(page, search_id, search_title, search_global, orderColumn, orderDirection)"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import useCategories from '../../../composables/categories'
import { useAbility } from '@casl/vue'

const search_id = ref('')
const search_title = ref('')
const search_global = ref('')
const orderColumn = ref('created_at')
const orderDirection = ref('desc')
const { categories, getCategories, deleteCategory } = useCategories()
const { can } = useAbility()

onMounted(() => getCategories())

const formatDate = (dateStr) => {
    if (!dateStr) return '-'
    return new Date(dateStr).toLocaleDateString('tr-TR', { day: '2-digit', month: '2-digit', year: 'numeric' })
}

const updateOrdering = (column) => {
    orderColumn.value = column
    orderDirection.value = orderDirection.value === 'asc' ? 'desc' : 'asc'
    getCategories(1, search_id.value, search_title.value, search_global.value, orderColumn.value, orderDirection.value)
}

watch(search_id, (val) => getCategories(1, val, search_title.value, search_global.value))
watch(search_title, (val) => getCategories(1, search_id.value, val, search_global.value))
watch(search_global, _.debounce((val) => getCategories(1, search_id.value, search_title.value, val), 200))
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

.btn-primary-orange {
    background: #e38d02;
    color: #fff;
    border: none;
    padding: 0.5rem 1.1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: background 0.15s;
}

.btn-primary-orange:hover {
    background: #c97c02;
    color: #fff;
}

.admin-card {
    border: none;
    border-radius: 0.75rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
}

.table-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f0f0f0;
}

.search-input {
    max-width: 280px;
    border-radius: 0.5rem;
    font-size: 0.875rem;
}

.admin-table thead th {
    background: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #6c757d;
    padding: 0.75rem 1rem;
    white-space: nowrap;
}

.admin-table tbody td {
    padding: 0.85rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #f5f5f5;
    font-size: 0.875rem;
}

.admin-table tbody tr:hover {
    background: #fafafa;
}

.admin-table tbody tr:last-child td {
    border-bottom: none;
}

.sortable {
    cursor: pointer;
    user-select: none;
}

.sortable:hover {
    color: #e38d02 !important;
}

.sort-icon {
    margin-left: 4px;
    color: #e38d02;
}

.filter-row th {
    background: #fff !important;
    padding: 0.5rem 0.75rem !important;
}

.action-btns {
    display: flex;
    gap: 6px;
}

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
    transition: opacity 0.15s, transform 0.1s;
}
.table-btn:hover { opacity: 0.82; transform: translateY(-1px); }
.table-btn-primary { background: #3b5bdb; color: #fff; }
.table-btn-danger  { background: #e03131; color: #fff; }
</style>
