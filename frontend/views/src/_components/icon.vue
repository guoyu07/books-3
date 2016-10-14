<template>
    <i class="icon" :class="name">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 0 1040 1040"
             width="100%"
             height="100%">
            <path :fill="color" :d="icons[name]">
        </svg>
    </i>
</template>

<style scoped>
    .icon { position : relative; display : inline-block; vertical-align : top; width : 24px; height : 24px; overflow : hidden; }
    .icon > svg { display : block; }
</style>

<script>
    module.exports = {
        replace : true,
        props   : {
            name  : {
                type     : String,
                required : true
            },
            color : {
                type    : String,
                default : '#666'
            }
        },
        data    : function() {
            return {
                icons : {
                    'dot' : 'M704 460.8m-108.8 0a1.7 1.7 0 1 0 217.6 0 1.7 1.7 0 1 0-217.6 0Z',
                    'forward' : 'M325.632405 182.721555l55.132668-54.878888 385.9297 384.157333-385.9297 384.157333-55.132668-54.878888 330.797032-329.278445L325.632405 182.721555z'
                }
            }
        }
    }
</script>
