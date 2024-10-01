<template>
  <div class="login-wrapper light">
    <!-- 头部 -->
    <header class="login-header">
      <logo-full-icon class="logo" />
      <div class="operations-container">
        <t-button
          theme="default"
          shape="square"
          variant="text"
          @click="navToGitHub"
        >
          <logo-github-icon class="icon" />
        </t-button>
        <t-button
          theme="default"
          shape="square"
          variant="text"
          @click="navToHelper"
        >
          <help-circle-icon class="icon" />
        </t-button>
      </div>
    </header>

    <!-- 内容 -->
    <div class="login-container">
      <div class="title-container">
        <h1 class="title margin-no">登录到</h1>
        <h1 class="title">FastAdmin Vue TDesign</h1>
      </div>

      <!-- 内容 -->
      <t-form
        ref="form"
        :class="['item-container', `login-${type}`]"
        :data="formData"
        :rules="rules"
        label-width="0"
        @submit="onSubmit"
      >
        <template v-if="type == 'password'">
          <t-form-item name="username">
            <t-input
              v-model="formData.username"
              size="large"
              placeholder="请输入账号：admin"
            >
              <template #prefix-icon>
                <user-icon />
              </template>
            </t-input>
          </t-form-item>

          <t-form-item name="password">
            <t-input
              v-model="formData.password"
              size="large"
              :type="showPsw ? 'text' : 'password'"
              clearable
              key="password"
              placeholder="请输入登录密码：admin"
            >
              <template #prefix-icon>
                <lock-on-icon />
              </template>
              <template #suffix-icon>
                <browse-icon
                  v-if="showPsw"
                  @click="showPsw = !showPsw"
                  key="browse"
                />
                <browse-off-icon
                  v-else
                  @click="showPsw = !showPsw"
                  key="browse-off"
                />
              </template>
            </t-input>
          </t-form-item>

          <div class="check-container remember-pwd">
            <t-checkbox>记住账号</t-checkbox>
            <span class="tip">忘记账号？</span>
          </div>
        </template>

        <t-form-item v-if="type !== 'qrcode'" class="btn-container">
          <t-button block size="large" type="submit"> 登录 </t-button>
        </t-form-item>
      </t-form>
    </div>

    <footer class="copyright">
      Copyright @ 2021-2022 Tencent. All Rights Reserved
    </footer>
  </div>
</template>
<script>
module.exports = {
  data() {
    return {
      type: "password",
      formData: {
        username: "",
        password: "",
        __token__: "{:token()}",
      },
      showPsw: false,
      rules: {
        username: [
          { required: true, message: "请输入用户名", trigger: "blur" },
          {
            min: 3,
            max: 20,
            message: "长度在 3 到 20 个字符",
            trigger: "blur",
          },
        ],
        password: [
          { required: true, message: "请输入密码", trigger: "blur" },
          {
            min: 6,
            max: 20,
            message: "长度在 6 到 20 个字符",
            trigger: "blur",
          },
        ],
      },
    };
  },
  created() {
    var lastlogin = localStorage.getItem("lastlogin");
    if (lastlogin) {
      lastlogin = JSON.parse(lastlogin);
      this.loginForm.username = lastlogin.username;
    }
  },
  methods: {
    navToGitHub() {
      window.open("https://github.com/Tencent/tdesign-vue-starter");
    },
    navToHelper() {
      window.open("https://tdesign.tencent.com/starter/docs/get-started");
    },
    onSubmit(data) {
      if (data.validateResult === true) {
        // 这里可以添加登录逻辑
        $axios
          .post("/index/login", this.formData)
          .then((res) => {
            console.log("请求登陆:", res);
            this.$message.success("登录成功");
            //跳转页面
            localStorage.setItem(
              "lastlogin",
              JSON.stringify({
                id: res.data.id,
                username: res.data.username,
                avatar: res.data.avatar,
              })
            );
            location.href = this.$utils.fixurl(res.data.url);
          })
          .catch((e) => {
            console.log(e);
            this.loginForm.__token__ = e.data.token;
            this.$message.error(e.msg);
          });
      }
    },
  },
};
</script>

