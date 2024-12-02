<template>
    <MetaTags title="Tamu list" />

    <div class="flex flex-col gap-10">
        <Heading> Your tamu </Heading>
        <tamuAdd @add="handletamuAddition" />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <tamuCard @delete="handletamuDeletion" v-for="tamuItem in tamu" :key="tamuItem.id" :tamu="tamuItem" />
        </div>
    </div>
</template>

<script setup>
const { api } = useAxios()

const tamu = ref([])

onMounted(() => {
    loadtamu()
})

function loadtamu() {
    api.get("/api/tamu").then(({ data }) => {
        tamu.value = data.data
    })
}

function handletamuAddition(newTamu) {
    tamu.value = [newTamu.data, ...tamu.value]
}

function handletamuDeletion(deletedTamu) {
    // Filter array tamu dengan menghapus tamu yang memiliki id yang sama dengan deletedTamu.id
    tamu.value = tamu.value.filter(p => p.id != deletedTamu.id)
}
</script>

<style lang="scss" scoped></style>
