<template>
    <MetaTags title="Tamu List" description="Tamu description" />
    <div>
        This is {{ user?.email }}
    </div>
</template>

<script setup>

const { user } = useAuth()


</script>

<style lang="scss" scoped></style>