<style scoped>
/** 公共前缀 */
.light.login-wrapper {
  background-color: white;
  background-image: url("__IMG__/assets-login-bg-white.png");
}
.dark.login-wrapper {
  background-color: var(--td-bg-color-page);
  background-image: url("__IMG__/assets-login-bg-black.png");
}
.login-wrapper {
  height: 100vh;
  display: flex;
  flex-direction: column;
  background-size: cover;
  background-position: 100%;
  position: relative;
}
.login-container {
  position: absolute;
  top: 22%;
  left: 5%;
  min-height: 500px;
  line-height: 22px;
}
.title-container .title {
  font-size: 36px;
  line-height: 44px;
  color: var(--td-text-color-primary);
  margin-top: 4px;
}
.title-container .title.margin-no {
  margin-top: 0;
}
.title-container .sub-title {
  margin-top: 16px;
}
.title-container .sub-title .tip {
  display: inline-block;
  margin-right: 8px;
  font-size: 14px;
}
.title-container .sub-title .tip:first-child {
  color: var(--td-text-color-secondary);
}
.title-container .sub-title .tip:last-child {
  color: var(--td-text-color-primary);
  cursor: pointer;
}
.item-container {
  width: 400px;
  margin-top: 48px;
}
.item-container.login-qrcode .tip-container {
  width: 192px;
  margin-bottom: 16px;
  font-size: 14px;
  display: flex;
  justify-content: space-between;
}
.item-container.login-qrcode .tip-container .tip {
  color: var(--td-text-color-primary);
}
.item-container.login-qrcode .tip-container .refresh {
  display: flex;
  align-items: center;
  color: var(--td-brand-color);
}
.item-container.login-qrcode .tip-container .refresh .t-icon {
  font-size: 14px;
}
.item-container.login-qrcode .tip-container .refresh:hover {
  cursor: pointer;
}
.item-container.login-qrcode .bottom-container {
  margin-top: 32px;
}
.item-container.login-phone .bottom-container {
  margin-top: 66px;
}
.item-container .check-container {
  display: flex;
  align-items: center;
}
.item-container .check-container.remember-pwd {
  margin-bottom: 16px;
  justify-content: space-between;
}
.item-container .check-container .t-checkbox__label {
  color: var(--td-text-color-secondary);
}
.item-container .check-container span {
  color: var(--td-brand-color);
}
.item-container .check-container span:hover {
  cursor: pointer;
}
.item-container .verification-code {
  display: flex;
  align-items: center;
}
.item-container .verification-code .t-form__controls {
  width: 100%;
}
.item-container .verification-code .t-form__controls button {
  flex-shrink: 0;
  width: 102px;
  height: 40px;
  margin-left: 11px;
}
.item-container .btn-container {
  margin-top: 48px;
}
.switch-container {
  margin-top: 24px;
}
.switch-container .tip {
  font-size: 14px;
  color: var(--td-brand-color);
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  margin-right: 14px;
}
.switch-container .tip:last-child::after {
  display: none;
}
.switch-container .tip::after {
  content: "";
  display: block;
  width: 1px;
  height: 12px;
  background: var(--td-gray-color-3);
  margin-left: 14px;
}
.check-container {
  font-size: 14px;
  color: var(--td-text-color-secondary);
}
.check-container .tip {
  float: right;
  font-size: 14px;
  color: var(--td-brand-color);
}
.copyright {
  font-size: 14px;
  position: absolute;
  left: 5%;
  bottom: var(--td-comp-size-xxxl);
  color: var(--td-text-color-secondary);
}
@media screen and (max-height: 700px) {
  .copyright {
    display: none;
  }
}

/* header */
.login-header[data-v-1e452055] {
  height: var(--td-comp-size-xxxl);
  padding: 0 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  backdrop-filter: blur(5px);
  color: var(--td-text-color-primary);
}
.login-header .logo[data-v-1e452055] {
  width: 188px;
  height: var(--td-comp-size-xxxl);
}
.login-header .operations-container[data-v-1e452055] {
  display: flex;
  align-items: center;
}
.login-header .operations-container .t-button[data-v-1e452055] {
  margin-left: 16px;
}
.login-header .operations-container .icon[data-v-1e452055] {
  height: 20px;
  width: 20px;
  padding: 6px;
  box-sizing: content-box;
}
.login-header .operations-container .icon[data-v-1e452055]:hover {
  cursor: pointer;
}
</style>
