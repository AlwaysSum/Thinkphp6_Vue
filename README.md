项目基本说明

一款在 Tinkphp 中使用 Vue 进行开发的项目

===============

> 环境

运行环境 z 要求 PHP7.4+。
开发环境 ThinkPHP 6.0,多应用模式

---

> 1、开发

- 使用项目外面的.env 配置自己的本地环境，如本地 database 等
- 数据库使用 mysql

---

> 1、返回一个 Vue 页面

```php

    public function index()
    {
        return $this->vuePage();
    }
```

```html
<div id="app">
  <div class="el-card" style="margin: 20px" @click="onAdd()">
    测试页面 {{msg}} 你好啊
  </div>
  <vue-label :title="msg"></vue-label>
</div>

<script>
  const app = new Vue({
    el: "#app",
    data() {
      return {
        msg: 1,
      };
    },
    methods: {
      onAdd() {
        this.msg++;
      },
    },
  });
</script>

<style scoped>
  body {
    background: #f6f8f9;
    margin: 0px;
  }

  .main-body {
    width: 100%;
    height: calc(100vh - 100px);
    position: relative;
  }

  .iframe-component {
    width: 100%;
    height: 100%;
    overflow: auto;
    border: none;
  }
</style>
```
2、配置组件，默认公用组件放在 `view/_components`目录下
common.php ，initVueComponents 函数中进行声明全局的组件
```php 
 /**
     * 获取一个封装的的vue组件
     * @param string $path 指定的path
     * @return array
     */
    function initVueComponents()
    {
        return [
            //标题栏
            ['name' => 'vue-label', 'path' => vueComponentsUrl('mgc', 'label')],
            ['name' => 'vue-table', 'path' => vueComponentsUrl('mgc', 'table')],
            //自定义的学校操作工具栏
            ['name' => 'school-toolbar', 'path' => vueComponentsUrl('school', 'toolbar')],
            //header
            ['name' => 'school-header-bar', 'path' => vueComponentsUrl('school', 'headerBar')]
        ];
    }
```

声明vue一个组件，和普通的区别在于，通过`module.exports `到处 而不是`export default` 导出。
```js
<template>
    <div class="mgc-label">
        <div class="left">
            <div class="line" :style="bg?'background: '+bg:''"></div>
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
```


3、局部使用其他的组件,通过：url:远程地址，来关联一个远程组件。

```js
const vue = new Vue({
  el: "#app",
  components: { "add-form": "url:__VUE__/form/form-default.vue" },
});
```

4、一些变量的指向
view.php 中进行配置，路径相对于public目录
```php
 'tpl_replace_string' => [
        '__STATIC__' => '/dev',
        '__JS__' => '/dev/js',
        '__PLUGINS__' => '/dev/plugins',
        '__CSS__' => '/dev/css',
        '__IMG__' => '/dev/image',
        '__VUE__' => '/dev/vue'
 ],
```
