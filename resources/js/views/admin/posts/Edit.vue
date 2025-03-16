<template>
    <form @submit.prevent="submitForm">
        <div class="row my-5">
            <h3 class="card card-body m-lg-2">Kurban Bilgileri</h3>

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
                                <div class="mb-4">
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
                                    <label for="post-number_of_shares" class="form-label">
                                        Hissedar Sayısı
                                    </label>
                                    <input disabled v-model="post.number_of_shares" id="post-number_of_shares" type="number" class="form-control">
                                    <div class="text-danger mt-1">
                                        {{ errors.number_of_shares }}
                                    </div>
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.number_of_shares">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                Content
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
                            <a class="btn btn-primary" href="/admin/posts">Kurbanlar</a>
<!--                            <button :disabled="isLoading" class="btn btn-primary">-->
<!--                                <div v-show="isLoading" class=""></div>-->
<!--                                <span v-if="isLoading">Processing...</span>-->
<!--                                <span v-else>Publish</span>-->
<!--                            </button>-->
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


    <div class="row mt-3 mb-3">
        <h3 class="card card-body m-lg-2">Hissedar Bilgileri</h3>
        <div class="col-md-8">
            <div class="">

                <div class="card card-body" v-if="items&& !items.length">
                    <p class="mx-auto text-center">Ekli Hissedar Bulunmamaktadir.</p>
                </div>
                <div v-else class="card card-body rounded-4 p-3 mb-3" v-for="(item, index) in items" :key="index">
                    <h5 class="bg-primary-subtle text-primary rounded-2 mb-4 py-2 px-3 fw-bold">  {{index+1}}.Hissedar Bilgileri</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="post-age" class="form-label">
                                    İsim Soyisim
                                </label>
                                <input v-model="item.full_name" id="post-age" type="text" class="form-control">
                                <div class="text-danger mt-1">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="post-age" class="form-label">
                                    Telefon
                                </label>
                                <input v-model="item.phone" id="post-age" type="text" class="form-control">
                                <div class="text-danger mt-1">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="post-age" class="form-label">
                                    Vekalet İsim Soyisim
                                </label>
                                <input v-model="item.vekalet" id="post-age" type="text" class="form-control">
                                <div class="text-danger mt-1">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="post-age" class="form-label">
                                    Vekalet Telefon
                                </label>
                                <input v-model="item.vekalet_phone" id="post-age" type="text" class="form-control">
                                <div class="text-danger mt-1">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="post-age" class="form-label">
                                        Ödeme Şekli
                                    </label>
                                    <select class="form-control" v-model="item.payment_type" name="" id="">
                                        <option value="Nakit Elden Alınan">Nakit Elden Alınan</option>
                                        <option value="Nakit Eft">Nakit Eft</option>
                                        <option value="Kredi Kartı">Kredi Kartı</option>
                                    </select>
                                    <div class="text-danger mt-1">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="post-age" class="form-label">
                                        Taksit Sayısı
                                    </label>
                                    <input class="form-control" type="number" v-model="item.tax">
                                    <div class="text-danger mt-1">

                                    </div>
                                </div>
                            </div>

                            <div class="float-end">
                                <button class="btn btn-outline-danger" @click="removeItem(index)">Sil</button>
                            </div>
                        </div>
                        <hr class="mt-3">

                        <div class="row mt-3">
                            <h4>İşlem Hareketi Ekle</h4>
                            <div class="col-md-9 gap-4 mt-3 py-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="">
                                            <label for="">Ödenen Ücret</label>
                                            <input type="text" class="form-control" v-model="paymentNewItem.price">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="">
                                            <label for="">Ödeme Tarih</label>
                                            <input value="" type="datetime-local" class="form-control" v-model="paymentNewItem.date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="">
                                            <label for="">Ödenen Taksit</label>
                                            <input type="number" class="form-control" v-model="paymentNewItem.tax">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label for="">Not</label>
                                    <textarea class="form-control" v-model="paymentNewItem.note"></textarea>
                                </div>

                                <div class="col-md-3 mt-3">
                                    <button class="btn btn-outline-success" @click="paymentAddItem(index)">Hareket Ekle</button>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <h4>İşlem Hareketleri</h4>
                            <div v-if="!item.paymentItems.length">
                                <p class="text-center">İşlem Hareketleri Bulunmuyor...</p>
                            </div>
                            <div class="border-top border-secondary-subtle p-3 mb-3" v-for="(pItem,i) in item.paymentItems">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="">
                                            <label for="">Ödenen Ücret</label>
                                            <input type="text" class="form-control" v-model="pItem.price">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="">
                                            <label for="">Ödeme Tarih</label>
                                            <input type="datetime-local" class="form-control" v-model="pItem.date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="">
                                            <label for="">Ödenen Taksit</label>
                                            <input type="number" class="form-control" v-model="pItem.tax">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label for="">Not</label>
                                    <textarea class="form-control" v-model="pItem.note"></textarea>
                                </div>

                                <div class="mt-3 float-end">
                                    <button class="btn btn-outline-danger" @click="paymentRemoveItem(index,i)">Sil</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-body">
                <h4 class="mb-4">Hissedar Ekle</h4>

                <div class="row">
                    <div class="col-md-6">
                            <div class="mb-3">
                                <label for="post-age" class="form-label">
                                    İsim Soyisim
                                </label>
                                <input v-model="newItem.full_name" id="post-age" type="text" class="form-control">
                                <div class="text-danger mt-1">

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="post-age" class="form-label">
                                    Vekalet İsim Soyisim
                                </label>
                                <input v-model="newItem.vekalet" id="post-age" type="text" class="form-control">
                                <div class="text-danger mt-1">

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="post-age" class="form-label">
                                    Ödeme Şekli
                                </label>
                                <select class="form-control" v-model="newItem.payment_type" name="" id="">
                                    <option value="Nakit Elden Alınan">Nakit Elden Alınan</option>
                                    <option value="Nakit Eft">Nakit Eft</option>
                                    <option value="Kredi Kartı">Kredi Kartı</option>
                                </select>
                                <div class="text-danger mt-1">

                                </div>
                            </div>
                        </div>
                    <div class="col-md-6">
                            <div class="mb-3">
                                <label for="post-age" class="form-label">
                                    Telefon
                                </label>
                                <input v-model="newItem.phone" id="post-age" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="post-age" class="form-label">
                                    Vekalet Telefon
                                </label>
                                <input v-model="newItem.vekalet_phone" id="post-age" type="text" class="form-control">
                                <div class="text-danger mt-1">

                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label for="post-age" class="form-label">
                                        Taksit Sayısı
                                    </label>
                                    <input class="form-control" v-model="newItem.tax" type="number">
                                    <div class="text-danger mt-1">

                                    </div>
                                </div>
                            </div>

                        <div class="mb-3">
                            <button @click="addItem" class="btn btn-success mt-4 py-2 w-50">Hissedar Ekle</button>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {inject, onMounted, reactive, ref, watchEffect} from "vue";
    import { useRoute } from "vue-router";
    import useCategories from "@/composables/categories";
    import usePosts from "@/composables/posts";
    import { useForm, useField, defineRule } from "vee-validate";
    import { required, min } from "@/validation/rules"
    import TextEditorComponent from "@/components/TextEditorComponent.vue";
    import DropZone from "@/components/DropZone.vue";
    defineRule('required', required)
    defineRule('min', min);

