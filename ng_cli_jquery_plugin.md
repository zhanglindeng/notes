在ng-cli中使用jquery和jquery plugin

- 以bootstrap 和 bootstrap-table 爲例

- 修改 node_modules/@angular/cli/models/webpack-configs/common.js
```js
const ProvidePlugin = require('webpack/lib/ProvidePlugin');
// plugins 下添加
new ProvidePlugin({
		$: "jquery",
		jQuery: "jquery"
})
```

- polyfills.ts 中添加
```js
import 'jquery'
import '../node_modules/bootstrap/dist/js/bootstrap';
import 'bootstrap-table'
```
- styles.css 中添加
```css
@import "../node_modules/bootstrap/dist/css/bootstrap.css";
@import "../node_modules/bootstrap-table/dist/bootstrap-table.css";
```
- component 中使用
```ts
import {Component, OnInit, ElementRef} from '@angular/core';
import * as jQuery from 'jquery';

constructor(private elementRef: ElementRef) {
    this.elementRef = elementRef;
}

ngOnInit() {
  jQuery(this.elementRef.nativeElement).find('#hello-table').bootstrapTable({
        url: 'http://localhost/data.php',
        columns: this.tableColumns()
      });
    jQuery(this.elementRef.nativeElement).find('#modal').modal('show');
}

```
