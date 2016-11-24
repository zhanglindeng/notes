# ckplayer demo

### [监听函数列表](http://www.ckplayer.com/manual/9/50.htm)
### [配置文档](http://www.ckplayer.com/manual/)

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div id="a1"></div>
<script type="text/javascript" src="ckplayer/ckplayer.js" charset="utf-8"></script>
<script type="text/javascript">
//    function ckplayer_status(e) {
//        console.log('ckplayer_status', e);
//    }

    var flashvars = {
        f: 'http://vf3.mtime.cn/Video/2016/04/14/flv/160414173112113429.flv',
        c: 0,
        p: 1,
        e: 0,
        loaded: 'loadedHandler'
    };
    // 播放完后调用的js函数
    function playerstop() {
        console.log('end');
        // 实现自动连播功能：可以先给一点提示，然后再连播，当中用户取消掉的话就停止连播
        // 从视频播放列表中来读取下一个视频
        flashvars.f = 'http://127.0.0.1:8080/test.mp4';
        video = ['http://127.0.0.1:8080/test.mp4->video/mp4'];
        // 从新调用新的视频播放器
        CKobject.embed('ckplayer/ckplayer.swf', 'a1', 'ckplayer_a1', '600', '400', false, flashvars, video);
    }
    var video = ['http://movie.ks.js.cn/flv/other/1_0.mp4->video/mp4'];
    CKobject.embed('ckplayer/ckplayer.swf', 'a1', 'ckplayer_a1', '600', '400', true, /*false=优先flash,true=优先html5*/ flashvars, video);
    function loadedHandler() {
        // 6.7 html5设置了没用, 6.8版本才可以
        // 拖动的话相当于暂停再播放，只是时间点改变了，可能往前也可能往后拖
        CKobject.getObjectById('ckplayer_a1').addListener('play', 'playHandler');
        CKobject.getObjectById('ckplayer_a1').addListener('pause', 'pauseHandler');
        // html5下面的两个监听事件报错，没用啊
        CKobject.getObjectById('ckplayer_a1').addListener('totaltime', 'totaltimeHandler');
        CKobject.getObjectById('ckplayer_a1').addListener('time', 'timeHandler');
    }
    function playHandler() {
        // 6.7 html5好像不行啊
        console.log('play event');
    }
    function pauseHandler() {
        console.log('pauseHandler');
    }
    function totaltimeHandler(t) {
        console.log('totaltimeHandler',t);
    }
    function timeHandler(t) {
        console.log('timeHandler',t);
    }
</script>
</body>
</html>
```
