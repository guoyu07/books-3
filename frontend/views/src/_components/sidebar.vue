<template>
    <div class="sidebar">
        <div class="header">
            <h1 class="title">A Sample Website</h1>
            <h2 class="brief">Creating something beautiful </h2>
        </div>
    </div>
</template>
<style scoped>
    .sidebar { background : #3e4f5c; color : #fff; }
    .header { text-align : center; margin : 1em auto; }
    .title { text-transform : uppercase; margin : 0; display: none; }
    .brief { color : #b1cada; }
    @media (min-width : 48em) {
        .sidebar { position : fixed; top : 0; bottom : 0; }
        .header { text-align : right; margin : 80% 1em; }
        .title { display: block; }
    }
</style>
<script>
    module.exports = {
        data () {
            return {}
        },
        components : {},
        created () {
            var self = this;
        },
        methods    : {}
    };
</script>
