<template>
    <card class="doc-order-first md:doc-order-3 doc-w-full md:doc-w-2/5 lg:doc-w-4/12 xl:doc-w-4/12 bg-white p-6 doc-self-start md:doc-mb-0">
        <h3 class="mb-2 text-2xl font-bold">Contents</h3>
        <ul class="doc-list-disc doc-ml-6">
            <li class="mb-2" v-for="item of content">
                <Link :href="parseRoute(item)"
                      :class="textClass(item)"
                      class="doc-cursor-pointer doc-flex doc-items-center doc-font-normal doc-text-base no-underline doc-transition doc-duration-150">
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
        },
        methods: {
            textClass(item) {
                if ((item.route.length > 0 && this.$page.url.endsWith(item.route)) || item.isHome && this.$page.url.endsWith('documentation')) {
                    return 'doc-text-primary-500 hover:doc-text-primary-700';
                } else {
                    return 'doc-text-gray-700 dark:doc-text-gray-100 hover:dark:doc-text-primary-200';
                }
            },
            parseRoute(item) {
                const { route, isHome } = item;
                const basePath = Nova.config('base');
                const urlPrfix = Nova.config('urlPrefix');
                const root = `${basePath}/${urlPrfix}`;
                if (isHome) {
                    return root;
                }
                return `${root}${route}`;
            }
        }
    }
</script>

<style scoped>
    .router-link-exact-active.router-link-active {
        color: var(--primary);
    }
</style>