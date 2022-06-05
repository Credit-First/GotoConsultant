<template>
    <div v-show="loading" class="lds-ellipsis">
        <div v-bind:style="[spinnerStyle]"></div>
        <div v-bind:style="[spinnerStyle]"></div>
        <div v-bind:style="[spinnerStyle]"></div>
    </div>
</template>

<script>
export default {
    name: 'EllipsisLoader',
    props: {
        loading: {
            type: Boolean,
            default: true,
        },
        color: {
            type: String,
            default: '#7f58af',
        },
    },
    data() {
        return {
            spinnerStyle: {
                background: this.color,
            },
        }
    },
}
</script>

<style scoped>
.lds-ellipsis {
    display: inline-block;
    position: relative;
    width: 30px;
    height: 20px;
}
.lds-ellipsis div {
    position: absolute;
    top: 12px;
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: #fff;
    animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
.lds-ellipsis div:nth-child(1) {
    left: 0px;
    animation: lds-ellipsis1 0.6s infinite;
}
.lds-ellipsis div:nth-child(2) {
    left: 5px;
    animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(3) {
    left: 10px;
    animation: lds-ellipsis3 0.6s infinite;
}
@keyframes lds-ellipsis1 {
    0% {
        transform: scale(0);
    }
    100% {
        transform: scale(1);
    }
}
@keyframes lds-ellipsis3 {
    0% {
        transform: translate(0, 0);
    }
    100% {
        transform: translate(10px, 0);
    }
}
@keyframes lds-ellipsis2 {
    0% {
        transform: translate(0, 0);
    }
    100% {
        transform: translate(5px, 0);
    }
}
</style>