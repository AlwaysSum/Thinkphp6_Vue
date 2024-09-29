// 创建axios
const $axios = axios.create({
  // baseURL:''
  headers: {
    "X-Requested-With": "XMLHttpRequest",
  },
});

// 添加请求拦截器
$axios.interceptors.request.use(
  function (config) {
    // 在发送请求之前做些什么
    return config;
  },
  function (error) {
    // 对请求错误做些什么
    return Promise.reject(error);
  }
);

// 添加响应拦截器
$axios.interceptors.response.use(
  function (response) {
    // 对响应数据做点什么
    console.log("res:", response);
    if (response.status == 200) {
      if (response.data.code == 1) {
        return response.data;
      } else {
        throw response.data;
      }
    } else {
      throw new Error(`${response.status}: ${response.statusText}`);
    }
  },
  function (error) {
    // 对响应错误做点什么
    return Promise.reject(error);
  }
);
