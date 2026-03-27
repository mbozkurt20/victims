<template>
    <div>
        <div class="mb-4">
            <h4 class="page-title">Panel</h4>
            <p class="page-subtitle">Genel istatistiklere genel bakış</p>
        </div>

        <!-- İstatistik Kartları -->
        <div class="row g-3 mb-4">
            <div class="col-md-4 col-lg-3">
                <div class="stat-card stat-orange">
                    <div class="stat-icon">₺</div>
                    <div class="stat-info">
                        <div class="stat-value">{{ formatCurrency(data.totalAmount) }}</div>
                        <div class="stat-label">Toplam Varlık</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="stat-card stat-blue">
                    <div class="stat-icon">🐄</div>
                    <div class="stat-info">
                        <div class="stat-value">{{ data.totalVictims ?? 0 }}</div>
                        <div class="stat-label">Toplam Kurban</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="stat-card stat-yellow">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-info">
                        <div class="stat-value">{{ data.pendingVictims ?? 0 }}</div>
                        <div class="stat-label">Satış Bekleyen</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="stat-card stat-green">
                    <div class="stat-icon">✅</div>
                    <div class="stat-info">
                        <div class="stat-value">{{ data.soldVictims ?? 0 }}</div>
                        <div class="stat-label">Satışta</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Durum Dağılımı -->
            <div class="col-md-6">
                <div class="card admin-card h-100">
                    <div class="card-header-section">
                        <h6 class="section-title">Kurban Durum Dağılımı</h6>
                    </div>
                    <div class="card-body p-4">
                        <div v-if="data.totalVictims" class="chart-bars">
                            <div class="chart-bar-item">
                                <div class="bar-label">
                                    <span>Satış Bekleyen</span>
                                    <span class="bar-count">{{ data.pendingVictims ?? 0 }}</span>
                                </div>
                                <div class="bar-track">
                                    <div class="bar-fill bar-yellow" :style="{ width: pct(data.pendingVictims) + '%' }"></div>
                                </div>
                                <span class="bar-pct">{{ pct(data.pendingVictims) }}%</span>
                            </div>
                            <div class="chart-bar-item">
                                <div class="bar-label">
                                    <span>Satışta</span>
                                    <span class="bar-count">{{ data.soldVictims ?? 0 }}</span>
                                </div>
                                <div class="bar-track">
                                    <div class="bar-fill bar-green" :style="{ width: pct(data.soldVictims) + '%' }"></div>
                                </div>
                                <span class="bar-pct">{{ pct(data.soldVictims) }}%</span>
                            </div>
                            <div class="chart-bar-item">
                                <div class="bar-label">
                                    <span>Hazır Değil</span>
                                    <span class="bar-count">{{ data.not_readyVictims ?? 0 }}</span>
                                </div>
                                <div class="bar-track">
                                    <div class="bar-fill bar-red" :style="{ width: pct(data.not_readyVictims) + '%' }"></div>
                                </div>
                                <span class="bar-pct">{{ pct(data.not_readyVictims) }}%</span>
                            </div>
                        </div>
                        <div v-else class="text-center text-muted py-4">Veri yükleniyor...</div>
                    </div>
                </div>
            </div>

            <!-- Halka Grafik -->
            <div class="col-md-6">
                <div class="card admin-card h-100">
                    <div class="card-header-section">
                        <h6 class="section-title">Doluluk Oranı</h6>
                    </div>
                    <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                        <div class="donut-wrapper">
                            <svg viewBox="0 0 120 120" width="180" height="180">
                                <circle cx="60" cy="60" r="50" fill="none" stroke="#f0f2fc" stroke-width="14"/>
                                <!-- Satışta -->
                                <circle cx="60" cy="60" r="50" fill="none" stroke="#22c55e" stroke-width="14"
                                    stroke-dasharray="314"
                                    :stroke-dashoffset="314 - (314 * pct(data.soldVictims) / 100)"
                                    stroke-linecap="round"
                                    transform="rotate(-90 60 60)"
                                    style="transition: stroke-dashoffset 0.6s ease"/>
                                <text x="60" y="56" text-anchor="middle" class="donut-pct" font-size="18" font-weight="700" fill="#1a1f2e">{{ pct(data.soldVictims) }}%</text>
                                <text x="60" y="72" text-anchor="middle" font-size="8" fill="#6c757d">Satışta</text>
                            </svg>
                        </div>
                        <div class="donut-legend mt-3">
                            <div class="legend-item"><span class="dot dot-green"></span>Satışta ({{ data.soldVictims ?? 0 }})</div>
                            <div class="legend-item"><span class="dot dot-yellow"></span>Bekleyen ({{ data.pendingVictims ?? 0 }})</div>
                            <div class="legend-item"><span class="dot dot-red"></span>Hazır Değil ({{ data.not_readyVictims ?? 0 }})</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'

const data = ref({})

onMounted(() => getStatistics())

const getStatistics = async () => {
    try {
        const res = await axios.get('/api/statistics')
        data.value = res.data
    } catch (err) {}
}

const pct = (val) => {
    if (!data.value.totalVictims || !val) return 0
    return Math.round((val / data.value.totalVictims) * 100)
}

const formatCurrency = (val) => {
    if (!val) return '0 ₺'
    return new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY', maximumFractionDigits: 0 }).format(val)
}
</script>

<style scoped>
.page-title { font-weight: 700; margin: 0; color: #1a1f2e; }
.page-subtitle { color: #6c757d; font-size: 0.875rem; margin: 0; }

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

/* Admin Card */
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

/* Bar Chart */
.chart-bars { display: flex; flex-direction: column; gap: 1.25rem; }
.chart-bar-item { }
.bar-label {
    display: flex;
    justify-content: space-between;
    font-size: 0.825rem;
    font-weight: 500;
    color: #495057;
    margin-bottom: 6px;
}
.bar-count { font-weight: 700; color: #1a1f2e; }
.bar-track {
    height: 10px;
    background: #f0f2fc;
    border-radius: 1rem;
    overflow: hidden;
    flex: 1;
}
.bar-fill {
    height: 100%;
    border-radius: 1rem;
    transition: width 0.6s ease;
}
.bar-yellow { background: #f59f00; }
.bar-green  { background: #40c057; }
.bar-red    { background: #fa5252; }
.bar-pct { font-size: 0.75rem; color: #6c757d; margin-top: 3px; display: block; text-align: right; }

/* Donut */
.donut-legend { display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; }
.legend-item { display: flex; align-items: center; gap: 6px; font-size: 0.8rem; color: #495057; }
.dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
.dot-green  { background: #40c057; }
.dot-yellow { background: #f59f00; }
.dot-red    { background: #fa5252; }
</style>
