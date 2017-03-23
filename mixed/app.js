$(function(){
  new Vue({
    el:'#sendbird-app',
    data: {
      app_id: 'your sendbird app id',
      user_id: user_id,
      access_token: access_token,
      view: 'min',// list, chat, min
      sendbird: null,
      current_user: null,
      current_channel: null,
      channels: [],
      message: '',
      // messages: [],
    },
    methods: {
      updateScrollTop: function() {
          $('#messages').scrollTop($('#messages')[0].scrollHeight);
      },
      loadPreMessages: function() {
        var vm = this;
        var query = vm.current_channel.createPreviousMessageListQuery();
        query.load(20, true, function(messageList, error) {
          if (error) {
            console.error(error);
            return false;
          }
          console.log(messageList);
          var userId = vm.current_user.userId;
          var temp = '';
          for (var i = 0; i < messageList.length; i++) {
            messageList[i].is_my = false;
            if(messageList[i].sender) {
              temp = messageList[i].sender.userId;
            }
            if(temp == userId) {
                messageList[i].is_my = true;
            }
            vm.current_channel.messages.push(messageList[i]);
          }
          // 更新滚动条高度
          vm.$nextTick(vm.updateScrollTop);
        });
      },
      notifyMessage: function(channel, message) {
        console.log('notify message');
        // if (this.current_channel.url == channel.url) {
        //   this.messages.push(message);
        // }
        message.is_my = false;
        for (var i = 0; i < this.channels.length; i++) {
          if(this.channels[i].url == channel.url) {
            this.channels[i].messages.push(message);
            // 更新滚动条高度
            this.$nextTick(this.updateScrollTop);
            break;
          }
        }
        switch (this.view) {
          case 'min':
            console.log('min notify');
            break;
          case 'list':
              console.log('list notify');
              break;
          default:// chat
            console.log('chat notify');
        }
      },
        setOnMessage: function() {
          var vm = this;
          var handler = new this.sendbird.ChannelHandler();
          handler.onMessageReceived = function(channel, message){
              // console.log(channel, message);
              vm.notifyMessage(channel, message);
          };

          this.sendbird.addChannelHandler('channel_handler', handler);
        },
        sendMessage: function () {
          if(this.message.trim() == '') {
            console.log('empty message');
            return false;
          }
          var vm = this;
          this.current_channel.sendUserMessage(this.message, '', function(msg, err){
              if (err) {
                  console.error(error);
                  return false;
              }
              msg.is_my = true;
              vm.message = '';
              vm.current_channel.messages.push(msg);
              // 更新滚动条高度
              vm.$nextTick(vm.updateScrollTop);
          });
        },
        openChatView: function(channel) {
          console.log('open chat view');
          this.view = 'chat';
          this.current_channel = channel;
          // 更新滚动条高度
          this.$nextTick(this.updateScrollTop);
          // 获取聊天记录
          // if (this.current_channel.messages.length == 0) {
          //   this.loadPreMessages(channel);
          // }
        },
        getChannels: function() {
          console.log('get channels');
          var query = this.sendbird.GroupChannel.createMyGroupChannelListQuery();
          query.includeEmpty = true;
          query.limit = 20;

          if (query.hasNext) {
             var vm = this;
              query.next(function(list, error){
                  if (error) {
                      console.error(error);
                      return false;
                  }
                  console.log(list);
                  for (var i = 0; i < list.length; i++) {
                    list[i].messages = [];
                    // list[i].is_loaded = false;
                    vm.channels.push(list[i]);
                  }
              });
          }
        }
    },
    created: function() {
      var vm = this;
      vm.sendbird = new SendBird({
        appId: vm.app_id
      });
      vm.sendbird.connect(vm.user_id, vm.access_token, function (user, error) {
        console.log('connect');
        if(error) {
          console.log(error);
          return false;
        }
        vm.current_user = user;
        vm.setOnMessage();
        vm.getChannels();
      });
    },
  });
  // vueApp.$nextTick(function() {
  //   console.log('nextTick');
  // });
});
