<template>
    <div class="row justify-content-center my-2">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-transparent">
                    <h5 class="float-start">Kurbanlar</h5>
                    <router-link v-if="can('post-create')" :to="{ name: 'posts.create' }" class="btn btn-primary btn-sm float-end">
                        Yeni Kurban Ekle
                    </router-link>
                    <a class="btn btn-success btn-sm float-end px-3" style="margin-right: 5px" href="/posts-excel">Excel İndir</a>
                </div>
                <div class="card-body shadow-sm">
                    <div class="mb-4">
                        <input v-model="search_global" type="text" placeholder="Ara..."
                               class="form-control w-25">
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <input v-model="search_id" type="text"
                                           class="inline-block mt-1 w-25 form-control"
                                           placeholder="ID ile ara">
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <input v-model="search_title" type="text"
                                           class="inline-block mt-1 form-control"
                                           placeholder="Küpe numarasına göre ara">
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <v-select multiple v-model="search_category" :options="categoryList"
                                              :reduce="category => category.id" label="name" class="form-control w-100"/>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <input v-model="search_content" type="text"
                                           class="inline-block mt-1 form-control"
                                           placeholder="Nota göre ara">
                                </th>
                                <th class="px-6 py-3 text-start"></th>
                                <th class="px-6 py-3 text-start"></th>
                            </tr>
                            <tr>
                                <th class="px-6 py-3 text-start">
                                    <div class="flex flex-row"
                                         @click="updateOrdering('id')">
                                        <div class="font-medium text-uppercase"
                                             :class="{ 'font-bold text-blue-600': orderColumn === 'id' }">
                                            ID
                                        </div>
                                        <div class="select-none">
                                <span :class="{
                                  'text-blue-600': orderDirection === 'asc' && orderColumn === 'id',
                                  'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'id',
                                }">&uarr;</span>
                                            <span :class="{
                                  'text-blue-600': orderDirection === 'desc' && orderColumn === 'id',
                                  'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'id',
                                }">&darr;</span>
                                        </div>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left">
                                    <div class="flex flex-row"
                                         @click="updateOrdering('title')">
                                        <div class="font-medium text-uppercase"
                                             :class="{ 'font-bold text-blue-600': orderColumn === 'title' }">
                                            Küpe Numarası / İsim
                                        </div>
                                        <div class="select-none">
                                <span :class="{
                                  'text-blue-600': orderDirection === 'asc' && orderColumn === 'title',
                                  'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'title',
                                }">&uarr;</span>
                                            <span :class="{
                                  'text-blue-600': orderDirection === 'desc' && orderColumn === 'title',
                                  'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'title',
                                }">&darr;</span>
                                        </div>
                                    </div>
                                </th>

                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Ağırlık</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Fiyat</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Kesim Sırası</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Durum</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <div class="flex flex-row items-center justify-between cursor-pointer"
                                         @click="updateOrdering('number_of_shares')">
                                        <div class="leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                             :class="{ 'font-bold text-blue-600': orderColumn === 'number_of_shares' }">
                                            Hissedar
                                        </div>
                                        <div class="select-none">
                                <span style="cursor: pointer" :class="{
                                  'text-blue-600': orderDirection === 'asc' && orderColumn === 'number_of_shares',
                                  'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'number_of_shares',
                                }">&uarr;</span>
                                            <span style="cursor: pointer" :class="{
                                  'text-blue-600': orderDirection === 'desc' && orderColumn === 'number_of_shares',
                                  'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'number_of_shares',
                                }">&darr;</span>
                                        </div>
                                    </div>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Kategori</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Not</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <div class="flex flex-row items-center justify-between cursor-pointer"
                                         @click="updateOrdering('created_at')">
                                        <div class="leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                             :class="{ 'font-bold text-blue-600': orderColumn === 'created_at' }">
                                            Eklenme Tarihi
                                        </div>
                                        <div class="select-none">
                                <span style="cursor: pointer" :class="{
                                  'text-blue-600': orderDirection === 'asc' && orderColumn === 'created_at',
                                  'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'created_at',
                                }">&uarr;</span>
                                            <span style="cursor: pointer" :class="{
                                  'text-blue-600': orderDirection === 'desc' && orderColumn === 'created_at',
                                  'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'created_at',
                                }">&darr;</span>
                                        </div>
                                    </div>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    İşlemler
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="post in posts.data" :key="post.id">
                                <td class="px-6 py-4 text-sm" width="20">
                                    {{ post.id }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ post.title }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ post.kg }} kg
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ post.amount }}₺
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ post.order }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="fw-bold" v-html="statusPreview(post.status)"></div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ post.number_of_shares }} Kişi
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div v-for="category in post.categories">
                                        {{ category.name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div v-html="post.content.slice(0, 150)"></div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ post.created_at }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <router-link v-if="can('post-edit')"
                                                 :to="{ name: 'posts.edit', params: { id: post.id } }" class="badge bg-primary">Düzenle
                                    </router-link>
                                    <a href="#" v-if="can('post-delete')" @click.prevent="deletePost(post.id)"
                                       class="ms-2 badge bg-danger">Sil</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <Pagination :data="posts" :limit="3"
                                @pagination-change-page="page => getPosts(page, search_category, search_id, search_title, search_content, search_global, orderColumn, orderDirection)"
                                class="mt-4"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import {ref, onMounted, watch} from "vue";
    import usePosts from "@/composables/posts";
    import useCategories from "@/composables/categories";
    import {useAbility} from '@casl/vue'

    const search_category = ref('')
    const search_id = ref('')
    const search_title = ref('')
    const search_content = ref('')
    const search_global = ref('')
    const orderColumn = ref('created_at')
    const orderDirection = ref('desc')
    const {posts, getPosts, deletePost} = usePosts()
    const {categoryList, getCategoryList} = useCategories()
    const {can} = useAbility();
    onMounted(() => {
        getPosts()
        getCategoryList()
    })
    const updateOrdering = (column) => {
        orderColumn.value = column;
        orderDirection.value = (orderDirection.value === 'asc') ? 'desc' : 'asc';
        getPosts(
            1,
            search_category.value,
            search_id.value,
            search_title.value,
            search_content.value,
            search_global.value,
            orderColumn.value,
            orderDirection.value
        );
    }
    watch(search_category, (current, previous) => {
        getPosts(
            1,
            current,
            search_id.value,
            search_title.value,
            search_content.value,
            search_global.value
        )
    })
    watch(search_id, (current, previous) => {
        getPosts(
            1,
            search_category.value,
            current,
            search_title.value,
            search_content.value,
            search_global.value
        )
    })
    watch(search_title, (current, previous) => {
        getPosts(
            1,
            search_category.value,
            search_id.value,
            current,
            search_content.value,
            search_global.value
        )
    })
    watch(search_content, (current, previous) => {
        getPosts(
            1,
            search_category.value,
            search_id.value,
            search_title.value,
            current,
            search_global.value
        )
    })
    watch(search_global, _.debounce((current, previous) => {
        getPosts(
            1,
            search_category.value,
            search_id.value,
            search_title.value,
            search_content.value,
            current
        )
    }, 200))

    const statusPreview = (status) => {
        if (status === 'sold'){
            return '<span class="text-success">Satışta</span';
        }
        if (status === 'not_ready'){
            return '<span class="text-danger">Hazır Değil</span';
        }
        if (status === 'pending'){
            return '<span class="text-warning">Satış Bekliyor</span';
        }
    }
</script>
