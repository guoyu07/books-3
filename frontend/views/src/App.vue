<template>
    <div id="app">
        <img class="logo" src="./assets/logo.png">
        <hello></hello>
        <p>
            Welcome to your Vue.js app1111!
        </p>
        <p>
            To get a better understanding of how this boilerplate works, check out
            <a href="http://vuejs-templates.github.io/webpack" target="_blank">its documentation</a>.
            It is also recommended to go through the docs for
            <a href="http://webpack.github.io/" target="_blank">Webpack</a> and
            <a href="http://vuejs.github.io/vue-loader/" target="_blank">vue-loader</a>.
            If you have any issues with the setup, please file an issue at this boilerplate's
            <a href="https://github.com/vuejs-templates/webpack" target="_blank">repository</a>.
        </p>
        <p>
            You may also want to checkout
            <a href="https://github.com/vuejs/vue-router/" target="_blank">vue-router</a> for routing and
            <a href="https://github.com/vuejs/vuex/" target="_blank">vuex</a> for state management.
        </p>
    </div>
</template>

<script>
    import Hello from './components/Hello'

    module.exports = {
        data       : function() {
            return {
                book : {}
            }
        },
        components : {
            Hello
        },
        created   : function() {
            var self = this;
            console.log('__________complied');
            self.initList();
        },
        methods    : {
            initList : function() {
                var self = this;
                self.$http.get('/book/53855a750ac0b3a41e00c7e6').then(function(res) {
                    console.log(JSON.parse(JSON.stringify(res.data)));
                    self.book = res.data;
                })
            }
        }
    };

//    export default {
//        complied : function() {
//            console.log("11");
//        },
//        components : {
//            Hello
//        }
//    }
</script>

<style>
    html {
        height : 100%;
    }
    body {
        display         : flex;
        align-items     : center;
        justify-content : center;
        height          : 100%;
    }
    #app {
        color       : #2c3e50;
        margin-top  : -100px;
        max-width   : 600px;
        font-family : Source Sans Pro, Helvetica, sans-serif;
        text-align  : center;
    }
    #app a {
        color           : #42b983;
        text-decoration : none;
    }
    .logo {
        width  : 100px;
        height : 100px
    }
</style>
