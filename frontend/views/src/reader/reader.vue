<template>
    <div class="reader">

    </div>
</template>
<style scoped>
    .reader { background: #d9d9d9; }

</style>
<script>
    module.exports = {
        props      : [],
        data () {
            return {
            }
        },
        components : {
        },
        beforeCreate () {
            var self = this;
            var postData = {
                book_id : self.$route.params.book_id,
                chapter_index : 30,
                content_url : ''
            };
            self.$http.post('/api/source/chapter', postData).then(function(res) {
                var data = res.data;
                if(typeof data == 'string') {
                    data = JSON.parse(res.data);
                } else {
                    data = res.data;
                }
                console.log(data);
//                if(data.code == 200) {
//                    self.chapters = data.data.chapters;
//                    self.title = data.data.title;
//                } else {
//                    alert(data.msg);
//                }
            })
        },
        created () {
            var self = this;
        },
        methods    : {
        }
    };
</script>
