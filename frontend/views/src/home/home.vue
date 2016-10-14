<template>
    <div class="home">
        <sidebar class="pure-u-1"></sidebar>
        <section class="book-list">
            <div class="book-item" v-for="book in books" @click="$router.push({name:'chapter', params: {book_id:'53855a750ac0b3a41e00c7e6'}})">
                <img class="item-cover" :src="'http://statics.zhuishushenqi.com' + book.cover" :alt="book.title">
                <div class="item-desc">
                    <div class="item-title">{{book.title}}</div>
                    <div class="item-chap">{{solveUpdate(book)}}</div>
                </div>
            </div>
        </section>
    </div>
</template>
<style scoped>
    .book-list { padding-left: 1em; border-bottom: 1px solid #c8c8c8; }
    .book-list .book-item { padding: .7em 0; height: 4.2em; border-bottom: 1px solid #c8c8c8; }
    .book-list .book-item:last-child { border-bottom: none; }
    .book-list .item-cover { width: 2.1em; height: 2.8em; float: left; }
    .book-list .item-desc { float: left; padding-left: .9em; }
    .book-list .item-desc .item-title { font-size: .8em; }
    .book-list .item-desc .item-chap { margin-top :.6em; font-size: .7em; color: #808080 }

</style>
<script>
    module.exports = {
        props      : [],
        data () {
            return {
                books : []
            }
        },
        components : {
            'sidebar' : require('./../_components/sidebar.vue')
        },
        created () {
            var self = this;
            self.requestList();
        },
        methods    : {
            requestList () {
                var self = this;
                self.$http.get('/api/source/cover').then(function(res) {
                    if(res.data.code == 200) {
                        self.books.push(res.data.data);
                        self.books.push(JSON.parse(JSON.stringify(res.data.data)));
                    } else {
                        alert(res.data.msg);
                    }
                })
            },
            solveUpdate (book) {
                var timestamp = new Date().getTime() - Date.parse(book.updated);
                var label = '';
                if(timestamp <= 1000) {
                    label = '1秒前更新';
                } else if(timestamp <= 60000) {
                    label = '1分钟前更新';
                } else if(timestamp <= 3600000) {
                    label = Math.floor(timestamp/60000) + '分钟前更新';
                } else if(timestamp <= 86400000) {
                    label = Math.floor(timestamp/3600000) + '小时前更新';
                } else if(timestamp <= 2592000000) {
                    label = Math.floor(timestamp/86400000) + '天前更新';
                } else if(timestamp <= 946080000000) {
                    label = Math.floor(timestamp/2592000000) + '月前更新';
                } else {
                    label = Math.floor(timestamp/946080000000) + '年前更新';
                }
                return label + ':' + book.lastChapter;
            }
        }
    };
</script>
