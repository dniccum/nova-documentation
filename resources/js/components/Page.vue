<template>
    <div>
        <heading class="mb-6">{{ title }}</heading>

        <div class="flex flex-row">
            <card class="w-4/5 bg-white p-6 mr-2" style="min-height: 300px">
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
        mounted() {
            setTimeout(() => {
                document.querySelectorAll('div.documentation-content pre code').forEach((block) => {
                    highlightjs.highlightBlock(block);
                });
            }, 500)
        },
        methods: {
            // content() {
            //     // return Vue.compile(this.content);
            //     return this.content
            // }
        }
    }
</script>

<style scoped>

</style>