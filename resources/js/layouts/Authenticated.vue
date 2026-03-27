<template>
    <div class="admin-layout">
        <AdminNavbar />
        <div class="admin-body">
            <AdminSidebar />
            <main class="admin-main">
                <div class="admin-content">
                    <Breadcrumb class="mb-3" :crumbs="crumbs" @selected="selected" />
                    <Suspense>
                        <router-view></router-view>
                    </Suspense>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import AdminNavbar from '../components/includes/AdminNavbar.vue'
import AdminSidebar from '../components/includes/AdminSidebar.vue'
import Breadcrumb from '../components/includes/Breadcrumb.vue'

const route = useRoute()

const crumbs = computed(() => {
    let pathArray = route.path.split('/')
    pathArray.shift()
    const breadCrumbs = [{ href: '/admin', disabled: false, text: 'Panel' }]
    let breadcrumb = ''
    let lastIndexFound = 0
    for (let i = 0; i < pathArray.length; ++i) {
        breadcrumb = `${breadcrumb}${'/'}${pathArray[i]}`
        if (
            route.matched[i] &&
            Object.hasOwnProperty.call(route.matched[i], 'meta') &&
            Object.hasOwnProperty.call(route.matched[i].meta, 'breadCrumb')
        ) {
            breadCrumbs.push({
                href: i !== 0 && pathArray[i - (i - lastIndexFound)]
                    ? '/' + pathArray[i - (i - lastIndexFound)] + breadcrumb
                    : breadcrumb,
                disabled: i + 1 === pathArray.length,
                text: route.matched[i].meta.breadCrumb || pathArray[i],
            })
            lastIndexFound = i
            breadcrumb = ''
        }
    }
    return breadCrumbs
})

function selected(crumb) {}
</script>

<style scoped>
.admin-layout {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background: #f0f2fc;
}

.admin-body {
    display: flex;
    flex: 1;
}

.admin-main {
    flex: 1;
    overflow: auto;
    min-width: 0;
}

.admin-content {
    padding: 1.5rem;
}
</style>
