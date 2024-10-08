<template>
  <div class="dashboard-page">
    <!-- 顶部Card -->
    <t-row :gutter="[16, 16]">
      <t-col
        :xs="6"
        :xl="3"
        v-for="(item, index) in panelList"
        :key="item.title"
      >
        <t-card
          :bordered="false"
          :title="item.title"
          :style="{ height: '168px' }"
          :class="{
            'dashboard-item': true,
            'dashboard-item--main-color': index == 0,
          }"
        >
          <div class="dashboard-item-top">
            <span :style="{ fontSize: `${resizeTime * 36}px` }">{{
              item.number
            }}</span>
          </div>
          <div class="dashboard-item-left">
            <div
              v-if="index === 0"
              id="moneyContainer"
              class="dashboard-chart-container"
              :style="{
                width: `${resizeTime * 120}px`,
                height: `${resizeTime * 66}px`,
              }"
            ></div>
            <div
              v-else-if="index === 1"
              id="refundContainer"
              class="dashboard-chart-container"
              :style="{
                width: `${resizeTime * 120}px`,
                height: `${resizeTime * 42}px`,
              }"
            ></div>
            <span v-else-if="index === 2" :style="{ marginTop: `-24px` }">
              <t-icon name="usergroup" />
            </span>
            <span v-else :style="{ marginTop: '-24px' }">
              <t-icon name="file" />
            </span>
          </div>
          <template #footer>
            <div class="dashboard-item-bottom">
              <div class="dashboard-item-block">
                自从上周以来
                <!-- <trend
                  class="dashboard-item-trend"
                  :type="item.upTrend ? 'up' : 'down'"
                  :is-reverse-color="index === 0"
                  :describe="item.upTrend || item.downTrend"
                /> -->
              </div>

              <t-icon name="chevron-right" />
            </div>
          </template>
        </t-card>
      </t-col>
    </t-row>

    <!-- 排名 -->
    <t-row :gutter="[16, 16]">
      <t-col :xs="12" :xl="6">
        <t-card
          title="销售订单排名"
          class="dashboard-rank-card"
          :bordered="false"
        >
          <template #actions>
            <t-radio-group default-value="dateVal">
              <t-radio-button value="dateVal">本周</t-radio-button>
              <t-radio-button value="monthVal">近三个月</t-radio-button>
            </t-radio-group>
          </template>
          <t-table
            :data="saleTendList"
            :columns="saleColumns"
            rowKey="productName"
          >
            <template #index="{ rowIndex }">
              <span :class="getRankClass(rowIndex)">
                {{ rowIndex + 1 }}
              </span>
            </template>
            <span slot="growUp" slot-scope="{ row }">
              <trend
                :type="row.growUp > 0 ? 'up' : 'down'"
                :describe="Math.abs(row.growUp)"
              />
            </span>
            <template #operation="slotProps">
              <a class="link" @click="rehandleClickOp(slotProps)">详情</a>
            </template>
          </t-table>
        </t-card>
      </t-col>
    </t-row>
  </div>
</template>

