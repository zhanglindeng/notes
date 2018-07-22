### simple test
index.html
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>iview example</title>
    <link rel="stylesheet" type="text/css" href="./node_modules/iview/dist/styles/iview.css">
    <script type="text/javascript" src="./node_modules/vue/dist/vue.min.js"></script>
    <script type="text/javascript" src="./node_modules/iview/dist/iview.min.js"></script>
    <script type="text/javascript" src="./node_modules/axios/dist/axios.min.js"></script>
    <style>
        .ivu-modal {
            top: 20px;
        }
    </style>
</head>
<body>
<div id="app" style="margin: 1rem;">
    <i-button @click="show">Click me!</i-button>
    <Modal v-model="visible" title="Welcome" width="800">
        
            <div style="max-height: calc(100vh - 200px);overflow: auto">
            <i-form :model="formItem" :label-width="100">
                    <form-item label="Input">
                            <i-input v-model="formItem.input" placeholder="Enter something..."></i-input>
                    </form-item>
                    <form-item label="Select">
                        <i-select v-model="formItem.select">
                            <i-option value="beijing">New York</i-option>
                            <i-option value="shanghai">London</i-option>
                            <i-option value="shenzhen">Sydney</i-option>
                        </i-select>
                    </form-item>
                    <form-item label="date-picker">
                        <row>
                            <col span="11">
                                <date-picker type="date" placeholder="Select date" v-model="formItem.date"></date-picker>
                            </col>
                            <col span="2" style="text-align: center">-</col>
                            <col span="11">
                                <time-picker type="time" placeholder="Select time" v-model="formItem.time"></time-picker>
                            </col>
                        </row>
                    </form-item>
                    <form-item label="Radio">
                        <radio-group v-model="formItem.radio">
                            <Radio label="male">Male</Radio>
                            <Radio label="female">Female</Radio>
                        </radio-group>
                    </form-item>
                    <form-item label="Checkbox">
                        <checkbox-group v-model="formItem.checkbox">
                            <Checkbox label="Eat"></Checkbox>
                            <Checkbox label="Sleep"></Checkbox>
                            <Checkbox label="Run"></Checkbox>
                            <Checkbox label="Movie"></Checkbox>
                        </checkbox-group>
                    </form-item>
                    <form-item label="Switch">
                        <i-switch v-model="formItem.switch" size="large">
                            <span slot="open">On</span>
                            <span slot="close">Off</span>
                        </i-switch>
                    </form-item>
                    <form-item label="Slider">
                        <Slider v-model="formItem.slider" range></Slider>
                    </form-item>
                    <form-item label="Text">
                        <i-input v-model="formItem.textarea" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Enter something..."></i-input>
                    </form-item>
                    <form-item>
                        <i-button type="primary">Submit</i-button>
                        <i-button type="ghost" style="margin-left: 8px">Cancel</i-button>
                    </form-item>
                </i-form>

        <i-form :model="formItem" :label-width="100">
                <form-item label="Input">
                        <i-input v-model="formItem.input" placeholder="Enter something..."></i-input>
                </form-item>
                <form-item label="Select">
                    <i-select v-model="formItem.select">
                        <i-option value="beijing">New York</i-option>
                        <i-option value="shanghai">London</i-option>
                        <i-option value="shenzhen">Sydney</i-option>
                    </i-select>
                </form-item>
                <form-item label="date-picker">
                    <row>
                        <col span="11">
                            <date-picker type="date" placeholder="Select date" v-model="formItem.date"></date-picker>
                        </col>
                        <col span="2" style="text-align: center">-</col>
                        <col span="11">
                            <time-picker type="time" placeholder="Select time" v-model="formItem.time"></time-picker>
                        </col>
                    </row>
                </form-item>
                <form-item label="Radio">
                    <radio-group v-model="formItem.radio">
                        <Radio label="male">Male</Radio>
                        <Radio label="female">Female</Radio>
                    </radio-group>
                </form-item>
                <form-item label="Checkbox">
                    <checkbox-group v-model="formItem.checkbox">
                        <Checkbox label="Eat"></Checkbox>
                        <Checkbox label="Sleep"></Checkbox>
                        <Checkbox label="Run"></Checkbox>
                        <Checkbox label="Movie"></Checkbox>
                    </checkbox-group>
                </form-item>
                <form-item label="Switch">
                    <i-switch v-model="formItem.switch" size="large">
                        <span slot="open">On</span>
                        <span slot="close">Off</span>
                    </i-switch>
                </form-item>
                <form-item label="Slider">
                    <Slider v-model="formItem.slider" range></Slider>
                </form-item>
                <form-item label="Text">
                    <i-input v-model="formItem.textarea" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Enter something..."></i-input>
                </form-item>
                <form-item>
                    <i-button type="primary">Submit</i-button>
                    <i-button type="ghost" style="margin-left: 8px">Cancel</i-button>
                </form-item>
            </i-form>
        </div>
    </Modal>
    <br>
    <br>
    <div>
        <i-table :columns="columns" :data="items" height="500" ref="selection" :loading="loading" stripe border></i-table>
    </div>
    <div style="margin: 10px;overflow: hidden">
        <div style="float: right;">
            <Page :total="100" :current="1" @on-change="changePage"></Page>
        </div>
    </div>
    <i-button @click="handleSelectAll(true)">全选</i-button>
    <i-button @click="handleSelectAll(false)">取消全选</i-button>
    <i-button @click="getSelected()">已选数据</i-button>

    <br><br>
        <i-form :model="formItem" :label-width="100">
            <form-item label="Input">
                    <i-input v-model="formItem.input" placeholder="Enter something..."></i-input>
            </form-item>
            <form-item label="Select">
                <i-select v-model="formItem.select">
                    <i-option value="beijing">New York</i-option>
                    <i-option value="shanghai">London</i-option>
                    <i-option value="shenzhen">Sydney</i-option>
                </i-select>
            </form-item>
            <form-item label="date-picker">
                <row>
                    <col span="11">
                        <date-picker type="date" placeholder="Select date" v-model="formItem.date"></date-picker>
                    </col>
                    <col span="2" style="text-align: center">-</col>
                    <col span="11">
                        <time-picker type="time" placeholder="Select time" v-model="formItem.time"></time-picker>
                    </col>
                </row>
            </form-item>
            <form-item label="Radio">
                <radio-group v-model="formItem.radio">
                    <Radio label="male">Male</Radio>
                    <Radio label="female">Female</Radio>
                </radio-group>
            </form-item>
            <form-item label="Checkbox">
                <checkbox-group v-model="formItem.checkbox">
                    <Checkbox label="Eat"></Checkbox>
                    <Checkbox label="Sleep"></Checkbox>
                    <Checkbox label="Run"></Checkbox>
                    <Checkbox label="Movie"></Checkbox>
                </checkbox-group>
            </form-item>
            <form-item label="Switch">
                <i-switch v-model="formItem.switch" size="large">
                    <span slot="open">On</span>
                    <span slot="close">Off</span>
                </i-switch>
            </form-item>
            <form-item label="Slider">
                <Slider v-model="formItem.slider" range></Slider>
            </form-item>
            <form-item label="Text">
                <i-input v-model="formItem.textarea" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Enter something..."></i-input>
            </form-item>
            <form-item>
                <i-button type="primary">Submit</i-button>
                <i-button type="ghost" style="margin-left: 8px">Cancel</i-button>
            </form-item>
        </i-form>
    
