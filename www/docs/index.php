<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Struct - Docs</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Open Sans';
            }
            p, div {
                font-family: 'Open Sans';
            } 
            
            h2::before
            {
                 content: "#";
            }
        </style>

    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Struct</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>

                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>



        <div class="container">

            <div class="row">

                <div class="col-md-3">
                    <div class="well well-sm">
                        <ul class="nav nav-pills nav-stacked" style="font-weight: bold">
                            <li role="presentation"><a href="#intro"><i class="glyphicon glyphicon-folder-close"> </i> Introduction</a></li>
                            <li role="presentation"><a href="#mvc"><i class="glyphicon glyphicon-folder-close"> </i> MVC</a></li>
                            <li role="presentation"><a href="#urls"><i class="glyphicon glyphicon-folder-close"> </i> Urls</a></li>
                            <li role="presentation"><a href="#functions"><i class="glyphicon glyphicon-folder-close"> </i> Function/Helpers</a></li>
                            <li role="presentation"><a href="#controller"><i class="glyphicon glyphicon-folder-close"> </i> Controller</a></li>
                            <li role="presentation"><a href="#model"><i class="glyphicon glyphicon-folder-close"> </i> Model</a></li>
                            <li role="presentation"><a href="#model"><i class="glyphicon glyphicon-folder-close"> </i> Views</a></li>
                            <li role="presentation"><a href="#errors"><i class="glyphicon glyphicon-folder-close"> </i> Errors</a></li>

                        </ul>
                    </div>
                </div>

                <div class="col-md-9">

                    <h2 id="intro">Introduction</h2>
                    <div class="well well-sm">
                        <ul>
                            <li>Struct follow basic mvc structure</li>
                            <li>Folders</li>
                            <ul >
                                <li role="presentation"><i class="glyphicon glyphicon-folder-close"> </i> app</li>
                                <ul>
                                    <li>All Controllers/Models/Views stands here</li>
                                </ul>
                            </ul>

                            <ul >
                                <li role="presentation"><i class="glyphicon glyphicon-folder-close"> </i> core</li>
                                <ul>
                                    <li>All struct core logic here do not change</li>
                                    <li>You can change /config/ folders file as you want</li>
                                </ul>
                            </ul>
                            <ul >
                                <li role="presentation"><i class="glyphicon glyphicon-folder-close"> </i> vendor</li>
                                <ul>
                                    <li>Do not change and Do not think :)</li>
                                </ul>
                            </ul>
                            <ul >
                                <li role="presentation"><i class="glyphicon glyphicon-folder-close"> </i> www</li>
                                <ul>
                                    <li>This is your public directory</li>
                                    <li>All your static files like /css/js are here</li>
                                    <li>For example i have <code>www/bootstrap.css</code> file in www directory. I can access with url like <code>http://site.com/bootstrap.css</code></li>
                                    <li>Do not put <code>www</code> in url</li> 
                                </ul>
                            </ul>

                            <ul >
                                <li role="presentation"><i class="glyphicon glyphicon-folder-close"> </i><code>composer.json,composer.lock,.htaccess</code></li>
                                <ul>
                                    <li>Do not delete this files</li>

                                </ul>
                            </ul>
                        </ul>
                    </div>

                    <h2 id="mvc">MVC</h2>
                    <div class="well well-sm">
                        <a href="https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller">Model–view–controller read here..</a>
                    </div>

                    <h2 id="urls">Urls</h2>
                    <div class="well well-sm">

                        <ul>


                            <li> For example url like
                                <code>
                                    example.com/news/article/my_article
                                </code></li>

                            <li>
                                Struct assume this url as like this
                                <code>example.com/class/function/argument</code>
                            </li>

                            <li>Above URL look for <code>NewsController.php</code> and call function <code>article($my_article)</code></li>
                        </ul>
                    </div>

                    <h2 id="functions">Functions/Helpers</h2>
                    <div class="well well-sm">

                        <ul>
                            <li><code>config($item)</code></li>
                            <ul>
                                <li>Use <code>config('database.host')</code> Use . for next level</li>
                                <li>It will look for <code>core/config/database.php</code> File and return key value from array within</li>
                                <li>To create new config variable make file in config folder and crate return array withing</li>
                                <li>Have a look files in <code>core/config</code></li>
                            </ul>
                            <li><code>url($segments)</code></li>
                            <ul>
                                <li>Use <code>url('article/create')</code> and <code>url()</code></li>
                                <li>It will return full url like <code>http://site.com/article/create</code></li>
                                <li>Blank argument return home page url</li>
                                <li>It is usefull in views where we pass url in hyperlinks</li>

                            </ul>
                            <li><code>redirect($segments)</code></li>
                            <ul>
                                <li>Use <code>redirect('home') </code> or <code>redirect()</code></li>
                                <li>Redirect to specific url</li>
                                <li>Blank argument redirect to homepage</li>
                            </ul>
                            <li><code>view($template,$data,$master)</code></li>
                            <ul>
                                <li>Use <code>view('index',$data,'layout.main')</code> use "." for separate directories</li>
                                <li>Do not use .php extention</li>
                            </ul>
                            <li><code>includeView($template)</code></li>
                            <ul>
                                <li>Include partial views in another views</li>
                                <li>Example <code>includeView('header')</code></li>
                            </ul>
                            <li><code>dump($anything)</code></li>
                            <ul>
                                <li>This is use full for dump variable and debug</li>
                            </ul>
                            <li><code>show404()</code></li>
                            <ul>

                                <li>Show 404 not found response</li>

                            </ul>

                    </div>

                    <h2 id="controller">Controller</h2>
                    <pre>
                            
namespace App\Controllers;


class HomeController extends \Controller {

    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
       
        //
    }

    public function work($name)
    {
        //
    }

}

                    </pre>
                    <div class="well well-sm">



                    </div>

                    <h2 id="model">Models</h2>
                    <pre>
namespace App\Models;

class Task extends \Model {
    
    public function getAllUsers(){
    //run sql query here 

    //use $this->db is PDO instance use like 
    // $this->db->prepare/query etc
}

}
                    </pre>
                    <div class="well well-sm">


                    </div>

                    <h2 id="views">Views</h2>
                    <div class="well well-sm"></div>

                    <h2 id="errors">Errors</h2>
                    <div class="well well-sm"></div>



                </div>
            </div>

        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </body>
</html>