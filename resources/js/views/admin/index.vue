<template>
    <div class=" my-5">
        <div class="row ">
            <div class="col-md-4 my-2 " v-for="(stat, index) in stats" :key="index">
                <div class="card text-center shadow-sm border-2 border-danger-subtle">
                    <div class="card-body">
                        <h5 class="card-title">{{ stat.title }}</h5>
                        <p class="card-text display-6 fw-bold">{{ stat.value }}</p>
                        <p class="text-muted">{{ stat.subtitle }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref,computed} from 'vue'

const data = ref({});

onMounted(() => {
    getStatistics();
});

const getStatistics = async () => {
    try {
        const res = await axios.get('/api/statistics');
        console.log({res: res.data})
        data.value = res.data;
    } catch (err) {
        console.log({err: err})
    }
}

// Burayı değiştiriyoruz:
const stats = computed(() => [
    { title: 'Varlık', value: data.value.totalAmount+'₺' ?? 0, subtitle: 'Toplam Kurban Varlığı' },
    { title: 'Toplam', value: data.value.totalVictims ?? 0, subtitle: 'Toplam Kurban Sayısı' },
    { title: 'Satış Bekleyen', value: data.value.pendingVictims ?? 0, subtitle: 'Satış Bekleyen Kurban Sayısı' },
    { title: 'Satışa Hazır', value: data.value.soldVictims ?? 0, subtitle: 'Satışa Hazır Kurban Sayısı' },
    { title: 'Satışa Hazır Olmayan', value: data.value.not_readyVictims ?? 0, subtitle: 'Satışa Hazır Olmayan Kurban Sayısı' },
]);
</script>

<style scoped>
.card {
    border-radius: 1rem;
}
</style>
