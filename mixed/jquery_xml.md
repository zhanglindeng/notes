### jquery xml

[jsfiddle.ent](https://jsfiddle.net/5p26k134/1/)

```javascript

var xml = '<response>'
					+ '<count>1</count>'
          	+ '<user>'
          		+ '<name>zhangan</name>'
              + '<age>23</age>'
          	+ '</user>'
            + '<user>'
          		+ '<name>lisi</name>'
              + '<age>22</age>'
          	+ '</user>'
				  + '</response>';

$(function(){
	var output = $('#output');
  var xmlDoc = $.parseXML(xml);
  var $xml = $(xmlDoc);
  console.log($xml.find('count').text());
  var user = $xml.find('user');
  // output.html(user);
  console.log(user);
  for (var i = 0; i < user.length; i++) {
  	console.log($(user[i]).find('name').text());
    console.log($(user[i]).find('age').text());
  }
});

```
