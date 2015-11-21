<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>It's simple MVC application skeleton, don't use it for production</title>
    </head>

    <body>
        <div>
            <a href="/hello/user-name">Hello</a>
            <a href="/">Home</a>
        </div>
        <div>Hello <? echo !empty($name) ? $name : ''; ?>. Welcome to simple MVC index page</div>
    </body>

</html>