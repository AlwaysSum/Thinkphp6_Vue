<template>
    <el-card shadow="always" class="">
        <!--      表格操作按钮工具栏  -->
        <el-row slot="header" type="flex" justify="space-between">
            <slot name="table_toolbar">
                <slot name="table_toolbar_left">
                    <el-row class="" type="flex" justify="start">
                        <el-button size="small" plain circle icon="el-icon-refresh" @click="initData"></el-button>
                        <el-button type="success" size="small" plain round icon="el-icon-plus" @click="handleAdd">添加
                        </el-button>
                        <el-button type="danger" size="small" plain round icon="el-icon-delete">
                            删除
                        </el-button>
                        <el-button type="waring" size="small" plain round icon="el-icon-document-copy">导入</el-button>
                        <slot name="table_toolbar_left_after"></slot>
                    </el-row>
                </slot>
                <slot name="table_toolbar_right">
                    <el-row class="" type="flex" justify="end">
                        <slot name="table_toolbar_right_before"></slot>
                        <el-button-group>
                            <el-button v-popover:hide_col_pop size="small" plain round icon="el-icon-set-up">隐藏
                            </el-button>
                            <el-button size="small" plain round icon="el-icon-takeaway-box">导出</el-button>
                        </el-button-group>
                        <!--       隐藏列的对话框         -->
                        <el-popover ref="hide_col_pop" width="300" placement="bottom" trigger="click">
                            <el-col :span="20">
                                <h4>请选择需要隐藏的内容</h4>
                            </el-col>
                            <el-col :span="12" v-for="(_col,index) in tableConfig.tableHeader" :key="index">
                                <el-checkbox
                                        :value="_col.isHidden"
                                        @change="(val) => {showHide(_col, index, val);}"
                                >{{_col.label}}
                                </el-checkbox>
                            </el-col>
                        </el-popover>
                    </el-row>
                </slot>
            </slot>
        </el-row>

        <!--        自定义的表格-->
        <el-table :data="tableConfig.data"
                  v-loading="loading"
                  highlight-current-row
                  border="true"
                  tooltip-effect="dark"
                  :max-height="tableConfig.tableClass.maxHeight"
                  @selection-change="handleSelectionChange"
                  @current-change="handleCurrentChange"
                  :default-sort="tableConfig.defaultSortProp"
                  :style="{'width':tableConfig.tableClass.width}">
            <!--            单选列表-->
            <el-table-column
                    v-if="tableConfig.tableClass.showCheckBox"
                    type="selection"
                    align="center"
                    fixed="left"
                    width="55">
            </el-table-column>
            <!--            渲染内容-->
            <el-table-column
                    v-for="(_col,index) in tableConfig.tableHeader"
                    v-if="!col_hide_flat[ index]"
                    :key="index"
                    :type="_col.type"
                    :prop="_col.prop"
                    :label="_col.label"
                    :width="_col.width"
                    :min-width="_col.minWidth??150"
                    :show-overflow-tooltip="true"
                    :fixed="_col.fixed"
                    :formatter="_col.formatter"
                    :sortable="_col.sortable"
                    :filters="_col.filters"
                    :filter-method="_col.filterMethod"
                    align="center">

                <!-- 自定义头部-->
                <template slot="header" slot-scope="scope">
                    <slot :name="'header_'+humpToHyphen(_col.prop)">
                        <span>{{_col.label}}</span>
                    </slot>
                </template>

                <!--  自定义列:也可以自定义扩展-->
                <template slot-scope="scope">
                    <slot :name="'col_'+humpToHyphen(_col.prop)" v-bind:row="scope.row" v-bind:column="scope.column"
                          v-bind:index="scope.$index" v-bind:store="scope.store">
                        <!-- 后备内容 -->
                        {{ scope.row[_col.prop] }}
                    </slot>
                </template>


            </el-table-column>

            <!--                操作列-->
            <el-table-column
                    fixed="right"
                    label="操作"
                    align="center"
                    min-width="100px">
                <!--                自定义按钮行-->
                <template slot-scope="scope">
                    <slot name="col_btn" v-bind:row="scope.row" v-bind:column="scope.column"
                          v-bind:index="scope.$index" v-bind:store="scope.store">
                        <el-row>
                            <!-- 后备内容：默认的按钮操作 -->
                            <el-button type="warning" size="small" plain circle icon="el-icon-edit" @click="handleEdit(scope.row)"></el-button>
                            <el-button type="danger" size="small" plain circle icon="el-icon-delete"></el-button>
                        </el-row>
                    </slot>
                </template>
            </el-table-column>
        </el-table>
    </el-card>
</template>

<script>
    module.exports = {
        props: {
            config: {
                type: Object
            }
        },
        data() {
            return {
                dialogTableVisible: false,
                loading: false,
                col_hide_flat: [], //活动表头，隐藏表头
                //默认的初始化表格配置数据
                tableConfig: {
                    data: [],
                    apiUrl: {
                        index_url: null,
                        add_url: null,
                        edit_url: null,
                        del_url: null,
                    },
                    tableHeader: [],
                    tableClass: {
                        width: '100%',
                        showCheckBox: true,
                        maxHeight: '720',
                        defaultSortProp: null, //ascending  descending
                    },
                },
            };
        },
        created() {
            //合并俩个数据
            $.extend(true, this.tableConfig, this.config);
            this.initData();
        },
        methods: {
            handleAdd() {
                layer.open({
                    type: 2,
                    title: "添加",
                    area: ['60%', '80%'],
                    content: this.tableConfig.apiUrl.add_url,
                });
            },
            handleEdit(row) {
                console.log('@test 编辑,', row);
                layer.open({
                    type: 2,
                    title: "编辑",
                    area: ['60%', '80%'],
                    content: this.tableConfig.apiUrl.edit_url,
                });
                this.$message('你好' + row.id);
            },
            initData: function () {
                let _this = this;
                if (this.tableConfig.apiUrl.index_url) {
                    _this.loading = true;
                    apiPost(this.tableConfig.apiUrl.index_url, {}, {
                        onSuccess: function (data) {
                            _this.tableConfig.data = data.rows;
                        },
                        onError: function (code, msg) {
                            console.log('请求失败', code, msg);
                        },
                        onDone: function () {
                            _this.loading = false;
                        }
                    });
                }
            },
            handleSelectionChange: function (val) {

            },
            handleCurrentChange: function (val) {

            },
            //隐藏表格头
            showHide(show, _index, val) {
                this.$set(this.col_hide_flat, _index, val);
                // console.log(_index, val,'val');
                this.tableConfig.tableHeader[_index].isHidden = val;
                return;
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
        },
        mounted() {
        }
    }
</script>

<style scoped>
</style>