<script>
module.exports = {
  data() {
    return {
      resizeTime: 1,
      panelList: [
        {
          title: "总收入",
          number: "¥ 28,425.00",
          upTrend: "20.5%",
          leftType: "echarts-line",
        },
        {
          title: "总退款",
          number: "¥ 768.00",
          downTrend: "20.5%",
          leftType: "echarts-bar",
        },
        {
          title: "活跃用户（个）",
          number: "1126",
          downTrend: "20.5%",
          leftType: "icon-usergroup",
        },
        {
          title: "订单（个）",
          number: 527,
          downTrend: "20.5%",
          leftType: "icon-file-paste",
        },
      ],
      saleTendList: [
        {
          growUp: 1,
          productName: "国家电网有限公司",
          count: 7059,
          date: "2021-09-01",
        },
        {
          growUp: -1,
          productName: "深圳燃气集团股份有限公司",
          count: 6437,
          date: "2021-09-01",
        },
        {
          growUp: 4,
          productName: "国家烟草专卖局",
          count: 4221,
          date: "2021-09-01",
        },
        {
          growUp: 3,
          productName: "中国电信集团有限公司",
          count: 3317,
          date: "2021-09-01",
        },
        {
          growUp: -3,
          productName: "中国移动通信集团有限公司",
          count: 3015,
          date: "2021-09-01",
        },
        {
          growUp: -3,
          productName: "新余市办公用户采购项目",
          count: 2015,
          date: "2021-09-12",
        },
      ],
      saleColumns: [
        {
          align: "center",
          colKey: "index",
          title: "排名",
          width: 80,
          fixed: "left",
        },
        {
          align: "left",
          ellipsis: true,
          colKey: "productName",
          title: "客户名称",
          minWidth: 200,
        },
        {
          align: "center",
          colKey: "growUp",
          width: 100,
          title: "较上周",
        },
        {
          align: "center",
          colKey: "count",
          title: "订单量",
          width: 100,
        },
        {
          align: "center",
          colKey: "date",
          width: 140,
          title: "合同签订日期",
        },
        {
          align: "center",
          colKey: "operation",
          title: "操作",
          width: 80,
          fixed: "right",
        },
      ],
    };
  },
  methods: {
    rehandleClickOp(val) {
      console.log(val);
    },
    getRankClass(index) {
      return [
        "dashboard-rank__cell",
        { "dashboard-rank__cell--top": index < 3 },
      ];
    },
  },
};
</script>

<style scoped>
.dashboard-page {
  padding: 12px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.row-container {
  margin-bottom: 16px;
}
.t-card__body {
  padding-top: 0;
}

.dashboard-item {
  padding: 8px;
}
.dashboard-item .t-card__footer {
  padding-top: 0;
}
.dashboard-item .t-card__title {
  font-size: 14px;
  font-weight: 500;
}
.dashboard-item .t-card__body {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  flex: 1;
  position: relative;
}
.dashboard-item:hover {
  cursor: pointer;
}
.dashboard-item-top {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
}
.dashboard-item-top > span {
  display: inline-block;
  color: var(--td-text-color-primary);
  font-size: 36px;
  line-height: 44px;
}
.dashboard-item-bottom {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}
.dashboard-item-bottom > .t-icon {
  cursor: pointer;
}
.dashboard-item-block {
  display: flex;
  align-items: center;
  justify-content: center;
  line-height: 22px;
  color: var(--td-text-color-placeholder);
}
.dashboard-item-trend {
  margin-left: 8px;
}
.dashboard-item-left {
  position: absolute;
  top: 0;
  right: 32px;
}
.dashboard-item-left > span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 56px;
  height: 56px;
  background: var(--td-brand-color-1);
  border-radius: 50%;
}
.dashboard-item-left > span .t-icon {
  font-size: 24px;
  color: var(--td-brand-color);
}
.dashboard-item--main-color {
  background: var(--td-brand-color);
  color: var(--td-text-color-primary);
}
.dashboard-item--main-color .t-card__title,
.dashboard-item--main-color .dashboard-item-top span,
.dashboard-item--main-color .dashboard-item-bottom {
  color: var(--td-text-color-anti);
}
.dashboard-item--main-color .dashboard-item-block {
  color: var(--td-text-color-anti);
  opacity: 0.6;
}
.dashboard-item--main-color .dashboard-item-bottom {
  color: var(--td-text-color-anti);
}

/** 公共前缀 */
.dashboard-rank-card {
  padding: 8px;
}
.dashboard-rank-card .t-card__header {
  padding-bottom: 24px;
}
.dashboard-rank-card .t-card__title {
  font-size: 20px;
  font-weight: 500;
}
.dashboard-rank__cell {
  display: inline-flex;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  color: white;
  font-size: 14px;
  background-color: var(--td-gray-color-5);
  align-items: center;
  justify-content: center;
  font-weight: 700;
}
.dashboard-rank__cell--top {
  background: var(--td-brand-color);
}
</style>
