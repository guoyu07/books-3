<template>
    <div class="chapter">
        <div class="chapters">
            <div class="pure-g chap-item" v-for="(chapter, index) in chapters" @click="$router.push({name:'reader', params: {book_id:'53855a750ac0b3a41e00c7e6',chap_index:index}})">
                <icon class="chap-logo" :name="'dot'" :color="'#c7c7c9'"></icon>
                <div class="chap-title pure-u-5-6">
                    <span>{{chapters.length - index - 1}}.</span>
                    {{chapter.title}}
                </div>
                <icon class="chap-logo" :name="'forward'" :color="'#c7c7c9'"></icon>
            </div>
        </div>
        <div class="book-title">{{title}}</div>
        <div class="operation-bar pure-g">
            <a class="pure-u-1-2 border-line" href="javascript:scroll(0,0)">到顶部</a>
            <div class="pure-u-1-2">关闭</div>
        </div>
    </div>
</template>
<style scoped>
    .chapter { background: #d9d9d9; }
    .chap-item { display: flex; align-items: center; }
    .chap-title { border-bottom: 1px dotted #8d8d8d; padding: .6em 0; color: #575757; font-size: 1em; }
    .chap-title span { font-size: .7em; color: #757575; }
    .chap-logo { width: 8.3% !important; }
    .book-title { position: fixed; bottom: 3em; right: .7em; width: 1em;font-size: 1em; color: #fff; font-family: "KaiTi";  }
    .operation-bar { background: #3e4f5c; height: 3em; line-height: 3em; font-size:.9em; width: 100%; position: fixed; bottom: 0; color: #fff; text-align: center; }
    .operation-bar a { color: #fff; text-decoration: none;  }
    .border-line { border-right: 1px solid #fff; }
</style>
<script>
    module.exports = {
        props      : [],
        data () {
            return {
                chapters : [],
                title    : ''
            }
        },
        components : {
        },
        beforeCreate () {
            var self = this;
            self.$http.get('/api/source/chapter?book_id=' + self.$route.params.book_id).then(function(res) {
                var data = res.data;
                if(typeof data == 'string') {
                    data = JSON.parse(res.data);
                } else {
                    data = res.data;
                }
                if(data.code == 200) {
                    self.chapters = data.data.chapters;
                    self.title = data.data.title;
                } else {
                    alert(data.msg);
                }
            })
        },
        created () {
            var self = this;
        },
        methods    : {
        }
    };
</script>
