```html
<!DOCTYPE html>
<html lang="zh">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Vue Component</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
  <style>
    li.completed {
      text-decoration: line-through;
    }
  </style>
</head>

<body>
	<div class="container" id="app">
    <h1>My Todos</h1>
		<todo-item :todos="todos"></todo-item>
    <todo-add-form :newtodo.sync="newTodo"></todo-add-form>
    <h1>Users</h1>
    <div>
      <ul class="list-group">
        <li class="list-group-item" v-for="user in users">
          <code>{{user.id}}</code> {{user.name}} -- {{user.age}}
        </li>
      </ul>
    </div>
	</div>

  <script src="js/vue.min.js"></script>
	<script src="js/axios.min.js"></script>

	<template id="todo-list">
		<div>
      <ul class="list-group">
          <li class="list-group-item"  v-for="todo in todos" v-bind:class="{'completed' : todo.completed}">
            {{todo.title}}
            <button class="btn btn-xs pull-right margin-right-10"
             v-bind:class="{'btn-success' : todo.completed, 'btn-danger' : !todo.completed}"
             v-on:click="todoCompleted(todo)">
               {{todo.completed ? 'Completed' : 'Pending'}}
             </button>
          </li>
      </ul>
    </div>
	</template>

  <template id="todo-add-form">
    <form v-on:submit.prevent="addTodo">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Enter new todo" v-model="todo.title">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success">Add</button>
      </div>
    </form>
  </template>

	<script>
    var todoItem = Vue.extend({
      template: '#todo-list',
      props: ['todos'],
      methods: {
        todoCompleted(todo){
          todo.completed = !todo.completed;
        }
      }
    });
    Vue.component('todo-item', todoItem);
    var todoAddForm = Vue.extend({
      template: '#todo-add-form',
      props: ['newtodo'],
      data() {
        return {
          todo: {id: null, title: '', completed: false}
        };
      },
      methods: {
        addTodo() {
          this.newtodo = this.todo;
          this.todo = {id: null, title: '', completed: false};
        }
      }
    });
    Vue.component('todo-add-form', todoAddForm);
    new Vue({
      el:'#app',
      data: {
        todos: [
          {id: 1, title: 'Hello Vue', completed: false}
        ],
        newTodo: {},
        users: []
      },
      watch: {
        newTodo(newVal, oldVal) {
          console.log('newTodo');
          this.todos.push({
            id: Math.floor(Date.now()),
            title: newVal.title,
            completed: false
          });
        }
      },
      compiled: function(){
        var vm = this;
        axios.get('data.json').then(function(response){
          console.log(response.data);
          vm.users = response.data.data.users;
        }).catch(function(error){
          console.log(error);
        });
      }
    });
  </script>
</body>

</html>
```
