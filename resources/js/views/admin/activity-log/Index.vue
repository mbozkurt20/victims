<template>
    <div>
        <div class="mb-4">
            <h4 class="page-title">Oturum Hareketleri</h4>
            <p class="page-subtitle">Sistemdeki tüm kullanıcı aktivitelerini görüntüleyin</p>
        </div>

        <div class="card admin-card">
            <div class="card-header-section">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h6 class="section-title">Aktivite Geçmişi</h6>
                    <span class="total-badge">{{ total }} kayıt</span>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- Arama ve Filtre -->
                <div class="row g-3 mb-4">
                    <div class="col-md-5">
                        <input type="text" v-model="searchTerm" class="form-control"
                               placeholder="Aktivite ara..." @input="applyFilters">
                    </div>
                    <div class="col-md-7">
                        <div class="filter-tabs">
                            <button class="filter-tab" :class="{ active: activeFilter === 'all' }" @click="updateFilter('all')">Tümü</button>
                            <button class="filter-tab" :class="{ active: activeFilter === 'created' }" @click="updateFilter('created')">Oluşturuldu</button>
                            <button class="filter-tab" :class="{ active: activeFilter === 'updated' }" @click="updateFilter('updated')">Güncellendi</button>
                            <button class="filter-tab" :class="{ active: activeFilter === 'login' }" @click="updateFilter('login')">Giriş</button>
                            <button class="filter-tab" :class="{ active: activeFilter === 'logout' }" @click="updateFilter('logout')">Çıkış</button>
                        </div>
                    </div>
                </div>

                <!-- Aktivite Listesi -->
                <div class="activity-list">
                    <template v-if="activities?.data?.length">
                        <div v-for="activity in activities.data" :key="activity.id" class="activity-item">
                            <div class="activity-icon-wrap" :class="eventClass(activity.event)">
                                <svg v-if="activity.event === 'login'" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                                <svg v-else-if="activity.event === 'logout'" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <div class="activity-top">
                                    <span class="event-badge" :class="'badge-' + activity.event">{{ eventLabel(activity.event) }}</span>
                                    <span class="activity-time">{{ activity.format_created_at }}</span>
                                </div>
                                <p class="activity-desc">{{ activity.description }}</p>
                                <span class="activity-ip">IP: {{ activity?.properties?.ip }}</span>
                            </div>
                        </div>
                    </template>
                    <div v-else class="text-center text-muted py-5">Aktivite bulunamadı</div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <span class="text-muted small">{{ rangeStart }}-{{ rangeEnd }} / {{ total }} kayıt</span>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">‹</a>
                            </li>
                            <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: page === currentPage }">
                                <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                            </li>
                            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">›</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { watch } from 'vue'
import { useRoute } from 'vue-router'
import useActivityLogs from '@/composables/activityLogs.js'

const { activities, getActivityLogs, activeFilter, searchTerm, currentPage, rangeStart, rangeEnd, totalPages, total, updateFilter, applyFilters, changePage } = useActivityLogs()

const route = useRoute()

const eventLabel = (event) => {
    const labels = { login: 'Giriş', logout: 'Çıkış', created: 'Oluşturuldu', updated: 'Güncellendi', deleted: 'Silindi' }
    return labels[event] || event
}

const eventClass = (event) => {
    const classes = { login: 'icon-green', logout: 'icon-orange', created: 'icon-blue', updated: 'icon-blue', deleted: 'icon-red', error: 'icon-red' }
    return classes[event] || 'icon-gray'
}

watch(
    () => route.query,
    (newQuery) => {
        activeFilter.value = newQuery?.filter || 'all'
        searchTerm.value = newQuery?.search || ''
        currentPage.value = parseInt(newQuery.page) || 1
        getActivityLogs()
    },
    { deep: true, immediate: true }
)
</script>

<style scoped>
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
.section-title { margin: 0; font-weight: 600; font-size: 0.875rem; color: #495057; }

.total-badge {
    background: #e38d02;
    color: #fff;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.25rem 0.6rem;
    border-radius: 1rem;
}

/* Filter Tabs */
.filter-tabs { display: flex; gap: 6px; flex-wrap: wrap; }
.filter-tab {
    background: #f0f2fc;
    border: none;
    border-radius: 1rem;
    padding: 0.3rem 0.85rem;
    font-size: 0.8rem;
    font-weight: 500;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.15s;
}
.filter-tab:hover { background: #e2e8ff; color: #3b5bdb; }
.filter-tab.active { background: #e38d02; color: #fff; }

/* Activity List */
.activity-list { display: flex; flex-direction: column; gap: 0; }
.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    padding: 0.85rem 0;
    border-bottom: 1px solid #f5f5f5;
}
.activity-item:last-child { border-bottom: none; }

.activity-icon-wrap {
    width: 32px;
    height: 32px;
    border-radius: 0.4rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
}
.icon-green  { background: #d3f9d8; color: #2f9e44; }
.icon-orange { background: #fff3cd; color: #e07b00; }
.icon-blue   { background: #dbe4ff; color: #3b5bdb; }
.icon-red    { background: #ffe3e3; color: #c92a2a; }
.icon-gray   { background: #f1f3f5; color: #6c757d; }

.activity-top {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 3px;
}
.event-badge {
    font-size: 0.72rem;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 1rem;
}
.badge-login   { background: #d3f9d8; color: #2f9e44; }
.badge-logout  { background: #fff3cd; color: #e07b00; }
.badge-created { background: #dbe4ff; color: #3b5bdb; }
.badge-updated { background: #e3fafc; color: #0c8599; }
.badge-deleted { background: #ffe3e3; color: #c92a2a; }

.activity-time { font-size: 0.75rem; color: #adb5bd; }
.activity-desc { font-size: 0.85rem; color: #495057; margin-bottom: 3px; }
.activity-ip { font-size: 0.75rem; color: #adb5bd; }

.pagination .page-link { color: #e38d02; }
.pagination .page-item.active .page-link { background: #e38d02; border-color: #e38d02; color: #fff; }
</style>
