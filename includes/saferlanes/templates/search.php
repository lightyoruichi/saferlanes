<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/layout.css" type="text/css" media="screen, projection"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Saferlanes: Making it hard to drive bad.</title>
    </head>
    <body>
        <div id="master">
            <div id="window">
                <img src="img/van.png" alt="truck"/>
                <h1>Saferlanes</h1>
                <p>Ever wondered what people think about your driving?</p>
                <p>Enter a vehicle plate number below and we will tell you.</p>
                <div id="application">
                    <form name="plate_number" method="POST" action="/">
                        <?= $page->get('msg'); ?>
                        <?= $page->get('plate'); ?>
                        <input id="pnum" class="title" type="text" name="plate" placeholder="Driver search"/>
                        <input  type="submit" value="go" name="submit"  />
                    </form>
                    </div>
                <p class="link"><a href="/post">Post a vehicle number</a></p>
            </div>
        </div>
</body>
</html>
