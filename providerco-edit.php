<?php
include('database.php');
require "auth.php";
require "header.php";
if($_SESSION['session']== 1) { //Buh
  ?>
  <!DOCTYPE html>
  <html>
  <head>
  <title>Нет доступа</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/css/style.css">
  </head>
  <body>
<h1 align="center" style="color:#358A1E;text-shadow: yellow 0 0 10px;">"Доступ Закрыт, Обратитесь к администратору"</h1>
  <?php
  require "footer.php";
  ?>
  </body>
  </html>
  <?php
} else {
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Console JMM HelpDesk</title>
<meta charset="utf-8">
<link rel="stylesheet" href="/css/style.css">
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="selectbox.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 5px 10px;
      width: 280px;
  }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            classes: {
              "ui-tooltip": "ui-state-highlight"
            }
          });
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
          autocompletechange: "_removeIfInvalid"
        });
      },
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Отобразить" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .on( "mousedown", function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .on( "click", function() {
            input.trigger( "focus" );
            if ( wasOpen ) {
              return;
            }
            input.autocomplete( "search", "" );
          });
      },
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
      _removeIfInvalid: function( event, ui ) {
        if ( ui.item ) {
          return;
        }
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
        if ( valid ) {
          return;
        }
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
    $( "#combobox" ).combobox();
    $( "#toggle" ).on( "click", function() {
    $( "#combobox" ).toggle();
    });
  } );
  </script>
</head>
<body>
<div>
  <?php

$table = "providerco";
if($_SERVER['REQUEST_METHOD']=='POST') { //form handler part:
  $id = mysqli_real_escape_string($link, $_POST['id']);
  $name = mysqli_real_escape_string($link, $_POST['name']);
  $dest = mysqli_real_escape_string($link, $_POST['dest']);
  $type = mysqli_real_escape_string($link, $_POST['type']);
  $dogovor = mysqli_real_escape_string($link, $_POST['dogovor']);
  $tel = mysqli_real_escape_string($link, $_POST['tel']);
  $comment = mysqli_real_escape_string($link, $_POST['comment']);
//  echo 'before if';
  if ($id = intval($_POST['id'])) {
    $querypos="UPDATE providerco SET name='$name',dest='$dest',type='$type',dogovor='$dogovor',tel='$tel',comment='$comment' WHERE id=$id";
  }
  mysqli_query($link, $querypos) or trigger_error(mysql_error()." in ".$querypos);
  ?>
  <script type="text/javascript">
    location.replace("provider-listco.php");
  </script>
  <?php
  exit;
}
if (!isset($_GET['id'])) {
  $LIST=array();
  $query="SELECT * FROM $table ";
  $res=mysqli_query($link, $query);
  while($row=mysqli_fetch_assoc($res)) $LIST[]=$row;
} else {
  if ($id=intval($_GET['id'])) {
    $query="SELECT * FROM providerco WHERE id=$id";
    $res=mysqli_query($link, $query);
    $row=mysqli_fetch_assoc($res);
    foreach ($row as $k => $v) $row[$k]=htmlspecialchars($v);
  } else {
  $row['name']='';
  $row['id']=0;
}
}

?>

<h1 align="center" style="color:#358A1E;text-shadow: yellow 0 0 10px;"><?=$row['name']?></h1>
<?php
echo "<a href='provider-listco.php'style='position:relative;left:35%;top:36px;' class='button' >Назад</a></br></br>";
?>
<form method="POST">
<table style='margin-left:35%' class='simple-little-table'>
<tr>
<th>Провайдер</th>
<td><input type="text" name="name" value="<?=$row['name']?>"><br></td>
</tr>
<tr>
<th>Расположение:</th>
<td>
  <div class="selectbox">
  <select id="combobox" name="dest" value="<?=$row['dest']?>">
  <option selected="selected" value="<?=$row['dest']?>"><?=$row['dest']?></option>
  <option value="Курчатово">Курчатово</option>
  <option value="Центральный Офис">Центральный Офис</option>
  </select><br></td></div>
</tr>
<tr>
<th>Тип подключения</th>
<td><input type="text" name="type" value="<?=$row['type']?>"><br></td>
</tr>
<tr>
<th>Договор</th>
<td><input type="text" name="dogovor" value="<?=$row['dogovor']?>"><br></td>
</tr>
<tr>
<th>Телефон Тех. Поддержки</th>
<td><input type="text" name="tel" value="<?=$row['tel']?>"><br></td>
</tr>
<tr>
<th>Комментарий</th>
<td><textarea type="text" style="height: 50px" name="comment" value="<?=$row['comment']?>"><?=$row['comment']?></textarea><br></td>
</tr>
<tr>
<th>
</th>
<td>
</br>
<input type="hidden" id="submitbtn" name="id" value="<?=$row['id']?>">
<input type="submit" value="Отправить" class="button"><br>
</td>
</tr  >
</table>
</form>

</div>
</div>
</div>

</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>

<?php
require "footer.php";
?>
</body>
</html>

<?php
}
?>
