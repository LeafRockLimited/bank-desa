<script setup>
import {ref, defineEmits, onBeforeMount, computed, onMounted, onBeforeUnmount} from "vue";

// Definisikan props
const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    }, // Mengikat data list file dari parent
    maxFiles: {
        type: Number,
        default: 10, // Maksimum file yang dapat diunggah
    },
    maxTotalSize: {
        type: Number,
        default: 25, // Maksimum ukuran total file dalam MB
    },
    allowedExtensions: {
        type: Array,
        default: () => ['.xlsx','.csv',".jpg", ".png", ".txt", ".pdf"], // Ekstensi file yang diizinkan
    },
    showModal: {
        type: Boolean,
        default: false
    },
    url:{
        type: String
    }
});

const emit = defineEmits(['update:modelValue','update:showModal'])

// Definisikan state internal
const fileName = ref(null);
const progressBarRefs = ref([]);
const isShowModal = computed(() => {
    return props.showModal
});



// Fungsi internal
const handleFileChange = (event) => {
    const files = event.target.files;

    if (files.length > props.maxFiles) {
        console.error(`Anda hanya dapat mengunggah maksimal ${props.maxFiles} file.`);
        return;
    }

    const totalSize = Array.from(files).reduce((total, file) => total + file.size, 0);

    if (totalSize / (1024 * 1024) > props.maxTotalSize) {
        console.error(`Ukuran total file tidak boleh melebihi ${props.maxTotalSize} MB.`);
        return;
    }

    const selectedFiles = Array.from(files);

    for (const file of selectedFiles) {
        const type = fileType(file)
        props.modelValue.push({
            file: file,
            type: type
        });
        fileName.value = files.length > 0 ? file.name : null
    }


};

const fileType = (file) => {
    const extension = file.name.slice(file.name.lastIndexOf('.')).toLowerCase();
    if (!props.allowedExtensions.includes(extension)) {
        console.error(`Ekstensi file ${file.name} tidak diizinkan.`);
        return;
    }
    return extension
}

const fileSize = (file) => {
    const fileSizeInBytes = file.size;
    const fileSizeInKB = fileSizeInBytes / 1024;
    const fileSizeInMb = fileSizeInKB / 1024
    return fileSizeInMb.toFixed(2);
}

function removeFile(index){
    const updatedFiles = [...props.modelValue]; // membuat salinan array
    updatedFiles.splice(index, 1); // menghapus file dari salinan
    emit('update:modelValue', updatedFiles); // mengirimkan array yang sudah diperbarui ke komponen induk
    props.modelValue.push(...updatedFiles)
}

function closeModal(){
    emit('update:showModal',false)
}

async function submit() {
    // Looping untuk setiap file dalam modelValue
    for (const [index, item] of props.modelValue.entries()) {
        const formData = new FormData();
        formData.append('file', item.file);

        try {
            // Kirim request upload
            const response = await axios.post(props.url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: function (progressEvent) {
                    if (progressEvent.lengthComputable) {
                        const percent = (progressEvent.loaded / progressEvent.total) * 100;

                        // Update progress bar untuk file ini
                        progressBarRefs.value[index].style.width = percent + '%';
                        progressBarRefs.value[index].textContent = `Progress: ${Math.round(percent)}%`;
                    }
                },
            });

            // Jika upload berhasil
            console.log('Upload success', response);

        } catch (error) {
            // Jika upload gagal
            console.error('Upload failed', error);

            // Update progress bar untuk menunjukkan error
            progressBarRefs.value[index].style.backgroundColor = 'red';
            progressBarRefs.value[index].textContent = 'Upload failed';
        }
    }
}

const handleEscKey = (event) => {
    if (event.key === "Escape") {
        closeModal();
    }
};

// Menambahkan event listener saat komponen dimuat
onMounted(() => {
    window.addEventListener('keydown', handleEscKey);
});

// Menghapus event listener saat komponen dihancurkan
onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleEscKey);
});

