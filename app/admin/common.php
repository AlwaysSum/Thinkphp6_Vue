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
            ['name' => 'vue-label', 'path' => vueComponentsUrl('mgc', 'label')],
            ['name' => 'vue-table', 'path' => vueComponentsUrl('mgc', 'table')],
            //自定义的学校操作工具栏
            ['name' => 'school-toolbar', 'path' => vueComponentsUrl('school', 'toolbar')],
            //header
            ['name' => 'school-header-bar', 'path' => vueComponentsUrl('school', 'headerBar')]
        ];
    }
}