</div>
<script>
    new Vue({
        el: '#app',
        data: {
            visible: false,
            columns: [
                {type:'selection',width:60,align:'center'},
                {title: 'ID', key: 'id', sortable: true},
                {title: '姓名', key: 'name'},
            ],
            items:[],
            loading: true,
            // form
            formItem: {
                        input: '',
                        select: '',
                        radio: 'male',
                        checkbox: [],
                        switch: true,
                        date: '',
                        time: '',
                        slider: [20, 50],
                        textarea: ''
                    },
        },
        methods: {
            show: function () {
                this.visible = true;
            },
            handleSelectAll (status) {
                this.$refs.selection.selectAll(status);
            },
            getSelected() {
                console.log(this.$refs.selection.getSelection());
            },
            changePage(page) {
                console.log('change page', page);
            }
        },
        mounted: function() {
            var vm = this;
            axios.get('/data.json')
            .then(function(response){
                console.log(response);
                vm.items = response.data;
                vm.loading = false;
            })
            .catch(function(error){
                console.log(error);
            });
        }
    })
  </script>
</body>
</html>
```

data.json
```json
[
    {"id": 1, "name": "user1"},
    {"id": 2, "name": "user2"},
    {"id": 3, "name": "user3"},
    {"id": 4, "name": "user4"},
    {"id": 5, "name": "user5"},
    {"id": 6, "name": "user6"},
    {"id": 7, "name": "user7"},
    {"id": 8, "name": "user8"},
    {"id": 9, "name": "user9"},
    {"id": 10, "name": "user10"},
    {"id": 11, "name": "user11"},
    {"id": 12, "name": "user12"},
    {"id": 13, "name": "user13"},
    {"id": 14, "name": "user14"},
    {"id": 15, "name": "user15"},
    {"id": 16, "name": "user16"},
    {"id": 17, "name": "user17"},
    {"id": 18, "name": "user18"}
]
```

package.json
```json
{
  "dependencies": {
    "axios": "^0.18.0",
    "iview": "^2.14.3",
    "vue": "^2.5.16"
  }
}
```
