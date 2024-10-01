<template>
  <el-container class="app-el-container" direction="vertical">
    <!-- 菜单组件 -->
    <el-aside class="app-el-aside" width="250px">
      <!-- Aside content -->
      <el-menu
        :mode="menuModel"
        :collapse="menuIsOpen"
        :default-active="defaultPage.id"
        background-color="#202a2f"
        text-color="#fff"
        active-text-color="#43cea2"
      >
        <template v-for="(menu, index) in menus" :key="menu.id">
          <el-menu-item
            v-if="!menu.childs || menu.childs.length == 0"
            @click="clickMenus(menu)"
            :index="menu.id"
          >
            <i :class="menu.icon"></i>
            <span slot="title">{{ menu.title }}</span>
          </el-menu-item>

          <nav-bar-item
            v-else
            :menu="menu"
            @clickurl="clickMenus"
          ></nav-bar-item>
        </template>
      </el-menu>
    </el-aside>

    <el-container class="app-body">
      <!-- 头部组件 -->
      <header-view></header-view>
      <!-- 页面内容 -->
      <div class="main-body">
        <!-- Main content -->
        {if preg_match('/\/fast\/|admin/i', url('index/index'))}
        <el-alert
          title="温馨提示"
          type="info"
          effect="light"
          show-icon
          closable
        >
          {:__('Security tips')}
        </el-alert>
        {/if}

        <iframe
          ref="main-frame"
          :src="decodeURIComponent(currentPage.url)"
          id="main-frame"
          name="main-frame"
          style="overflow: visible"
          frameborder="0"
          scrolling="yes"
          onload="window.parent"
        ></iframe>
        <el-footer height="">
          <!-- Footer content -->
        </el-footer>
      </div>
    </el-container>
  </el-container>
</template>

<!-- JS -->
<script>
/** 列表项组件 ： 用于递归显示 */
const navBarItem = {
  props: ["menu"],
  template: `
            <el-submenu :index="menu.id">
                <template slot="title">
                    <i :class="menu.icon"></i>
                    <span slot="title">{{menu.title}}</span>
                </template>
                <template v-for="(m,i) in menu.childs">
                    <el-menu-item v-if="!m.childs || m.childs.length == 0" :index="m.id" @click="clickMenus(m)">
                        <i :class="m.icon"></i>
                        <span slot="title">{{m.title}}</span>
                    </el-menu-item>
                    <nav-bar-item v-else @click="clickMenus(m)" v-else :menu="m"></nav-bar-item>
                </template>
            </el-submenu>`,
  methods: {
    clickMenus(menu) {
      this.$emit("clickurl", menu);
    },
  },
};

module.exports = {
  components: {
    "nav-bar-item": navBarItem,
    "header-view": "url:{:vueComponentsUrl('_components/index','header')}",
  },
  data() {
    return {
      //搜索
      searchProps: {
        value: "url",
        label: "title",
        children: "childs",
        leaf: "childs",
        expandTrigger: "hover",
      },
      // 菜单属性
      menuModel: "vertical",
      menuIsOpen: false,
      menus: JSON.parse(`{:json_encode($menulist)}`),
      currentPage: {
        id: "",
        url: "",
        name: "欢迎界面",
        title: "title",
      },
      defaultPage: {
        id: "",
        url: "",
        name: "欢迎界面",
        title: "title",
      },
    };
  },
  methods: {
    /** 点击按钮 */
    clickMenus(menu) {
      this.currentPage = {
        id: menu.id,
        url: menu.url,
        name: menu.name,
        title: menu.title,
      };
      // this.addTagNav(this.currentPage);
    },
    onAdd() {},
  },
};
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
  flex-direction: row;
}

.app-body {
  height: 100%;
  display: flex;
  flex-direction: column;
}

.main-body {
  transition: width 0.25s ease, margin 0.25s ease;
  width: 100%;
  flex: 1;
  display: -webkit-flex;
  display: flex;
  -webkit-flex-direction: column;
  flex-direction: column;
}

#main-frame {
  width: 100%;
  height: 100%;
}

.app-el-aside {
  color: #333;
  background-color: #202a2f;
}
</style>
