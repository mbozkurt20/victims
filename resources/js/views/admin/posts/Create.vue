<template>
    <form @submit.prevent="submitForm">
        <div class="row my-5">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="post-title" class="form-label">
                                Küpe Numarası / İsim
                            </label>
                            <input v-model="post.title" id="post-title" type="text" class="form-control">
                            <div class="text-danger mt-1">
                                {{ errors.title }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.title">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="post-title" class="form-label">
                                       Kilo
                                    </label>
                                    <input v-model="post.kg" id="post-kg" type="number" class="form-control">
                                    <div class="text-danger mt-1">
                                        {{ errors.kg }}
                                    </div>
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.kg">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="post-age" class="form-label">
                                        Yaşı
                                    </label>
                                    <input v-model="post.age" id="post-age" type="number" class="form-control">
                                    <div class="text-danger mt-1">
                                        {{ errors.age }}
                                    </div>
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.age">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="post-amount" class="form-label">
                                        Fiyat
                                    </label>
                                    <input v-model="post.amount" id="post-amount" type="number" class="form-control">
                                    <div class="text-danger mt-1">
                                        {{ errors.amount }}
                                    </div>
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.amount">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="post-order" class="form-label">
                                        Kesim Sırası
                                    </label>
                                    <input v-model="post.order" id="post-order" type="number" class="form-control">
                                    <div class="text-danger mt-1">
                                        {{ errors.order }}
                                    </div>
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.order">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="post-order-date" class="form-label">
                                        Kesim Tarihi
                                    </label>
                                    <input v-model="post.order_date" id="post-order-date" type="datetime-local" class="form-control">
                                    <div class="text-danger mt-1">
                                        {{ errors.order }}
                                    </div>
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.order">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                            </div>
<!--                            <div class="col-md-4">-->
<!--                                <div class="mb-3">-->
<!--                                    <label for="post-number_of_shares" class="form-label">-->
<!--                                        Hissedar Sayısı-->
<!--                                    </label>-->
<!--                                    <input v-model="post.number_of_shares" id="post-number_of_shares" type="number" maxlength="7" class="form-control">-->
<!--                                    <div class="text-danger mt-1">-->
<!--                                        {{ errors.number_of_shares }}-->
<!--                                    </div>-->
<!--                                    <div class="text-danger mt-1">-->
<!--                                        <div v-for="message in validationErrors?.number_of_shares">-->
<!--                                            {{ message }}-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="post-order" class="form-label">
                                       Durumu
                                    </label>
                                    <select v-model="post.status" class="form-control" name="status" id="">
                                        <option value="pending">Satış Bekliyor</option>
                                        <option value="sold">Satışta</option>
                                        <option value="not_ready">Hazır Değil</option>
                                    </select>
                                    <div class="text-danger mt-1">
                                        {{ errors.status }}
                                    </div>
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.status">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="mb-3">
                            <label for="post-content" class="form-label">
                                Not
                            </label>
                            <TextEditorComponent v-model="post.content"/>
                            <div class="text-danger mt-1">
                                {{ errors.content }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.content">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                            </svg> Action
                        </h6>
                        <div class="mt-3 text-center">
                            <button :disabled="isLoading" class="btn btn btn-success me-2">
                                <div v-show="isLoading" class=""></div>
                                <span v-if="isLoading">Processing...</span>
                                <span v-else>Kaydet</span>
                            </button>
                            <a class="btn btn-primary" href="/admin/posts">Listeye Geri Dön</a>
                        </div>
                        <h6 class="mt-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                            </svg> Category
                        </h6>
                        <!-- Category -->
                        <div class="mb-3">
                            <v-select multiple v-model="post.categories" :options="categoryList"
                                      :reduce="category => category.id" label="name" class="form-control" placeholder="Select category"/>
                            <div class="text-danger mt-1">
                                {{ errors.categories }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.categories">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
<!--                        <div class="mb-3">
                            <h6 class="mt-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                                </svg> Thumbnail
                            </h6>
                            <input @change="post.thumbnail = $event.target.files[0]" type="file" class="form-control"
                                   id="thumbnail"/>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.thumbnail">
                                    {{ message }}
                                </div>
                            </div>
                        </div>-->
                        <div class="mb-3">
                            <h6 class="mt-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-square" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                                </svg> Thumbnail
                            </h6>
                            <DropZone v-model="post.thumbnail"/>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.thumbnail">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>
<script setup>
import {onMounted, reactive, ref} from "vue";
import TextEditorComponent from "@/components/TextEditorComponent.vue";
import DropZone from "@/components/DropZone.vue";
import useCategories from "@/composables/categories";
import usePosts from "@/composables/posts";
import {useForm, useField, defineRule} from "vee-validate";
import {required, min} from "@/validation/rules"

defineRule('required', required)
defineRule('min', min);
// Define a validation schema
const schema = {
    title: 'required|min:1',
    age: 'required',
    order: 'required',
    order_date: 'required',
    status: 'required',
    amount: 'required',
    kg: 'required',
    content: 'required|min:5',
    categories: 'required'
}
// Create a form context with the validation schema
const {validate, errors} = useForm({validationSchema: schema})
// Define actual fields for validation
const {value: title} = useField('title', null, {initialValue: ''});
const {value: age} = useField('age', null, {initialValue: ''});
const {value: status} = useField('status', null, {initialValue: ''});
const {value: number_of_shares} = useField('number_of_shares', null, {initialValue: 0});
const {value: amount} = useField('amount', null, {initialValue: ''});
const {value: kg} = useField('kg', null, {initialValue: ''});
const {value: order} = useField('order', null, {initialValue: ''});
const {value: order_date} = useField('order_date', null, {initialValue: ''});
const {value: content} = useField('content', null, {initialValue: ''});
const {value: categories} = useField('categories', null, {initialValue: '', label: 'category'});
const {categoryList, getCategoryList} = useCategories()
const {storePost, validationErrors, isLoading} = usePosts()
const post = reactive({
    title,
    age,
    status,
    number_of_shares,
    amount,
    kg,
    order,
    order_date,
    content,
    categories,
    thumbnail: ''
})

const thefile = ref('')

function submitForm() {
    validate().then(form => {
        if (form.valid) storePost(post)
    })
}

onMounted(() => {
    getCategoryList()
})

</script>
