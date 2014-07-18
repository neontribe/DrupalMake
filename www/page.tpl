<!DOCTYPE html>
<html>
    <head>
        <title>Neontribe Cottage Make File</title>
        <link rel='stylesheet' type='text/css' href='main.css' />
        <script>
        function goBack() {
            window.history.back()
        }
        </script>
    </head>
    <body>
        <div class='container'>
            <a href="./" title="Cottage Make File Home"><img id="logo" src="neontribe_logo.png" alt="Neontribe" width="100" height="100" style="margin-bottom:-90px;"/></a>
            <h1 style="text-align:center;margin-bottom:14px;">Neontribe | Make File Generator</h1>
            <span style="width:100%;margin-left:32%;margin-top:10px;">
                <a href="./" title="Modify Existing Make File">Modify Existing Make File</a> <strong>|</strong>
                <a href="repos.php" title="Create New Make File">Create New Make File</a>
            </span><br />
            {block name=body}{/block}
        </div>
    </body>
</html>