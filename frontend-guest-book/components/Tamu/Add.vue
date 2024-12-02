<template>
    <div class="flex flex-col">
        <div class="flex md:flex-row flex-col gap-4 md:items-center md:justify-between">
            <form class="grid grid-cols-1 md:grid-cols-3 gap-2 flex-grow" @submit.prevent="addtamu" v-if="showForm">
                <FormGroup name="nama" v-model="tamu.nama" :errorMessage="errorBag.nama" label="nama" />
                <FormGroup name="tanggal_lahir" v-model="tamu.tanggal_lahir" :errorMessage="errorBag.tanggal_lahir"
                    label="tanggal_lahir" />
                <FormGroup name="ktp" v-model="tamu.ktp" :errorMessage="errorBag.ktp" label="ktp" />
                <FormGroup name="email" v-model="tamu.email" :errorMessage="errorBag.email" label="email" />
                <button type="submit" class="w-40 md:mt-8 text-purple-800 font-semibold" variant="ghost">Save</button>
            </form>
            <Button class="w-52 items-end" type="button" variant="primary" @click="showForm = !showForm">Add
                tamu</Button>
        </div>
    </div>
</template>

<script setup>
const tamu = reactive({
    nama: "",
    tanggal_lahir: "",
    ktp: "",
    email: ""
})

const showForm = ref(false)

const { api } = useAxios()
const { errorBag, transformValidationErrors, resetErrorBag } = useError()

const emit = defineEmits(['add'])

function addtamu() {
    console.log("adding tamu", tamu)
    resetErrorBag()
    api.post("/api/tamu", tamu).then(({ data }) => {
        console.log("details", tamu)
        emit('add', data)
    }).catch((error) => {
        transformValidationErrors(error.response)
    })
}
</script>

<style lang="scss" scoped></style>