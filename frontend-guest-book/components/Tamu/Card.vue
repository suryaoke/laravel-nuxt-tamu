<template>
    <div class="flex flex-col gap-2 p-4 rounded-lg shadow relative">
        <TrashIcon @click="deletetamu" class="size-5 text-red-600 absolute right-5 top-4" />
        <NuxtLink :to="`/dashboard/tamu/${tamu.id}`">
            <Heading as="h6" class="text-start flex items-center justify-between">
                <span>Nama: {{ tamu?.nama }}</span>
            </Heading>
            <p class="text-gray-600">Tanggal lahir: {{ tamu?.tanggal_lahir }}</p>
            <p class="text-gray-600">KTP: {{ tamu?.ktp }}</p>
            <p class="text-gray-600">Email: {{ tamu?.email }}</p>
        </NuxtLink>
    </div>

</template>

<script setup>
import { TrashIcon } from "@heroicons/vue/24/outline"

const props = defineProps({
    tamu: Object
})

const { api } = useAxios()

const emit = defineEmits(['delete'])

function deletetamu() {
    api.delete(`/api/tamu/${props.tamu.id}`).then(() => {
        emit('delete', props.tamu)
    })

}

</script>

<style lang="scss" scoped></style>