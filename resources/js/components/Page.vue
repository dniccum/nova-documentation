<template>
    <div>
        <heading class="mb-6">{{ title }}</heading>

        <div class="flex doc-flex-col md:doc-flex-row">
            <card class="doc-order-3 md:doc-order-first doc-w-full md:doc-w-3/5 lg:doc-w-2/3 xl:doc-w-8/12 bg-white p-6 md:doc-mr-3" style="min-height: 300px">
                <div class="documentation-content" v-html="content"></div>
            </card>
            <sidebar :content="sidebar"></sidebar>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import highlightjs from 'highlight.js';
    import 'highlight.js/styles/default.css';

    import Sidebar from './Sidebar';

    export default {
        name: "Page",
        components: {
            Sidebar
        },
        props: {
            file: String,
            pageRoute: String,
            title: String,
            content: String,
            pageTitle: String,
            sidebar: Array
        },
        metaInfo() {
            return {
                title: this.pageTitle,
            }
        },
        mounted() {
            setTimeout(() => {
                document.querySelectorAll('div.documentation-content pre code').forEach((block) => {
                    highlightjs.highlightBlock(block);
                });
            }, 500)
        },
        methods: {
            //
        }
    }
</script>

<style scoped>

</style>