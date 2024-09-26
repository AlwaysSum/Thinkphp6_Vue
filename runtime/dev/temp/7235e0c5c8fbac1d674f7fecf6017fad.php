<?php /*a:4:{s:87:"/Users/sunflower816/PhpstormProjects/fast_admin_vue_tp6/app/dev/view/_layout/index.html";i:1727364298;s:86:"/Users/sunflower816/PhpstormProjects/fast_admin_vue_tp6/app/dev/view/_public/_CSS.html";i:1726764677;s:85:"/Users/sunflower816/PhpstormProjects/fast_admin_vue_tp6/app/dev/view/_public/_JS.html";i:1727364310;s:89:"/Users/sunflower816/PhpstormProjects/fast_admin_vue_tp6/app/dev/view/_layout/default.html";i:1727363461;}*/ ?>
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
<script type="text/javascript" src="/dev/plugins/vue/sass.js"></script>
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
    <script>
      const allComponents = JSON.parse(`<?php echo json_encode(initVueComponents()); ?>`);

      initVue2();

      function initVue2() {
        // 支持scss
        httpVueLoader.langProcessor.scss = function (scssText) {
          return new Promise(function (resolve, reject) {
            sass.compile(scssText, function (result) {
              if (result.status === 0) resolve(result.text);
              else reject(result);
            });
          });
        };
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
    <!--    模版内容-->
    <div id="app">
  <el-container class="app-el-container" direction="vertical">
    <el-header class="el-header" height="">
      <!-- Header content -->
      <el-dropdown>
        <i class="el-icon-setting" style="margin-right: 15px"></i>
        <el-dropdown-menu slot="dropdown">
          <el-dropdown-item>查看</el-dropdown-item>
          <el-dropdown-item>新增</el-dropdown-item>
          <el-dropdown-item>删除</el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
      <span>王小虎</span>
    </el-header>
    <el-container class="app-body" direction="horizontal">
      <el-aside class="app-el-aside" width="200px">
        <!-- Aside content -->
        <el-menu :default-openeds="['1', '3']">
          <el-submenu index="1">
            <template slot="title"
              ><i class="el-icon-message"></i>导航一</template
            >
            <el-menu-item-group>
              <template slot="title">分组一</template>
              <el-menu-item index="1-1">选项1</el-menu-item>
              <el-menu-item index="1-2">选项2</el-menu-item>
            </el-menu-item-group>
            <el-menu-item-group title="分组2">
              <el-menu-item index="1-3">选项3</el-menu-item>
            </el-menu-item-group>
            <el-submenu index="1-4">
              <template slot="title">选项4</template>
              <el-menu-item index="1-4-1">选项4-1</el-menu-item>
            </el-submenu>
          </el-submenu>
          <el-submenu index="2">
            <template slot="title"><i class="el-icon-menu"></i>导航二</template>
            <el-menu-item-group>
              <template slot="title">分组一</template>
              <el-menu-item index="2-1">选项1</el-menu-item>
              <el-menu-item index="2-2">选项2</el-menu-item>
            </el-menu-item-group>
            <el-menu-item-group title="分组2">
              <el-menu-item index="2-3">选项3</el-menu-item>
            </el-menu-item-group>
            <el-submenu index="2-4">
              <template slot="title">选项4</template>
              <el-menu-item index="2-4-1">选项4-1</el-menu-item>
            </el-submenu>
          </el-submenu>
          <el-submenu index="3">
            <template slot="title"
              ><i class="el-icon-setting"></i>导航三</template
            >
            <el-menu-item-group>
              <template slot="title">分组一</template>
              <el-menu-item index="3-1">选项1</el-menu-item>
              <el-menu-item index="3-2">选项2</el-menu-item>
            </el-menu-item-group>
            <el-menu-item-group title="分组2">
              <el-menu-item index="3-3">选项3</el-menu-item>
            </el-menu-item-group>
            <el-submenu index="3-4">
              <template slot="title">选项4</template>
              <el-menu-item index="3-4-1">选项4-1</el-menu-item>
            </el-submenu>
          </el-submenu>
        </el-menu>
      </el-aside>
      <el-container direction="vertical">
        <el-main height="">
          <!-- Main content -->
          <app></app>
        </el-main>
        <el-footer height="">
          <!-- Footer content -->
        </el-footer>
      </el-container>
    </el-container>
  </el-container>
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
  html {
    height: 100vh;
  }
  body {
    background: #f6f8f9;
    margin: 0px;
    height: 100%;
  }

  #app {
    height: 100%;
  }

  .app-el-container {
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .app-body {
    height: calc(100% - 60px);
  }

  .el-header {
    background-color: #fff;
    color: #333;
    line-height: 60px;
  }

  .app-el-aside {
    color: #333;
    background-color: #f5f5f5;
  }
</style>

  </body>
</html>
