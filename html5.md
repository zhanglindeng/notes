### file input

在 `webkit` 内核的浏览器中, 写 `accept="image/*"` 反应很慢，解决办法就是列出 `mime`，例如：

`<input type="file" accept="image/gif,image/jpeg,image/jpg,image/png,image/svg">`

参考网页 [http://www.dengzhr.com/frontend/1059](http://www.dengzhr.com/frontend/1059)
