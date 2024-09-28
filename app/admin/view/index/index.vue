<template>
  <div class="name">
    <div>哈哈哈哈哈 这是一个也没{{ test }}</div>
  </div>
</template>

<script>
module.exports = {
  data() {
    return {
      test: "哈哈哈哈",
    };
  },
};
</script>

<style>
.name {
  background-color: red;
}
</style>
