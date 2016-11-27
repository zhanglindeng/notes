### vue.js+jquery+http

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        .app {
            background: #00cc66;
        }
    </style>
</head>
<body>

<div id="app">
    <h3>{{message}}</h3>
    <input type="text" v-model="message">
    <button v-on:click="test">jquery</button>
</div>

<script src="js/vue.js"></script>
<script src="js/jquery.min.js"></script>
<!--https://github.com/pagekit/vue-resource-->
<script src="js/vue-resource.min.js"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            message: 'Hello'
        },
        methods: {
            test: function () {
                console.log(1);
                // 直接使用 jquery
                $('#app').addClass('app');
//                $.get('data.json', function (data) {
//                    console.log(data);
//                });
                // console.log(this);
                this.$http.get('data.json'/*, [options]*/)
                        .then(function (res) {
                            console.log('res', res);
                            console.log('res', res.body);
                            console.log('res', res.status);
                            console.log('res', res.ok);
                            console.log('res', res.json().then(function (json) {
                                console.log(json);
                            }));
                        }, function (res) {
                            console.log('error', res);
                        });
            }
        }
    });
</script>
</body>
</html>
```
