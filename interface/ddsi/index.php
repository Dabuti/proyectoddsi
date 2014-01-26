<html>
<head>
  <script type="text/javascript" src="include/js/jquery-ui/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="include/js/jquery-ui/ui/jquery-ui.js"></script>
  <script type="text/javascript" src="include/js/jtable/jquery.jtable.js"></script>
  <script type="text/javascript" src="include/js/mylib2.js"></script>
  <script type="text/javascript" src="include/js/bootstrap/js/bootstrap.js"></script>

  <link rel="stylesheet" href="include/js/jtable/themes/metro/blue/jtable.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="include/js/jquery-ui/themes/base/jquery-ui.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="include/css/main.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="include/js/bootstrap/css/bootstrap.css" type="text/css" media="screen" />

</head>
<body>
  <div id="wrapper_content">
    <!-- Login -->
    <div class="wrapper_login">
      <div class="loginform-in">
        <h1>User Login</h1>
        <fieldset>
	  <form action="./" method="post">
            <div class="row_username">
	      <label for="name">Username </label>
	      <input type="text" size="30"  name="name" id="name"/>
            </div>
            <div class="row_password">
	      <label for="name">Password</label>
	      <input type="password" size="30"  name="word" id="word"/>
            </div>
            <div class="row_submit">
	      <label></label>
	      <input type="submit" id="login" name="login" value="Login" class="loginbutton">
            </div>
          </form>
        </fieldset>
        <div class="err" id="add_err"></div>
        <div class="singup">
          <span>Nuevo usuario</span>
        </div>
      </div>
    </div>
  </div> <!-- End wrapper_content -->

  <div id="wrapper_debug">
     <div id="wrapper_terminal">
        <div id="terminal_top"><div>OracleDB - Debug</div></div>
        <div id="terminal_content">
        </div>
     </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
	$("#add_err").css('display', 'none', 'important');
	$("#login").click(function(){
	    username=$("#name").val();
	    password=$("#word").val();
	    $.ajax({
		type: "POST",
		url: "login.php",
        dataType: "json",
		data: "username="+username+"&password="+password,
            success: function(html){
            var debug = '<div class="terminal_line">[System] ';
            debug += html.Request + '</div>';
            $('#terminal_content').append(debug);
            if(html['Result'] == "OK"){
                $("#add_err").html("Username y Password Correctos!");
                $.ajax({
                  type: "POST",
                    url: "main.php",
                    success: function(html){
                       $('#wrapper_content').html(html);
                    }
                 });
		    }
		    else{
                $("#add_err").css('display', 'inline', 'important');
                $("#add_err").html("<img src='img/alert.png'/><span>Wrong username or password</span><div class='clearb'></div>");
		    }
		},
		beforeSend:function(){
		    $("#add_err").css('display', 'inline', 'important');
		    $("#add_err").html("<img src='include/js/jtable/themes/metro/blue/loading.gif' /> Loading...")
		}
	    });
	    return false;
	});
    });
  </script>
</body>
</html>
