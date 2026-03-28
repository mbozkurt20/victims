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
                            <button class="filter-tab" :class="{ active: activeFilter === 'deleted' }" @click="updateFilter('deleted')">Silindi</button>
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
                                <!-- Giriş -->
                                <svg v-if="activity.event === 'login'" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                                <!-- Çıkış -->
                                <svg v-else-if="activity.event === 'logout'" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                                <!-- Silindi -->
                                <svg v-else-if="activity.event === 'deleted'" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                                <!-- Oluşturuldu / Güncellendi -->
                                <svg v-else xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                </svg>
                            </div>
                            <div class="activity-content">
                                <div class="activity-top">
                                    <span class="event-badge" :class="'badge-' + activity.event">{{ eventLabel(activity.event) }}</span>
                                    <span v-if="activity.subject_label && !['login','logout'].includes(activity.event)" class="subject-badge">
                                        {{ activity.subject_label }}
                                    </span>
                                    <span class="activity-time" :title="activity.created_at_full">{{ activity.format_created_at }}</span>
                                </div>
                                <div class="activity-desc-row">
                                    <p class="activity-desc">{{ activity.description }}</p>
                                    <button v-if="activity.restorable"
                                            @click="restorePost(activity)"
                                            :disabled="restoringId === activity.id"
                                            class="restore-btn">
                                        <svg v-if="restoringId !== activity.id" xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                        </svg>
                                        <span v-if="restoringId === activity.id" class="restore-spin"></span>
                                        {{ restoringId === activity.id ? 'Geri alınıyor...' : 'Geri Al' }}
                                    </button>
                                </div>
                                <div class="activity-meta">
                                    <span v-if="activity.changed_fields" class="changed-fields">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" viewBox="0 0 16 16" style="margin-right:3px">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        </svg>
                                        Değişen alanlar: {{ activity.changed_fields }}
                                    </span>
                                    <span v-if="activity.properties?.ip" class="activity-ip">
                                        IP: {{ activity.properties.ip }}
                                    </span>
                                    <span class="activity-date-full">{{ activity.created_at_full }}</span>
                                </div>
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
import { watch, inject, ref } from 'vue'
import { useRoute } from 'vue-router'
import useActivityLogs from '@/composables/activityLogs.js'

const { activities, getActivityLogs, activeFilter, searchTerm, currentPage, rangeStart, rangeEnd, totalPages, total, updateFilter, applyFilters, changePage } = useActivityLogs()

const route = useRoute()
const swal = inject('$swal')
const restoringId = ref(null)

const restorePost = async (activity) => {
    try {
        restoringId.value = activity.id
        await axios.post(`/api/posts/${activity.subject_id}/restore`)
        swal({ icon: 'success', title: 'Kurban geri alındı!', timer: 1800, showConfirmButton: false })
        getActivityLogs()
    } catch {
        swal({ icon: 'error', title: 'Geri alma başarısız.' })
    } finally {
        restoringId.value = null
    }
}

const eventLabel = (event) => {
    const labels = {
        login: 'Giriş Yapıldı',
        logout: 'Çıkış Yapıldı',
        created: 'Oluşturuldu',
        updated: 'Güncellendi',
        deleted: 'Silindi',
    }
    return labels[event] || event
}

const eventClass = (event) => {
    const classes = {
        login: 'icon-green',
        logout: 'icon-orange',
        created: 'icon-blue',
        updated: 'icon-teal',
        deleted: 'icon-red',
    }
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
    background: #1a1f2e;
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
.filter-tab.active { background: #1a1f2e; color: #fff; }

/* Activity List */
.activity-list { display: flex; flex-direction: column; gap: 0; }
.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    padding: 1rem 0;
    border-bottom: 1px solid #f5f5f5;
}
.activity-item:last-child { border-bottom: none; }

.activity-icon-wrap {
    width: 34px;
    height: 34px;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
}
.icon-green  { background: #d3f9d8; color: #2f9e44; }
.icon-orange { background: #fff3cd; color: #e07b00; }
.icon-blue   { background: #dbe4ff; color: #3b5bdb; }
.icon-teal   { background: #e3fafc; color: #0c8599; }
.icon-red    { background: #ffe3e3; color: #c92a2a; }
.icon-gray   { background: #f1f3f5; color: #6c757d; }

.activity-content { flex: 1; min-width: 0; }

.activity-top {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 4px;
    flex-wrap: wrap;
}
.event-badge {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 1rem;
}
.badge-login   { background: #d3f9d8; color: #2f9e44; }
.badge-logout  { background: #fff3cd; color: #e07b00; }
.badge-created { background: #dbe4ff; color: #3b5bdb; }
.badge-updated { background: #e3fafc; color: #0c8599; }
.badge-deleted { background: #ffe3e3; color: #c92a2a; }

.subject-badge {
    font-size: 0.7rem;
    font-weight: 600;
    padding: 2px 8px;
    background: #f1f3f5;
    color: #495057;
    border-radius: 1rem;
}

.activity-time { font-size: 0.75rem; color: #adb5bd; margin-left: auto; white-space: nowrap; }

.activity-desc-row {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    margin-bottom: 4px;
}
.activity-desc { font-size: 0.875rem; color: #1a1f2e; font-weight: 600; margin: 0; }

.restore-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.2rem 0.65rem;
    background: #fff3cd;
    border: 1px solid #ffc107;
    color: #856404;
    border-radius: 1rem;
    font-size: 0.72rem;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.15s;
    flex-shrink: 0;
}
.restore-btn:hover:not(:disabled) { background: #ffc107; color: #fff; border-color: #ffc107; }
.restore-btn:disabled { opacity: 0.65; cursor: default; }
.restore-spin {
    width: 10px; height: 10px;
    border: 2px solid rgba(133,100,4,0.3);
    border-top-color: #856404;
    border-radius: 50%;
    animation: sp .6s linear infinite;
    display: inline-block;
}
@keyframes sp { to { transform: rotate(360deg); } }

.activity-meta {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    flex-wrap: wrap;
}
.changed-fields {
    font-size: 0.75rem;
    color: #0c8599;
    display: flex;
    align-items: center;
}
.activity-ip { font-size: 0.75rem; color: #adb5bd; }
.activity-date-full { font-size: 0.75rem; color: #ced4da; }

.pagination .page-link { color: #1a1f2e; }
.pagination .page-item.active .page-link { background: #1a1f2e; border-color: #1a1f2e; color: #fff; }
</style>
