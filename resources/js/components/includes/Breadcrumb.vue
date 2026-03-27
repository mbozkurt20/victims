<template>
    <nav class="breadcrumb-nav" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li
                v-for="(crumb, ci) in crumbs"
                :key="ci"
                class="breadcrumb-item"
                :class="{ active: isLast(ci) }"
            >
                <router-link
                    v-if="!isLast(ci)"
                    :to="crumb.href"
                    class="breadcrumb-link"
                    @click="selected(crumb)"
                >
                    {{ crumb.text }}
                </router-link>
                <span v-else class="breadcrumb-current">{{ crumb.text }}</span>
            </li>
        </ol>
    </nav>
</template>

<script>
export default {
    props: {
        crumbs: {
            type: Array,
            required: true,
        },
    },
    methods: {
        isLast(index) {
            return index === this.crumbs.length - 1;
        },
        selected(crumb) {
            this.$emit('selected', crumb);
        },
    },
};
</script>

<style scoped>
.breadcrumb-nav {
    background: #fff;
    border-radius: 0.5rem;
    padding: 0.6rem 1rem;
    border: 1px solid #e9ecef;
}

.breadcrumb {
    font-size: 0.85rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: '/';
    color: #adb5bd;
}

.breadcrumb-link {
    color: #e38d02;
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb-link:hover {
    text-decoration: underline;
}

.breadcrumb-current {
    color: #6c757d;
    font-weight: 500;
}
</style>
