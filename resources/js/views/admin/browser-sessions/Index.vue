<script setup>
import { inject, onMounted, ref } from 'vue'
import axios from 'axios'

const swal = inject('$swal')
const sessions = ref([])

const logOutOtherDevices = async () => {
    const { value: password } = await swal.fire({
        title: 'Diğer oturumları kapat',
        text: 'Devam etmek için mevcut şifrenizi girin.',
        input: 'password',
        inputPlaceholder: 'Şifrenizi girin',
        inputAttributes: { autocapitalize: 'off', autocorrect: 'off' },
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Evet, kapat',
        confirmButtonColor: '#ef4444',
        cancelButtonText: 'Vazgeç',
        reverseButtons: true,
    })

    if (password) {
        try {
            await axios.post('/api/logout-other-devices', { password })
            getBrowserSessions()
            swal.fire({ icon: 'success', title: 'Diğer oturumlar kapatıldı.' })
        } catch {
            swal.fire({ icon: 'error', title: 'Bir hata oluştu.' })
        }
    }
}

const getBrowserSessions = () => {
    axios.get('/api/browser-sessions').then(({ data }) => {
        sessions.value = data
    })
}

onMounted(() => getBrowserSessions())
</script>

<template>
    <div>
        <div class="mb-4">
            <h4 class="page-title">Tarayıcı Oturumları</h4>
            <p class="page-subtitle">Aktif oturumlarınızı görüntüleyin ve yönetin</p>
        </div>

        <div class="row">
            <div class="col-md-8 col-lg-7">
                <div class="card admin-card">
                    <div class="card-header-section">
                        <h6 class="section-title">Aktif Oturumlar</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="session-info-text px-4 py-3 border-bottom">
                            <p class="text-muted small mb-0">
                                Gerekli görmeniz durumunda diğer cihazlardaki tüm oturumlarınızı kapatabilirsiniz.
                                Aşağıda son oturumlarınızın bir listesi yer almaktadır. Hesabınızın güvenliğinin ihlal edildiğini düşünüyorsanız şifrenizi de güncellemenizi öneririz.
                            </p>
                        </div>

                        <ul class="list-group list-group-flush">
                            <li v-for="session in sessions" :key="session.ip_address" class="list-group-item session-item">
                                <div class="session-device-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M0 4s0-2 2-2h12s2 0 2 2v6s0 2-2 2h-4q0 1 .25 1.5H11a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1h.75Q6 13 6 12H2s-2 0-2-2zm1.398-.855a.76.76 0 0 0-.254.302A1.5 1.5 0 0 0 1 4.01V10c0 .325.078.502.145.602q.105.156.302.254a1.5 1.5 0 0 0 .538.143L2.01 11H14c.325 0 .502-.078.602-.145a.76.76 0 0 0 .254-.302 1.5 1.5 0 0 0 .143-.538L15 9.99V4c0-.325-.078-.502-.145-.602a.76.76 0 0 0-.302-.254A1.5 1.5 0 0 0 13.99 3H2c-.325 0-.502.078-.602.145"/>
                                    </svg>
                                </div>
                                <div class="session-details">
                                    <div class="session-device-name">
                                        {{ session?.device?.platform || 'Bilinmiyor' }}
                                        <span class="separator">·</span>
                                        {{ session?.device?.browser || 'Bilinmiyor' }}
                                    </div>
                                    <div class="session-meta">
                                        {{ session?.ip_address }}
                                        <span class="separator">·</span>
                                        <span v-if="session?.is_current_device" class="current-badge">Bu cihaz</span>
                                        <span v-else class="text-muted">Son aktif: {{ session?.last_active }}</span>
                                    </div>
                                </div>
                            </li>
                            <li v-if="!sessions.length" class="list-group-item text-center text-muted py-4">
                                Oturum bulunamadı
                            </li>
                        </ul>

                        <div class="p-4">
                            <button class="btn btn-danger-soft" type="button" @click="logOutOtherDevices">
                                Diğer Tüm Oturumları Kapat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

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

.session-item {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    padding: 0.85rem 1.25rem;
}
.session-device-icon {
    width: 38px;
    height: 38px;
    background: #f0f2fc;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #3b5bdb;
}
.session-device-name {
    font-weight: 600;
    font-size: 0.875rem;
    color: #1a1f2e;
}
.session-meta {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 2px;
}
.separator { margin: 0 4px; }
.current-badge {
    background: #d3f9d8;
    color: #2f9e44;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 1px 8px;
    border-radius: 1rem;
}

.btn-danger-soft {
    background: #fff5f5;
    color: #c92a2a;
    border: 1px solid #ffc9c9;
    padding: 0.5rem 1.25rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: background 0.15s;
}
.btn-danger-soft:hover {
    background: #ffe3e3;
}
</style>
