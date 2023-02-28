<template>
    <div>
        <Head :title="docPageTitle" />

        <heading class="mb-6">{{ docPageTitle }}</heading>

        <div class="flex doc-flex-col md:doc-flex-row doc-items-stretch">
            <card class="doc-order-3 md:doc-order-first doc-w-full md:doc-w-3/5 lg:doc-w-2/3 xl:doc-w-8/12 bg-white p-6 md:doc-mr-3" style="min-height: 300px">
                <div class="documentation-content doc-prose lg:prose-lg dark:doc-prose-invert" v-html="htmlContent"></div>
            </card>
            <sidebar :content="sidebar"></sidebar>
        </div>
    </div>

</template>

<script>
import Sidebar from "../components/Sidebar.vue";
import highlightjs from "highlight.js";

export default {
    name: "Documentation",
    components: {
        Sidebar
    },
    props: {
        file: String,
        pageRoute: String,
        title: String,
        content: Object,
        sidebar: Array
    },
    mounted() {
        const flavor = Nova.config('highlightFlavor');
        const isDark = document.getElementsByTagName('html')[0].classList.contains('dark');
        switch (flavor) {
            case 'atom':
                if (isDark) {
                    import(/* webpackChunkName: "atomDark" */ '../../css/themes/atom-one-dark.css');
                } else {
                    import(/* webpackChunkName: "atom" */ '../../css/themes/atom-one-light.css');
                }
                break;
            case 'monokai':
                import(/* webpackChunkName: "monokai" */ '../../css/themes/monokai.css');
                break;
            case 'gradient':
                if (isDark) {
                    import(/* webpackChunkName: "gradientDark" */ '../../css/themes/gradient-dark.css');
                } else {
                    import(/* webpackChunkName: "gradient" */ '../../css/themes/gradient-light.css');
                }
                break;
            default:
                if (isDark) {
                    import(/* webpackChunkName: "githubDark" */ '../../css/themes/github-dark.css');
                } else {
                    import(/* webpackChunkName: "github" */ '../../css/themes/github.css');
                }
                break;
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('div.documentation-content pre code').forEach((block) => {
                highlightjs.highlightBlock(block);
            });
        });
    },
    computed: {
        docPageTitle() {
            if (this.content.title) {
                return this.content.title;
            }
            return 'Documentation';
        },
        htmlContent() {
            return this.content.content;
        }
    },
    methods: {
        //
    }
}
</script>

<style scoped>

</style>