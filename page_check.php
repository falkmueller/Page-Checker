<?php session_start(); ?><!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>page check</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  </head>
  <body>
      
      <?php
        $url = "";
        if(!empty($_REQUEST["url"])){
           $url = $_REQUEST["url"];
        }
      ?>
      
      <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#">PAGE CHECKER</a>
    </div>
    
  </div><!-- /.container-fluid -->
</nav>
      
      <div class="container">
      <form method="GET">
          <div class="form-group">
           <div class="input-group">
             <div class="input-group-addon">Url</div>
             <input type="text" class="form-control" name="url" value="<?php echo $url; ?>" placeholder="Url" />
             <span class="input-group-btn">
                 <input type="submit" class="btn btn-primary" value="Go">
             </span>
           </div>
           
          </div>
      </form>
      </div>
    
      <?php
            if(!empty($_SESSION["last_check"]) && $_SESSION["last_check"] > time() - 5){
                $url = "";
                
                echo '<div class="container">'
                    . '<div class="alert alert-danger" role="alert">Only one check per 5 Sec enable. Wait a Moment and try it again.</div>'
                    . '</div>';
            } else {
                $_SESSION["last_check"] = time();
            }
          ?>
          

      <?php if($url){ ?>
      <div class="container">
          
          <?php
            $time_start = microtime(TRUE);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);

            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $time_end = microtime(TRUE);
            $time_diff = ($time_end - $time_start);
            
            list($header, $body) = explode("\r\n\r\n", $response, 2);
         ?>
          
          <div class="panel panel-default">
            <div class="panel-heading">Infos</div>
            <div class="panel-body">
              <?php
                echo "<ul>";
                echo "<li><strong>url:</strong> ".$url."</li>";
                echo "<li><strong>Zeit:</strong> ".$time_diff." sek</li>";
                echo "<li><strong>Http-Status:</strong> ".$httpcode."</li>";
                echo "</ul>";
              ?>
            </div>
          </div>
          
          <div class="panel panel-default">
            <div class="panel-heading">Header</div>
            <div class="panel-body">
              <?php
                echo "<ul>";
                foreach (explode("\r\n", $header) as $i => $line)
                        {
                            list ($key, $value) = explode(': ', $line);
                            echo "<li><strong>{$key}:</strong> {$value}</li>";
                        }
                echo "</ul>";
              ?>
            </div>
          </div>
      
      
          <div class="panel panel-default">
            <div class="panel-heading">Content</div>
            <div class="panel-body">
                <pre>
                    <?php
                        echo htmlspecialchars($body);;
                    ?>
                </pre>
            </div>
          </div>
          
      </div>
      <?php } ?>
      
      
      <div class="footer" style="border-top: 1px solid #ccc;">
    <div class="container">
    	<div class="row">
    		<div class="col-md-6 widget">
        	    <h2>About</h2>
                <article class="widget_content">
                    <ul>
                        <li>With this Script, you can call a Website to get the Status, Response-Time, Respnse-Header, Content, ...</li>
                        <li>Requirement: PHP 5.*, PHP Curl extension</li>
                        <li>Installation: Only Copy the PHP-file to your Host.</li>
                 </ul>
                 </article>
    		</div>
            <div class="col-md-6 widget">
        	    <h2>Link</h2>
                <article class="widget_content">
                    <ul>
                        <li><a href="http://getbootstrap.com" target="_blank">Get Bootstrap</a></li>
                        <li><a href="http://www.falk-m.de" target="_blank">My Site</a></li>
                        <li><a href="https://github.com/falkmueller" target="_blank">Git Repo</a></li>
                 </ul>
                 </article>
    		</div>
    	</div>
    </div>
</div>
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-12 widget">© 2016 by falk-m.de | Created with Boostrap <span class="pull-right"><a href="http://www.falk-m.de" target="_blank">falk-m.de »</a></span>
            </div>
        </div>
    </div>
</div> 

    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

  </body>
</html>



