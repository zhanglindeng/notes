"use strict";

var Demo = function (element, options) {
    this.$element = element;
    this.defaults = {
        'color': '#f90',
        'fontSize': '12px'
    };
    this.options = $.extend({}, this.defaults, options)
};

Demo.prototype = {
    foo: function (str) {
        alert(str);
        return this;
    },
    xcss: function () {
        return this.$element.css(this.options);
    }
};

(function ($) {
    $.fn.Demo = function (options) {
        return new Demo(this, options);
    };
})(jQuery);

// usage:
// $(function () {
//     $('#btn').click(function () {
//         $(this).Demo().foo('demo').xcss();
//     });
// });

// http://www.cnblogs.com/Wayou/p/jquery_plugin_tutorial.html
;(function ($, window, document, undefined) {
    //定义Beautifier的构造函数
    var Beautifier = function (ele, opt) {
        this.$element = ele;
        this.defaults = {
            'color': 'red',
            'fontSize': '12px',
            'textDecoration': 'none'
        };
        this.options = $.extend({}, this.defaults, opt);
    };
    //定义Beautifier的方法
    Beautifier.prototype = {
        beautify: function () {
            return this.$element.css({
                'color': this.options.color,
                'fontSize': this.options.fontSize,
                'textDecoration': this.options.textDecoration
            });
        }
    };
    //在插件中使用Beautifier对象
    $.fn.myPlugin = function (options) {
        //创建Beautifier的实体
        var beautifier = new Beautifier(this, options);
        //调用其方法
        return beautifier.beautify();
    }
})(jQuery, window, document);
