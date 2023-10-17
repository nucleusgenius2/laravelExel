<template>
    <span class="wrap-close">
        <span class="close"></span>
    </span>
</template>

<script>
export default {
    name: "RemoveButton.vue"
}
</script>

<style scoped>
.close {
    position: absolute;
    right: 0px;
    top: 0px;
    width: 15px;
    height: 15px;
    cursor: pointer;
}
.close:hover:before, .close:hover.close:after {
    background-color:#be0926;
}
.close:before, .close:after {
    position: absolute;
    left: 7px;
    content: ' ';
    height:15px;
    width: 2px;
    background-color: #333;
}
.close:before {
    transform: rotate(45deg);
}
.close:after {
    transform: rotate(-45deg);
}
.wrap-close {
    position: relative;
}
</style>
