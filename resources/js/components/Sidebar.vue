<template>
    <card class="doc-order-first md:doc-order-3 doc-w-full md:doc-w-2/5 lg:doc-w-4/12 xl:doc-w-4/12 bg-white p-6 doc-self-start md:doc-mb-0">
        <h3 class="mb-2 text-2xl font-bold">Contents</h3>
        <ul class="doc-list-disc doc-ml-6">
            <li class="mb-2" v-for="item of content">
                <Link :href="item.route" class="doc-cursor-pointer doc-flex doc-items-center doc-font-normal dark:doc-text-gray-100 dark:hover:doc-text-primary-300 doc-text-base no-underline doc-transition doc-duration-150">
                    {{ item.title }}
                </Link>
            </li>
        </ul>
    </card>
</template>

<script>
    import { Link } from '@inertiajs/vue3'
    export default {
        name: "Sidebar",
        props: {
            content: Array
        },
        components: {
            Link,
        }
    }
</script>

<style scoped>
    .router-link-exact-active.router-link-active {
        color: var(--primary);
    }
</style>