const swal = inject('$swal')
const todayDate = () => {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0'); // 01-12
    const day = String(now.getDate()).padStart(2, '0'); // 01-31
    const hours = String(now.getHours()).padStart(2, '0'); // 00-23
    const minutes = String(now.getMinutes()).padStart(2, '0'); // 00-59
    return `${year}-${month}-${day}T${hours}:${minutes}`;
}

const items = ref([{af: 'assa'}]);
const newItem = ref({ full_name: "", phone: "",vekalet: "",vekalet_phone: "", payment_type: "Nakit Elden Alınan", tax: 0, paymentItems: [] });

const paymentNewItem = ref({ price: "", date: todayDate(), tax: 0,note: "" });
    // Define a validation schema
    const schema = {
        title: 'required|min:1',
        status: 'required',
        age: 'required',
        amount: 'required',
        kg: 'required',
        content: 'required|min:5',
        categories: 'required'
    }
    // Create a form context with the validation schema
    const { validate, errors, resetForm } = useForm({ validationSchema: schema })
    // Define actual fields for validation
    const { value: title } = useField('title', null, { initialValue: '' });
    const {value: age} = useField('age', null, {initialValue: ''});
    const {value: status} = useField('status', null, {initialValue: ''});
    const {value: number_of_shares} = useField('number_of_shares', null, {initialValue: 1});
    const {value: amount} = useField('amount', null, {initialValue: ''});
    const {value: kg} = useField('kg', null, {initialValue: ''});
    const {value: order} = useField('order', null, {initialValue: ''});
    const {value: share_holders_json} = useField('share_holders_json', null, {initialValue: items.value});
    const { value: content } = useField('content', null, { initialValue: '' });
    const { value: categories } = useField('categories', null, { initialValue: '', label: 'category' });
    const { categoryList, getCategoryList } = useCategories()
    const { post: postData, getPost, updatePost, validationErrors, isLoading } = usePosts()
    const post = reactive({
        title,
        age,
        status,
        number_of_shares,
        amount,
        kg,
        order,
        content,
        categories,
        share_holders_json,
        thumbnail: ''
    })
    const route = useRoute();


    function submitForm() {
        post.share_holders_json = items.value;
        validate().then(form => { if (form.valid) updatePost(post) })
    }
    onMounted(() => {
        getPost(route.params.id)
        getCategoryList()
    })

    watchEffect(() => {
        post.id = postData.value.id
        post.title = postData.value.title
        post.status = postData.value.status
        post.age = postData.value.age
        post.order = postData.value.order
        post.kg = postData.value.kg
        post.amount = postData.value.amount
        post.amount = postData.value.amount
        post.number_of_shares = postData.value.number_of_shares
        post.content = postData.value.content
        post.thumbnail = postData.value.original_image
        post.categories = postData.value.categories
        post.share_holders_json = postData.value.share_holders_json
        items.value = postData.value.share_holders_json??[]
    })

    const paymentAddItem = (index) => {
        if (paymentNewItem.value.price && paymentNewItem.value.date) {
            let paymentItems = items.value[index].paymentItems;

            paymentItems.push({ ...paymentNewItem.value });

            swal({
                icon: 'success',
                title: `${newItem.value.full_name} İşlem Hareketi Eklendi`
            })

            paymentNewItem.value = { price: "", date: "", tax: 0, note: " "};
            submitForm();
        }else {
            swal({
                icon: 'warning',
                title: 'Eksik Bilgileri Giriniz!'
            })
        }
    };

    const paymentRemoveItem = (index,i) => {
        let paymentItems = items.value[index].paymentItems;

        paymentItems.value.splice(i, 1);
    };

    const addItem = () => {
        if (items.value && items.value.length < 7){
            if (newItem.value.full_name && newItem.value.phone && newItem.value.vekalet && newItem.value.vekalet_phone  && newItem.value.payment_type) {
                items.value.push({ ...newItem.value });

                swal({
                    icon: 'success',
                    title: `${newItem.value.full_name} Hissedar Olarak Eklendi`
                })

                newItem.value = { full_name: "", phone: "",vekalet: "",vekalet_phone: "", payment_type: "", tax: 0,paymentItems: []};

            }else {
                swal({
                    icon: 'warning',
                    title: 'Eksik Bilgileri Giriniz!'
                })
            }
            submitForm();
        }else {
            swal({
                icon: 'warning',
                title: 'En fazla 7 Hissedar Eklenebilir!'
            })
        }
    };

    const removeItem = (index) => {
        if (confirm('Silmek istediğine emin misin?') === true){
            items.value.splice(index, 1);
        }

    };

</script>
