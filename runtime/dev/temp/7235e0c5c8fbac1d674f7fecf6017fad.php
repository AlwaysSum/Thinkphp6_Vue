<?php /*a:3:{s:87:"/Users/sunflower816/PhpstormProjects/fast_admin_vue_tp6/app/dev/view/_layout/index.html";i:1727281069;s:86:"/Users/sunflower816/PhpstormProjects/fast_admin_vue_tp6/app/dev/view/_public/_CSS.html";i:1726764677;s:85:"/Users/sunflower816/PhpstormProjects/fast_admin_vue_tp6/app/dev/view/_public/_JS.html";i:1727281237;}*/ ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>后台管理系统</title>
    <meta
      content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
      name="viewport"
    />
    <!--一些基本的配置参数-->
    <script type="text/javascript">
      const vueConfig = JSON.parse(`<?php echo json_encode($vueConfig); ?>`);
    </script>
    <!--    css-->
    <!--    引入的js和css-->
    <!--引入相关依赖-->
<?php foreach($vueConfig['_PLUGINS_CSS'] as $k=>$v): ?>
<!--引入<?php echo htmlentities($v['name']); ?> -->
<link rel="stylesheet" type="text/css" href="/dev/<?php echo htmlentities($v['path']); ?>"></link>
<?php endforeach; ?>
    <!--   引入的JS -->
    <!--@必要的引入-->
<!--引入vue-->
<script type="text/javascript" src="/dev/plugins/vue/vue.min.js"></script>

<!--HttpVueLoader-->
<script type="text/javascript" src="/dev/plugins/vue/httpVueLoader.js"></script>
<!--axios-->
<script type="text/javascript" src="/dev/plugins/axios/axios.min.js"></script>
<script type="text/javascript" src="/dev/js/axios-base.js"></script>

<!--@引入其他的相关依赖-->
<?php foreach($vueConfig['_PLUGINS_JS'] as $k=>$v): ?>
<!--引入<?php echo htmlentities($v['name']); ?> -->
<script type="text/javascript" src="/dev/<?php echo htmlentities($v['path']); ?>"></script>
<?php endforeach; ?>

  </head>
  <body>
    <!--内容前的初始化-->
    <script >
      const allComponents = JSON.parse(`<?php echo json_encode(initVueComponents()); ?>`);

      initVue2();

      function initVue2() {
        //vue的跨组件引用
        Vue.use(httpVueLoader);
        Vue.prototype.request = $axios;
        //vue的公用组件配置
        for (const component of allComponents) {
          try {
            Vue.component(component.name, `url:${component.path}`);
          } catch (error) {
            console.error(error);
          }
        }
      }
    </script>
    <main>
      <!--    模版内容-->

      <div id="app">
        <div class="el-card" style="margin: 20px" @click="onAdd()">
          测试页面 {{msg}} 你好啊 <?php echo htmlentities($__APP_URL__); ?>

          <div class="name">1111</div>
        </div>
        <vue-label :title="msg"></vue-label>
        <!-- 应用页面 -->
        <app></app>
      </div>

      <script>
        const app = new Vue({
          el: "#app",
          components: {
            app: `url:<?php echo htmlentities($__APP_URL__); ?>`,
          },
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
    </main>
  </body>
</html>
