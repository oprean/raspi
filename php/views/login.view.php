<html>
<head>
	{head.common}
</head>
<body>	
	<div id="header-container"> </div>
	<div class="container" id="main-container">
		<div class="row">
			<p><h1 class="text-center">Raspi Playground login ...</h1></p>
			<form class="form-horizontal" method="post">
			  <div class="form-group">
			    <label for="username" class="col-sm-2 control-label">User</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="username" name="username" placeholder="Username or email ...">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="password" class="col-sm-2 control-label">Password</label>
			    <div class="col-sm-10">
			      <input type="password" class="form-control" id="password" name="password" placeholder="Password ...">
			      <input type="hidden" value="cucu" />
			    </div>
			  </div>
			  <div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-primary">Sign in</button>
			    </div>
			  </div>
			</form>
		</div>
	</div>
	<div id="footer-container" class="hidden-xs"> </div>
</body>
</html>