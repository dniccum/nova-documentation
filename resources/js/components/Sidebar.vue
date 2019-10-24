<template>
    <card class="doc-order-first md:doc-order-3 doc-w-full md:doc-w-2/5 lg:doc-w-4/12 xl:doc-w-4/12 bg-white p-6 self-start mb-3 md:doc-mb-0">
        <h3 class="mb-2">Contents</h3>
        <ul>
            <li class="mb-2" v-for="item of content">
                <router-link :to="{name: item.name}"
                             class="cursor-pointer flex items-center font-normal text-black dim text-base no-underline"
                             exact
                >{{ item.title }}</router-link>
            </li>
        </ul>
    </card>
</template>

<script>
    export default {
        name: "Sidebar",
        props: {
            content: Array
        }
    }
</script>

<style scoped>
    .router-link-exact-active.router-link-active {
        color: var(--primary);
    }
</style>