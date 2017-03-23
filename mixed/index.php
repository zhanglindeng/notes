<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>sendbird</title>
    <style>
      .channel-item {
        padding: 10px;
        margin: 5px;
      }

      .messages {
        height: 500px;
        width: 600px;
        overflow-y: auto;
        padding: 10px;
        background-color: #eee;
        border: 1px solid #ccc;
      }
      .messages .message-item {
        margin: 10px;
      }
      .messages .message-item div {
        padding: 10px;
        border-radius: 4px;
        background-color: #fff;
        display: inline-block;
      }
      .messages .my {
        text-align: right;
      }
      .messages .my div {
        background-color: #abc;
      }
    </style>
    <script>
      var user_id = "<?= $_GET['u'] ?>";
      var access_token = "<?= $_GET['t'] ?>";
    </script>
  </head>
  <body>
    <div class="sendbird-app" id="sendbird-app">
      <template v-if="view == 'min'">
        <button type="button" v-on:click="view = 'list'">sendbird</button>
      </template>

      <template v-if="view == 'list'">
        <button type="button" v-on:click="view = 'min'">close</button>
        <template v-for="channel in channels">
            <div class="channel-item" v-on:click="openChatView(channel)">
              {{ channel.name }}
            </div>
        </template>
      </template>

      <template v-if="view == 'chat'">
        <button type="button" v-on:click="view = 'min'">close</button>
        <button type="button" v-on:click="view = 'list'">back</button>
        <button type="button" v-on:click="loadPreMessages()">load pre messages</button>
        <div class="current-chat-name">{{ current_channel.name }}</div>
        <div class="messages" id="messages">
          <template v-for="msg in current_channel.messages | orderBy 'createdAt'">
            <div class="message-item" v-bind:class="{'my': msg.is_my}">
              <div>
                {{ msg.message }}
              </div>
            </div>
          </template>
        </div>
        <div class="input-view">
          <input type="text" v-model="message" v-on:keyup.enter="sendMessage()">
          <button type="button" v-on:click="sendMessage()">send</button>
        </div>
      </template>

    </div>
    <script src="js/jquery-1.11.3.min.js" charset="utf-8"></script>
    <script src="js/vue.min.js" charset="utf-8"></script>
    <script src="js/SendBird.min.js" charset="utf-8"></script>
    <script src="js/app.js" charset="utf-8"></script>
  </body>
</html>
