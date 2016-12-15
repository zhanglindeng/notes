# flexbox example

### link
- [youtube](https://www.youtube.com/watch?v=k32voqQhODc)
- [codepen](http://codepen.io/anon/pen/VKxRoE?editors=1100)

### html
```html
<!-- first example -->
<div class="container">
  <form action="">
    <div class="form-row">
      <label for="name">Name:</label>
      <input type="text" id="name">
    </div>
    <div class="form-row">
      <label for="favColor">Favorite Color:</label>
      <input type="text" id="favColor">
    </div>
  </form>
</div>

<!-- second example -->
<div class="column-layout">
  <div class="main-column">
    <h2>Main Column</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam voluptatibus soluta, consequuntur, reiciendis debitis omnis fugiat libero pariatur amet laudantium minima consectetur tenetur. Repudiandae, autem, voluptate modi deleniti sequi voluptatum!</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi earum fugit veniam amet quae sint vitae numquam dolore sunt quod a odio officia voluptate doloribus, at. Cum quasi mollitia eaque. Voluptatibus soluta, consequuntur, reiciendis debitis omnis fugiat libero pariatur amet laudantium.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam voluptatibus soluta, consequuntur, reiciendis debitis omnis fugiat libero pariatur amet laudantium minima consectetur tenetur. Repudiandae, autem, voluptate modi deleniti sequi voluptatum!</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi earum fugit veniam amet quae sint vitae numquam dolore sunt quod a odio officia voluptate doloribus, at. Cum quasi mollitia eaque.</p>
  </div>

  <div class="sidebar-one">
    <h3>Sidebar One</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum modi nisi tenetur sint dignissimos nulla, blanditiis nesciunt.</p>
  </div>

  <div class="sidebar-two">
    <h3>Sidebar Two</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum modi nisi tenetur sint dignissimos nulla, blanditiis nesciunt.</p>
  </div>
</div>

<!-- third example -->
<div class="call-outs-container">
  <div class="call-out">
    <h4>Feature 1</h4>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam obcaecati vel, placeat numquam omnis sit consectetur nobis molestias! Explicabo deserunt. Consectetur adipisicing elit. Quibusdam obcaecati vel, placeat numquam placeat numquam omnis sit consectetur.</p>
  </div>

  <div class="call-out">
    <h4>Feature 2</h4>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam obcaecati vel, placeat numquam omnis sit consectetur nobis molestias! Explicabo deserunt placeat numquam omnis.</p>
  </div>

  <div class="call-out">
    <h4>Feature 3</h4>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam obcaecati vel, placeat numquam omnis sit.</p>
  </div>
</div>

<!-- fourth example -->
<div class="fixed-size-container">
  <div class="fixed-size">1</div>
  <div class="fixed-size">2</div>
  <div class="fixed-size">3</div>
  <div class="fixed-size">4</div>
  <div class="fixed-size">5</div>
</div>

<!-- fifth example -->
<div class="banner">
  <div class="center-me">Center Me Plz</div>
</div>

<!-- sixth example -->
<div class="equal-height-container">
  <div class="first">
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam quasi similique amet voluptatem molestiae nostrum ab nesciunt blanditiis repellendus quos, sequi sunt, dolorem quis facilis mollitia nemo modi doloribus quo.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat quisquam, veritatis ducimus, vero magnam hic quia pariatur asperiores laudantium quod nobis perspiciatis, expedita quo reprehenderit quasi iusto ullam error reiciendis.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam quasi similique amet voluptatem molestiae nostrum ab nesciunt blanditiis repellendus quos, sequi sunt, dolorem quis facilis mollitia nemo modi doloribus quo.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat quisquam, veritatis ducimus, vero magnam hic quia pariatur asperiores laudantium quod nobis perspiciatis, expedita quo reprehenderit quasi iusto ullam error reiciendis.</p>
  </div>

  <div class="second">
    <div class="second-a">A</div>
    <div class="second-b">B</div>
  </div>
</div>
```

### css
```css
html, body {
  padding: 0;
  margin: 0;
}

input {
  font-size: 14px;
  font-family: Helvetica, sans-serif;
}

body {
  background-color: #BBB;
  font-family: Helvetica, sans-serif;
  padding-bottom: 100px;
}

h2, h3 {
  margin: 0 0 .75em 0;
}

/* first example */
.container {
  max-width: 750px;
  margin: 20px auto 0 auto;
  padding: 30px;
  background-color: #FFF;
}

.form-row {
  padding: 10px 0;
  display: flex;
}

.form-row label {
  padding-right: 10px;
}

.form-row input {
  flex: 1;
}

/* second example */
.column-layout {
  max-width: 1300px;
  background-color: #FFF;
  margin: 40px auto 0 auto;
  line-height: 1.65;
  padding: 20px 50px;
  display: flex;
}

.main-column {
  flex: 3;
  order: 2;
}

.sidebar-one {
  flex: 1;
  order: 1;
}

.sidebar-two {
  flex: 1;
  order: 3;
}

/* third example */
.call-outs-container {
  max-width: 1400px;
  margin: 40px auto 0 auto;
}

.call-out {
  padding: 20px;
  box-sizing: border-box;
  margin-bottom: 20px;
  flex-basis: 30%;
}

@media (min-width: 900px) {
  .call-outs-container {
    display: flex;
    justify-content: space-between;
  }
}

.call-out:nth-child(1) {background-color: #c0dbe2;}
.call-out:nth-child(2) {background-color: #cdf1c3;}
.call-out:nth-child(3) {background-color: #ccb9da;}

/* fourth example */
.fixed-size-container {
  max-width: 1400px;
  margin: 40px auto 0 auto;
  background-color: #FFF;
  padding: 30px 0;
  display: flex;
  align-items: center;
  justify-content: space-around;
  flex-wrap: wrap;
}

.fixed-size {
  width: 150px;
  height: 100px;
  background-color: #990b47;
  color: #FFF;
  line-height: 100px;
  text-align: center;
  font-weight: bold;
  font-size: 60px;
  margin-bottom: 20px;
}

/* fifth example */
.banner {
  height: 400px;
  max-width: 700px;
  margin: 40px auto 40px auto;
  background-color: #2a2a2a;
  display: flex;
}

.center-me {
  color: #FFF;
  font-size: 50px;
  margin: auto;
}

/* sixth example */
.equal-height-container {
  max-width: 900px;
  margin: 0 auto;
  display: flex;
}

.first {
  background-color: #FFF;
  padding: 20px;
  flex: 1;
}

.second {
  background-color: yellow;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.second-a {
  background-color: #c0dbe2;
  flex: 1;
}

.second-b {
  background-color: #cdf1c3;
  flex: 1;
}
```

