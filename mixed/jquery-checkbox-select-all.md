- jquery 2.2.4
- [jsfiddle](https://jsfiddle.net/ys4pg2d1/)

```html
<div class="container">
  <h3>选择您最喜欢的运动？</h3>
  <p><input type="checkbox" name="all" value="0"> 全选</p>
  <p><input type="checkbox" name="sport" value="1"> 足球</p>
  <p><input type="checkbox" name="sport" value="2"> 篮球</p>
  <p><input type="checkbox" name="sport" value="3"> 羽毛球</p>
  <p><input type="checkbox" name="sport" value="4"> 乒乓球</p>
  <p><button class="btn btn-default">确定</button></p>
</div>
```
```javascript
$(function(){
	var isAll = false;
  var all = $('input[value="0"]');
  var sports = $('input[name="sport"]');
  var btn = $('button.btn-default');
  // 全选 toggle
	all.on('click',function(){
  	isAll = !isAll;
  	sports.prop('checked',isAll);
  });
  // 单独点击
  sports.on('click', function() {
  	var _this = $(this);
    if(_this.is(':checked')) {//选择
    	// 判断是否全部都选上
      for(var i = 0; i < sports.length; i++) {
      	if(!$(sports[i]).is(':checked')) {
        	return;
        }
      }
      all.prop('checked', true);
      isAll = true;
    } else {//取消选择
    	if(isAll) {//取消全选
      	isAll = !isAll;
    		all.prop('checked', isAll);
      }
    }
  });
  // 选择结果
  btn.on('click',function(){
  	var sports = $('input[name="sport"]:checked');
    sports.each(function(){
    	console.log($(this).val());
    });
  });
});
```
