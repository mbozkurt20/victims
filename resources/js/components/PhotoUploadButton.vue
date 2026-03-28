<template>
    <!-- Gizli file input -->
    <input
        type="file"
        ref="fileInput"
        class="hidden-file-input"
        accept=".gif,.webp,.jpg,.jpeg,.png"
        @change="onFileChange"
    />

    <!-- Buton -->
    <button type="button" class="photo-btn" @click="handleClick">
        <span class="photo-btn-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
            </svg>
        </span>
        <span v-if="hasPhoto">
            <span class="photo-thumb-mini">
                <img :src="currentSrc" alt="foto" />
            </span>
            Fotoğrafı Görüntüle / Değiştir
        </span>
        <span v-else>Fotoğraf Yükle</span>
    </button>

    <!-- Modal (fotoğraf varsa) -->
    <div v-if="showModal" class="photo-modal-overlay" @click.self="closeModal">
        <div class="photo-modal">
            <div class="photo-modal-header">
                <span>Fotoğraf Önizleme</span>
                <button type="button" class="modal-close-btn" @click="closeModal">✕</button>
            </div>
            <div class="photo-modal-body">
                <img :src="currentSrc" alt="Kurban Fotoğrafı" class="photo-modal-img" />
            </div>
            <div class="photo-modal-footer">
                <button type="button" class="modal-change-btn" @click="triggerFileInput">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                        <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                    </svg>
                    Fotoğrafı Değiştir
                </button>
                <button type="button" class="modal-remove-btn" @click="removePhoto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                    Fotoğrafı Kaldır
                </button>
                <button type="button" class="modal-cancel-btn" @click="closeModal">Kapat</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    modelValue: { type: [String, Object], default: '' }
})
const emit = defineEmits(['update:modelValue'])

const fileInput = ref(null)
const showModal = ref(false)
const newFileSrc = ref('')   // yeni seçilen dosyanın önizlemesi

const hasPhoto = computed(() => !!(props.modelValue || newFileSrc.value))

const currentSrc = computed(() => {
    if (newFileSrc.value) return newFileSrc.value
    if (typeof props.modelValue === 'string' && props.modelValue) return props.modelValue
    return ''
})

const handleClick = () => {
    if (hasPhoto.value) {
        showModal.value = true
    } else {
        triggerFileInput()
    }
}

const triggerFileInput = () => {
    showModal.value = false
    fileInput.value?.click()
}

const onFileChange = () => {
    const file = fileInput.value?.files?.[0]
    if (!file) return
    newFileSrc.value = URL.createObjectURL(file)
    emit('update:modelValue', file)
}

const removePhoto = () => {
    newFileSrc.value = ''
    emit('update:modelValue', '')
    showModal.value = false
    if (fileInput.value) fileInput.value.value = ''
}

const closeModal = () => {
    showModal.value = false
}
</script>

<style scoped>
.hidden-file-input {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    overflow: hidden;
    pointer-events: none;
}

/* Button */
.photo-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.55rem 1.1rem;
    border: 1.5px dashed #adb5bd;
    border-radius: 0.6rem;
    background: #f8f9fc;
    color: #495057;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    width: 100%;
    justify-content: center;
}
.photo-btn:hover {
    border-color: #1a1f2e;
    background: #f0f2fc;
    color: #1a1f2e;
}
.photo-btn-icon {
    color: #868e96;
    display: flex;
    align-items: center;
}
.photo-thumb-mini {
    display: inline-flex;
    align-items: center;
    margin-right: 2px;
}
.photo-thumb-mini img {
    width: 24px;
    height: 24px;
    border-radius: 0.3rem;
    object-fit: cover;
    border: 1px solid #dee2e6;
}

/* Modal Overlay */
.photo-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.65);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    backdrop-filter: blur(3px);
}

/* Modal Box */
.photo-modal {
    background: #fff;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    max-width: 560px;
    width: 100%;
    animation: modalIn 0.2s ease;
}
@keyframes modalIn {
    from { opacity: 0; transform: scale(0.95) translateY(8px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}

.photo-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.85rem 1.25rem;
    background: #f8f9fc;
    border-bottom: 1px solid #e9ecef;
    font-size: 0.925rem;
    font-weight: 700;
    color: #1a1f2e;
}
.modal-close-btn {
    border: none;
    background: #e9ecef;
    border-radius: 0.4rem;
    width: 28px;
    height: 28px;
    cursor: pointer;
    font-size: 0.875rem;
    color: #495057;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s;
}
.modal-close-btn:hover { background: #dee2e6; }

.photo-modal-body {
    padding: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f3f5;
    min-height: 260px;
}
.photo-modal-img {
    max-width: 100%;
    max-height: 400px;
    border-radius: 0.6rem;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    object-fit: contain;
}

.photo-modal-footer {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.85rem 1.25rem;
    border-top: 1px solid #e9ecef;
    flex-wrap: wrap;
}
.modal-change-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1rem;
    background: #1a1f2e;
    color: #fff;
    border: none;
    border-radius: 0.5rem;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.15s;
}
.modal-change-btn:hover { opacity: 0.85; }
.modal-remove-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1rem;
    background: #fff0f0;
    color: #e03131;
    border: 1px solid #ffc9c9;
    border-radius: 0.5rem;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s;
}
.modal-remove-btn:hover { background: #ffe0e0; }
.modal-cancel-btn {
    margin-left: auto;
    padding: 0.5rem 1rem;
    background: #f1f3f5;
    color: #495057;
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s;
}
.modal-cancel-btn:hover { background: #e9ecef; }
</style>
