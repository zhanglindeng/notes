### html5 video

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>html5 video</title>
    <script src="js/screenfull.min.js"></script>
</head>
<body>
<video id="video" controls onended="end(this)" onplaying="playing(this)" width="500"></video>

<div>
    <p><span id="currTime">00:00</span>/<span id="totalTime">00:00</span></p>
    <p><input type="number" id="volume" onchange="volume(this.value)"></p>
    <p>
        <button id="fullScreen">fullScreen</button>
    </p>
</div>

<script>

    // todo 网络错误时的处理

    // 视频列表
    var videos = [
        'mp4/weiwei.mp4',
        'mp4/shangbuqi.mp4',
        'mp4/aiqingmatou.mp4'
    ];

    // 最大索引
    var maxIndex = videos.length - 1;

    // 初始化索引
    var index = 0;

    // 时间点
    var times = [];

    // 计时器
    var interval;

    // 初始化视频播放音量，自动播放第一个视频
    window.onload = function () {
        var v = document.getElementById('video');
        v.volume = 0.6;
        v.src = videos[index];
        v.play();

        // 全屏
        document.getElementById('fullScreen').addEventListener('click', function () {
            if (screenfull.enabled) {
                screenfull.request(v);
            }
        });
    };

    function addTime() {
        var currTime = new Date();
        times.push(currTime);
//        console.log(currTime.toLocaleString());
//        console.log(currTime.getFullYear(), currTime.getMonth(),
//                currTime.getDay(), currTime.getHours(),
//                currTime.getMinutes(),
//                currTime.getSeconds());
        console.log(times);
    }

    // 视频开始播放时，没有调用到
    //    function play(v) {
    //        console.log('play');
    //        addTime();
    //        console.log(v.src);
    //    }

    function playing(v) {
//        console.log('playing', v);
        addTime();
//        console.log(v.src);

        // 视频总时间 duration 不要显示
        // var v = document.getElementById('video');
        var duration = v.duration;
        duration = Math.floor(duration);
        var m = Math.floor(duration / 60);
        var s = duration % 60 - 1;
        if (s < 10) {
            s = '0' + s;
        }
        document.getElementById('totalTime').innerHTML = m + ':' + s;

        // 更新当前时间
        interval = setInterval(function () {
            var currTime = Math.ceil(v.currentTime);
            var m = Math.floor(currTime / 60);
            var s = currTime % 60;
            if (s < 10) {
                s = '0' + s;
            }
            document.getElementById('currTime').innerHTML = m + ':' + s;
        }, 1000);
    }

    // 视频播放结束时
    function end(v) {
        addTime();
        console.log(v.currentTime, v.src);
        if (index == maxIndex) {
            index = 0;
            console.log('end', times);
            // 停止计时器
            clearInterval(interval);
            return false;
        }
        index++;
        v.src = videos[index];
        v.play();
    }

    // 设置音量
    function volume(val) {
        document.getElementById('video').volume = val * 0.01;
    }

</script>
</body>
</html>
```
[screenfull](https://github.com/sindresorhus/screenfull.js)
