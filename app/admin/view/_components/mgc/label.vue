<template>
    <div class="mgc-label">
        <div class="left">
            <div class="line" :style="bg != null?'background: '+bg:''"></div>
            <span class="title">{{title}}</span>
        </div>
        <div>
            <span class="desc">{{rightDesc}}</span>
        </div>
    </div>
</template>

<script>
    module.exports = {
        props: ['title', 'rightDesc', 'bg'],
        data() {
            return {}
        }
    }
</script>

<style scoped>

    .mgc-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 5px;
    }


    .mgc-label .left {
        display: inline-flex;
        justify-content: center;
        align-items: center;
    }


    .mgc-label .left .line {
        width: 10px;
        height: 18px;
        background: #43cea2;
        margin-right: 5px;
        border-radius: 5px;
    }

    .mgc-label .left .title {
        color: #333;
        font-size: large;
    }


    .mgc-label .desc {
        color: #999;
    }

    .color-desc {
        color: #999;
    }

    .color-title {
        color: #333;
    }
</style>