</script>

<template>
    <div
        :class="{
            'flex' : isShowModal,
            'hidden' : !isShowModal
        }"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center overflow-hidden" id="popup-bg" @click.self="closeModal">
        <!-- Popup Content -->
        <div class="bg-white rounded-2xl shadow-lg p-6 w-2/3 text-center">
            <svg @click="closeModal()" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <g id="Upload 3">
                    <path id="icon" d="M15 9L12 12M12 12L9 15M12 12L9 9M12 12L15 15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#D1D5DB" stroke-width="1.6" stroke-linecap="round" />
                </g>
            </svg>
            <div class="grid gap-1 mb-3">
                <div class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <g id="Attach 01">
                            <path id="Vector" d="M13.5756 7.08335L7.97765 13.0209C7.4895 13.5386 6.69804 13.5386 6.20988 13.0209C5.72173 12.5031 5.72173 11.6636 6.20988 11.1459L11.8078 5.20835M11.2202 5.83335L12.3987 4.58335C13.375 3.54782 14.9579 3.54782 15.9342 4.58335C16.9105 5.61889 16.9105 7.29782 15.9342 8.33336L14.7557 9.58336M15.3433 8.95835L9.7454 14.8959C8.28093 16.4492 5.90657 16.4492 4.4421 14.8959C2.97763 13.3426 2.97763 10.8242 4.4421 9.27085L10.04 3.33334" stroke="#4F46E5" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                    <span class="text-center text-gray-400   text-sm font-medium leading-snug">Attach File</span>
                </div>
                <p class="text-center text-gray-400   text-xs font-normal leading-4">Attach up to 10 file at a time, total file size may not exceed 25 MB</p>
            </div>
            <label>
                <div class="mb-5 w-full h-11 rounded-3xl border border-gray-300 justify-between items-center inline-flex">
                    <h2 :class="{
                        '!text-gray-900/20': !fileName,
                    }" class="text-sm text-black font-normal leading-snug pl-4"> {{fileName??'No file chosen'}} </h2>
                    <input class="hidden" type="file" multiple
                           :accept="allowedExtensions.join(',')"
                           @change="handleFileChange" />
                    <div class="flex w-28 h-11 px-2 flex-col bg-indigo-600 rounded-r-3xl shadow text-white text-xs font-semibold leading-4
                                       items-center justify-center cursor-pointer focus:outline-none">Choose File </div>
                </div>
            </label>
            <div class="max-h-96 overflow-y-auto">
                <div class="w-full grid gap-1 mb-4" v-for="(file, index) in props.modelValue">

                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <svg v-if="['.pdf','.txt'].includes(file.type)" class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <g id="File">
                                    <path id="icon" d="M31.6497 10.6056L32.2476 10.0741L31.6497 10.6056ZM28.6559 7.23757L28.058 7.76907L28.058 7.76907L28.6559 7.23757ZM26.5356 5.29253L26.2079 6.02233L26.2079 6.02233L26.5356 5.29253ZM33.1161 12.5827L32.3683 12.867V12.867L33.1161 12.5827ZM31.8692 33.5355L32.4349 34.1012L31.8692 33.5355ZM24.231 11.4836L25.0157 11.3276L24.231 11.4836ZM26.85 14.1026L26.694 14.8872L26.85 14.1026ZM11.667 20.8667C11.2252 20.8667 10.867 21.2248 10.867 21.6667C10.867 22.1085 11.2252 22.4667 11.667 22.4667V20.8667ZM25.0003 22.4667C25.4422 22.4667 25.8003 22.1085 25.8003 21.6667C25.8003 21.2248 25.4422 20.8667 25.0003 20.8667V22.4667ZM11.667 25.8667C11.2252 25.8667 10.867 26.2248 10.867 26.6667C10.867 27.1085 11.2252 27.4667 11.667 27.4667V25.8667ZM20.0003 27.4667C20.4422 27.4667 20.8003 27.1085 20.8003 26.6667C20.8003 26.2248 20.4422 25.8667 20.0003 25.8667V27.4667ZM23.3337 34.2H16.667V35.8H23.3337V34.2ZM7.46699 25V15H5.86699V25H7.46699ZM32.5337 15.0347V25H34.1337V15.0347H32.5337ZM16.667 5.8H23.6732V4.2H16.667V5.8ZM23.6732 5.8C25.2185 5.8 25.7493 5.81639 26.2079 6.02233L26.8633 4.56274C26.0191 4.18361 25.0759 4.2 23.6732 4.2V5.8ZM29.2539 6.70608C28.322 5.65771 27.7076 4.94187 26.8633 4.56274L26.2079 6.02233C26.6665 6.22826 27.0314 6.6141 28.058 7.76907L29.2539 6.70608ZM34.1337 15.0347C34.1337 13.8411 34.1458 13.0399 33.8638 12.2984L32.3683 12.867C32.5216 13.2702 32.5337 13.7221 32.5337 15.0347H34.1337ZM31.0518 11.1371C31.9238 12.1181 32.215 12.4639 32.3683 12.867L33.8638 12.2984C33.5819 11.5569 33.0406 10.9662 32.2476 10.0741L31.0518 11.1371ZM16.667 34.2C14.2874 34.2 12.5831 34.1983 11.2872 34.0241C10.0144 33.8529 9.25596 33.5287 8.69714 32.9698L7.56577 34.1012C8.47142 35.0069 9.62375 35.4148 11.074 35.6098C12.5013 35.8017 14.3326 35.8 16.667 35.8V34.2ZM5.86699 25C5.86699 27.3344 5.86529 29.1657 6.05718 30.593C6.25217 32.0432 6.66012 33.1956 7.56577 34.1012L8.69714 32.9698C8.13833 32.411 7.81405 31.6526 7.64292 30.3798C7.46869 29.0839 7.46699 27.3796 7.46699 25H5.86699ZM23.3337 35.8C25.6681 35.8 27.4993 35.8017 28.9266 35.6098C30.3769 35.4148 31.5292 35.0069 32.4349 34.1012L31.3035 32.9698C30.7447 33.5287 29.9863 33.8529 28.7134 34.0241C27.4175 34.1983 25.7133 34.2 23.3337 34.2V35.8ZM32.5337 25C32.5337 27.3796 32.532 29.0839 32.3577 30.3798C32.1866 31.6526 31.8623 32.411 31.3035 32.9698L32.4349 34.1012C33.3405 33.1956 33.7485 32.0432 33.9435 30.593C34.1354 29.1657 34.1337 27.3344 34.1337 25H32.5337ZM7.46699 15C7.46699 12.6204 7.46869 10.9161 7.64292 9.62024C7.81405 8.34738 8.13833 7.58897 8.69714 7.03015L7.56577 5.89878C6.66012 6.80443 6.25217 7.95676 6.05718 9.40704C5.86529 10.8343 5.86699 12.6656 5.86699 15H7.46699ZM16.667 4.2C14.3326 4.2 12.5013 4.1983 11.074 4.39019C9.62375 4.58518 8.47142 4.99313 7.56577 5.89878L8.69714 7.03015C9.25596 6.47133 10.0144 6.14706 11.2872 5.97592C12.5831 5.8017 14.2874 5.8 16.667 5.8V4.2ZM23.367 5V10H24.967V5H23.367ZM28.3337 14.9667H33.3337V13.3667H28.3337V14.9667ZM23.367 10C23.367 10.7361 23.3631 11.221 23.4464 11.6397L25.0157 11.3276C24.9709 11.1023 24.967 10.8128 24.967 10H23.367ZM28.3337 13.3667C27.5209 13.3667 27.2313 13.3628 27.0061 13.318L26.694 14.8872C27.1127 14.9705 27.5976 14.9667 28.3337 14.9667V13.3667ZM23.4464 11.6397C23.7726 13.2794 25.0543 14.5611 26.694 14.8872L27.0061 13.318C26.0011 13.1181 25.2156 12.3325 25.0157 11.3276L23.4464 11.6397ZM11.667 22.4667H25.0003V20.8667H11.667V22.4667ZM11.667 27.4667H20.0003V25.8667H11.667V27.4667ZM32.2476 10.0741L29.2539 6.70608L28.058 7.76907L31.0518 11.1371L32.2476 10.0741Z" fill="#4F46E5" />
                                </g>
                            </svg>
                            <svg v-if="['.jpg','.png'].includes(file.type)" class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="#4f46e5" d="M18.435 3.06H5.565a2.5 2.5 0 0 0-2.5 2.5v12.88a2.507 2.507 0 0 0 2.5 2.5h12.87a2.507 2.507 0 0 0 2.5-2.5V5.56a2.5 2.5 0 0 0-2.5-2.5m-14.37 2.5a1.5 1.5 0 0 1 1.5-1.5h12.87a1.5 1.5 0 0 1 1.5 1.5v8.66l-3.88-3.88a1.51 1.51 0 0 0-2.12 0l-4.56 4.57a.513.513 0 0 1-.71 0l-.56-.56a1.52 1.52 0 0 0-2.12 0l-1.92 1.92Zm15.87 12.88a1.5 1.5 0 0 1-1.5 1.5H5.565a1.5 1.5 0 0 1-1.5-1.5v-.75L6.7 15.06a.5.5 0 0 1 .35-.14a.52.52 0 0 1 .36.14l.55.56a1.51 1.51 0 0 0 2.12 0l4.57-4.57a.5.5 0 0 1 .71 0l4.58 4.58Z"/><path fill="#4f46e5" d="M8.062 10.565a2.5 2.5 0 1 1 2.5-2.5a2.5 2.5 0 0 1-2.5 2.5m0-4a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5"/></svg>
                            <svg v-if="['.csv','.xlsx'].includes(file.type)"  class="mx-auto"  xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 20 20"><path fill="#4f46e5" d="M6 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7.414a1.5 1.5 0 0 0-.44-1.06l-3.914-3.915A1.5 1.5 0 0 0 10.586 2zM5 4a1 1 0 0 1 1-1h4v3.5A1.5 1.5 0 0 0 11.5 8H15v8a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1zm9.793 3H11.5a.5.5 0 0 1-.5-.5V3.207z"/></svg>
                            <div class="flex flex-col justify-start">
                                <h4 class="text-gray-900 text-sm font-normal leading-snug">{{file.file.name}}</h4>
                                <h5 class="text-gray-400 text-start text-xs font-normal">Upload complete {{fileSize(file.file)}} Mb</h5>
                            </div>
                        </div>
                        <svg @click="removeFile(index)" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <g id="Upload 3">
                                <path id="icon" d="M15 9L12 12M12 12L9 15M12 12L9 9M12 12L15 15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#D1D5DB" stroke-width="1.6" stroke-linecap="round" />
                            </g>
                        </svg>
                    </div>
                    <div class="relative flex items-center gap-2.5 py-1.5">
                        <div class="relative  w-full h-2.5  overflow-hidden rounded-3xl bg-gray-100">
                            <div ref="progressBarRefs" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 0%" class="flex h-full items-center justify-center bg-indigo-600  text-white rounded-3xl"></div>
                        </div>
                        <span class="ml-2 bg-white  rounded-full  text-gray-800 text-xs font-medium flex justify-center items-center ">0%</span>
                    </div>
                </div>
            </div>


            <button @click="submit" class="flex w-28 h-9 px-2 flex-col bg-indigo-600 rounded-full shadow text-white text-xs font-semibold leading-4 items-center justify-center cursor-pointer focus:outline-none">Upload File</button>
        </div>
    </div>
</template>

<style scoped>

</style>
