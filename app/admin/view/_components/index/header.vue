<template>
  <el-header class="app-el-header">
    <div>
      <!-- 边栏切换按钮-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">{:__('Toggle navigation')}</span>
      </a>
    </div>

    <div>
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
    </div>
  </el-header>
</template>

<script>
module.exports = {
  data() {
    return {};
  },
};
</script>

<style lang="css" scoped>
.app-el-header {
  background-color: #fff;
  color: #333;
  line-height: 60px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>
