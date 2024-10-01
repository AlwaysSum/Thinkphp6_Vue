<template>
  <t-header>
    <t-head-menu
      mode="tile"
      theme="light"
      active="item2"
      expandType="popup"
      height="60px"
    >
      <img
        slot="logo"
        width="136"
        class="t-menu__logo--center"
        src="https://www.tencent.com/img/index/menu_logo_hover.png"
        alt="logo"
      />
      <t-menu-item name="item1">菜单内容一</t-menu-item>
      <t-menu-item name="item2">已选内容</t-menu-item>
      <t-menu-item name="item3">菜单内容二</t-menu-item>
      <t-menu-item name="item4" :disabled="true">菜单内容三</t-menu-item>
    </t-head-menu>
  </t-header>
</template>

<script>
module.exports = {
  data() {
    return {};
  },
};
</script>

<style lang="css" scoped>
.app-index-header {
  background-color: #fff;
  color: #333;
  line-height: 60px;
}
</style>
