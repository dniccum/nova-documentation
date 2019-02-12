<template>
    <card class="w-1/5 bg-white p-6 self-start" style="min-height: 300px">
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