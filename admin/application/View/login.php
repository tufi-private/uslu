<style type="text/css">
    #login-content {
    	background-color: #eee;
    	width: 300px;
    	margin: 0 auto;
    	border: 1px solid #aaa;
    	-moz-border-radius: 10px;
    	-moz-box-shadow: 0 0 10px #aaa;
    	-webkit-border-radius: 10px;
    	-webkit-box-shadow: 0 0 10px #aaa;
    	padding: 10px;
    }
    #login-content input {
    	font-family: Georgia, "Times New Roman", Times, serif;
    }
    #login-form label {
    	display: block;
    	font-size: 16px;
    	line-height: 25px;
    }
    #login-form input[type=text], #login-form input[type=password] {
    	padding: 2px;
    	font-size: 16px;
    	line-height: 20px;
    	width: 250px;
    }
    #login-form input[type=submit] {
    	font-size: 20px;
    	font-weight: bold;
    	padding: 5px;
    }
    #login-content .success {
    	color: #060;
    }
    #login-content .error {
    	color: red;
    }
</style>
<div id="login-content">
    <p align="center">
        <img src="/<?= Bootstrap::getBasePath() ?>img/logo.png" alt="Uslu Plaza Estates" width="80" height="79" border="0" />
        <br /><strong>Login Form</strong>
    </p>

    <form id="login-form" name="login-form" action="/<?= Bootstrap::getBasePath() ?>index.php?show=login&do=login" method="post">
        <p>
            <label for="username">Username: </label>
            <input type="text" name="username" id="username" />
        </p>

        <p>
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" />
        </p>

        <p>
            <input type="submit" id="login" name="login" title="Login" value="  Login  " />
        </p>
    </form>
    <div id="message"><?= $this->message ?></div>
</div>
