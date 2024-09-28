<template>
    <div>
        <el-form ref="my-form" :model="data" :label-width="formConfig.formClass.labelWidth"
                 :inline="formConfig.formClass.inline" :label-position="formConfig.formClass.labelPosition">

            <el-form-item v-for="(item,index) in formConfig.items" :label="item.label" :prop="item.prop">
                <slot :name="'item_'+humpToHyphen(item.prop)" v-bind:data="data" v-bind:item="item" v-bind:index="index">

                    <!--输入框-->
                    <el-input v-if="item.type == 'input'" :type="item.option.type" v-model="data[item.prop]"></el-input>
                    <!--@数字选择-->
                    <el-input-number v-if="item.type == 'input_number'" v-model="data[item.prop]"></el-input-number>
                    <!--@选择列表-->
                    <el-select
                            v-if="item.type == 'select'" v-model="data[item.prop]"
                            :placeholder="item.option.placeholder??'请选择'">
                        <el-option v-for="(v,i) in item.option.data" :label="v.label" :value="v.value"></el-option>
                    </el-select>
                    <!--@滑块-->
                    <el-switch v-if="item.type == 'switch'" v-model="data[item.prop]"></el-switch>
                    <!--@选择时间-->
                    <el-date-picker
                            v-if="item.type == 'date'" v-model="data[item.prop]"
                            :placeholder="item.option.placeholder??'选择日期'"
                            :type="item.option.type??'date'">
                    </el-date-picker>
                    <!--@多选按钮-->
                    <el-checkbox-group v-if="item.type == 'checkbox'" v-model="data[item.prop]" @change="item.option.onchange">
                        <el-checkbox v-for="(v,i) in item.option.data" :label="v.value">{{v.label}}</el-checkbox>
                    </el-checkbox-group>
                    <!--@单选按钮列表-->
                    <el-radio-group v-if="item.type == 'radio'" v-model="data[item.prop]" @change="item.option.onchange">
                        <el-radio v-for="(v,i) in item.option.data" :label="v.value">{{v.label}}</el-radio>
                    </el-radio-group>
                    <!-- @自定义项  -->
                    <!--@展示文本-->
                    <span v-else-if="!item.type || item.type == 'text'">{{data[item.prop]}}</span>
                </slot>
            </el-form-item>

            <!--            操作按钮-->
            <slot name="buttons">
                <el-form-item>
                    <el-button type="primary" @click="submitForm('my-form')">立即创建</el-button>
                    <el-button @click="resetForm('my-form')">重置</el-button>
                </el-form-item>
            </slot>
        </el-form>
    </div>

</template>

<script>
    module.exports = {
        props: {
            config: {
                type: Object
            },
            data: {
                type: Object
            }
        },
        data: function () {
            return {
                formConfig: {
                    rules: [],//校验
                    items: [],//校验
                    formClass: {
                        labelWidth: "100px",
                        inline: false,
                        labelPosition: "right",
                    }
                }
            }
        },
        created() {
            //合并俩个数据
            $.extend(true, this.formConfig, this.config);
            //设置一些自定义item的默认数据：避免调用对象无此属性
            for (let key in this.formConfig.items) {
                //默认生成项的数据
                let defaultItem = {
                    option: {
                        data: []
                    }
                };
                this.formConfig.items[key] = $.extend(defaultItem, this.formConfig.items[key]);
            }
            this.initData();
        },
        methods: {
            initData() {
                let _this = this;
            },
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$msgbox('数据：' + JSON.stringify(this.data));
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },
            /*
           将大驼峰字符串添加间隔符并转换为小写，也就是转换为连字符
           str:传递过来的原字符，splitStr:间隔符，默认是 '-'
           */
            humpToHyphen: function (str = '') {
                let splitStr = "_";
                if (str == '') { // 字符串是空的
                    return str;
                }
                if (typeof (str).toLowerCase() !== 'string') { //必须是字符串类型，其他的都不要
                    return str;
                }
                //其他条件暂时不添加限制了，比如大驼峰先转换成小驼峰再处理，只能是字符串和下划线，等等其他，自行添加
                let reg = new RegExp('[A-Z]', 'g');
                return str.replace(reg, function (match, offset, ss) { //match 匹配到的字符，offset 偏移量-下标，ss 原字符
                    return splitStr + match.toLowerCase()
                })
            }
        }
    }
</script>

<style scoped>
</style>