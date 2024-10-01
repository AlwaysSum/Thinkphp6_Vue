<?php

/**
 * 返回一个vue的组件地址
 */
if (!function_exists('vueComponentsUrl')) {
    function vueComponentsUrl($module, $name)
    {
        return (string)url('components/publicComponents', [
            'module' => $module,
            'name' => $name,
        ], false);
    }
}

/**
 * 初始化的vue组件方法
 */
if (!function_exists('initVueComponents')) {
    /**
     * 获取一个封装的的vue组件
     * @param string $path 指定的path
     * @return array
     */
    function initVueComponents()
    {
        return [
            //标题栏
            ['name' => 'vue-label', 'path' => vueComponentsUrl('_components/mgc', 'label')],
            ['name' => 'vue-table', 'path' => vueComponentsUrl('_components/mgc', 'table')],
        ];
    }
}
