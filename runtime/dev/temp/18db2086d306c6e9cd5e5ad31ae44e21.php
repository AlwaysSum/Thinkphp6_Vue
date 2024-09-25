<?php /*a:2:{s:88:"/Users/sunflower816/PhpstormProjects/fast_admin_vue_tp6/app/dev/view/_layout/index3.html";i:1727280652;s:86:"/Users/sunflower816/PhpstormProjects/fast_admin_vue_tp6/app/dev/view/_public/_CSS.html";i:1726764677;}*/ ?>
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

    <script
      type="text/javascript"
      src="/dev/plugins/vue3/vue.global.prod.js"
    ></script>
    <script
      type="text/javascript"
      src="/dev/plugins/vue3/vue3-sfc-loader.js"
    ></script>
  </head>
  <body>
    <!--内容前的初始化-->
    <script>
      const allComponents = JSON.parse(`<?php echo json_encode(initVueComponents()); ?>`);
    </script>
    <main>
      <!--   模版内容-->
      <div id="app">
        <div>{{ message }}</div>
        <my-app></my-app>
      </div>

      <script>
        // 声明一个vue的url映射表
        const appVueUrlMap = {
          "app.vue": "<?php echo htmlentities($__APP_URL__); ?>",
        };

        // 加载远程Vue的配置
        const options = {
          moduleCache: {
            vue: Vue,
          },
          async getFile(vueUrl) {
            const url = appVueUrlMap[vueUrl];
            const res = await fetch(url, {
              headers: {
                vue: true,
              },
            });
            if (!res.ok)
              throw Object.assign(new Error(res.statusText + " " + url), {
                res,
              });
            return {
              getContentData: (asBinary) =>
                asBinary ? res.arrayBuffer() : res.text(),
            };
          },
          addStyle(textContent) {
            const style = Object.assign(document.createElement("style"), {
              textContent,
            });
            const ref = document.head.getElementsByTagName("style")[0] || null;
            document.head.insertBefore(style, ref);
          },
        };

        const { loadModule } = window["vue3-sfc-loader"];
        const { createApp, ref } = Vue;
        createApp({
          components: {
            "my-app": Vue.defineAsyncComponent(() =>
              loadModule("app.vue", options)
            ),
          },
          setup() {
            const message = ref("Hello vue!");
            return {
              message,
            };
          },
        }).mount("#app");
      </script>
    </main>
  </body>
</html>
