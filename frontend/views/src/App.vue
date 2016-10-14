<template>
    <div id="app">
        <router-view></router-view>
    </div>
</template>
<style>
    *,
    *::before,
    *::after {
        margin                      : 0;
        padding                     : 0;
        box-sizing                  : border-box;
        -webkit-tap-highlight-color : rgba(0, 0, 0, 0);
    }
    html, body {
        height                 : 100%;
        line-height            : 1.3;
        color                  : #333;
        font-family            : FreeSans, Arimo, "Droid Sans", Helvetica, Arial, sans-serif;
        -webkit-font-smoothing : antialiased;
        text-rendering         : optimizeLegibility;
    }
    html .pure-g [class *="pure-u"] {
        font-family : FreeSans, Arimo, "Droid Sans", Helvetica, Arial, sans-serif;
    }
    ul, ol { list-style : none; }
    em { font-style : normal; }
    .card-shadow { box-shadow : 0 3px 8px -3px rgba(0, 0, 0, .5); }
    /*1em = 16px 1rem = 16px*/
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
    function pad(n) {
        return n < 10 ? '0' + n : n
    }

    Date.prototype.format = function(safari) {
        var split = !!safari ? '/' : '-';
        return this.getFullYear() + split
               + pad(this.getMonth() + 1) + split
               + pad(this.getDate()) + ' '
               + pad(this.getHours()) + ':'
               + pad(this.getMinutes()) + ':'
               + pad(this.getSeconds());
    };

    Date.prototype.getDateStr = function(safari) {
        var split = !!safari ? '/' : '-';
        return this.getFullYear() + split
               + pad(this.getMonth() + 1) + split
               + pad(this.getDate());
    };

    Date.prototype.addHours = function(h) {
        this.setHours(this.getHours() + h);
        return this;
    };

    Date.prototype.addMinutes = function(m) {
        this.setMinutes(this.getMinutes() + m);
        return this;
    };

    Date.prototype.addDays = function(d) {
        this.setDate(this.getDate() + d);
        return this;
    };

    Date.prototype.addWeeks = function(w) {
        this.addDays(w * 7);
        return this;
    };

    Date.prototype.addMonths = function(m) {
        var d = this.getDate();
        this.setMonth(this.getMonth() + m);
        if(this.getDate() < d) {
            this.setDate(0);
        }
        return this;
    };

    Date.prototype.addYears = function(y) {
        var m = this.getMonth();
        this.setFullYear(this.getFullYear() + y);

        if(m < this.getMonth()) {
            this.setDate(0);
        }
        return this;
    };
</script>
