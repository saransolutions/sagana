<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Droppable - Shopping Cart Demo</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  h1 { padding: .2em; margin: 0; }
  #products { float:left; width: 500px; margin-right: 2em; }
  #cart { width: 200px; float: left; margin-top: 1em; }
  /* style the list to maximize the droppable hitarea */
  #cart ol { margin: 0; padding: 1em 0 1em 3em; }
  </style>
  <script>
  $(function() {
    $( "#catalog" ).accordion();
    $( "#catalog li" ).draggable({
      appendTo: "body",
      helper: "clone"
    });
    $( "#cart ol" ).droppable({
      activeClass: "ui-state-default",
      hoverClass: "ui-state-hover",
      accept: ":not(.ui-sortable-helper)",
      drop: function( event, ui ) {
        $( this ).find( ".placeholder" ).remove();
        $( "<li></li>" ).text( ui.draggable.text() ).appendTo( this );
      }
    }).sortable({
      items: "li:not(.placeholder)",
      sort: function() {
        // gets added unintentionally by droppable interacting with sortable
        // using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
        $( this ).removeClass( "ui-state-default" );
      }
    });
  });
  
  </script>
  <script>
  $(function() {
    $( "#menu" ).menu();
  });
  </script>
  <style>
  .ui-menu { width: 150px; }
  </style>
</head>
<body>
 
<div id="products">
  <h1 class="ui-widget-header">Products</h1>
  <div id="catalog">
    <h2><a href="#">T-Shirts</a></h2>
  <div id="html1">
  <ul>
    <li>Root node 1
      <ul>
        <li>Child node 1</li>
        <li><a href="#">Child node 2</a></li>
      </ul>
    </li>
  </ul>
</div>
  </div>
  
  <ul id="menu">
  <li class="ui-state-disabled">Aberdeen</li>
  <li>Ada</li>
  <li>Adamsville</li>
  <li>Addyston</li>
  <li>Delphi
    <ul>
      <li class="ui-state-disabled">Ada</li>
      <li>Saarland</li>
      <li>Salzburg an der schönen Donau</li>
    </ul>
  </li>
  <li>Saarland</li>
  <li>Salzburg
    <ul>
      <li>Delphi
        <ul>
          <li>Ada</li>
          <li>Saarland</li>
          <li>Salzburg</li>
        </ul>
      </li>
      <li>Delphi
        <ul>
          <li>Ada</li>
          <li>Saarland</li>
          <li>Salzburg</li>
        </ul>
      </li>
      <li>Perch</li>
    </ul>
  </li>
  <li class="ui-state-disabled">Amesville</li>
</ul>
  
</div>
 
<div id="cart">
  <h1 class="ui-widget-header">Shopping Cart</h1>
  <div class="ui-widget-content">
    <ol>
      <li class="placeholder">Add your items here</li>
    </ol>
  </div>
</div>
 
 
</body>
</html>