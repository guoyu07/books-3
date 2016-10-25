<template>
    <div class="home">
        <section class="tab-header pure-g">
            <div class="tab-item pure-u-1-2" :class="{'chosen-tab' : current_tab == 'book-list'}" @click="current_tab = 'book-list'">书架</div>
            <div class="tab-item pure-u-1-2" :class="{'chosen-tab' : current_tab == 'more'}" @click="current_tab = 'more'">列表</div>
        </section>
        <keep-alive>
            <component :is="current_tab"></component>
        </keep-alive>
    </div>
</template>
<style scoped>
    .tab-header { background: #3d4f5c; }
    .tab-item { text-align: center; color: #fff; height: 3em; line-height :3em; font-size: 1em; border-bottom : .2em solid #3d4f5c ; }
    .chosen-tab { color : #b1cada; border-bottom: .2em solid #b1cada; }
</style>
<script>
    module.exports = {
        data () {
            return {
                current_tab : 'book-list'
            }
        },
        components : {
            'book-list' : require('./_components/book_list.vue'),
            'more' : require('./_components/more.vue')
        },
        created () {
            var self = this;
        },
        methods    : {

        }
    };
</script>
