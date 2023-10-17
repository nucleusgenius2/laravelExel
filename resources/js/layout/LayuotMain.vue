<template>
    <Header v-if="props.layout === 'mainLayout'" :auth="props.auth" />
    <Menu v-if="props.layout === 'mainLayout'" />

    <div class="content">
        <slot name="content"></slot>
    </div>

</template>


<script setup>
import Menu from '@/components/Menu.vue';
import Header from '@/layout/Header.vue';
let props = defineProps({
    layout: String,
    auth: String
});


</script>

<style scoped>

</style>
