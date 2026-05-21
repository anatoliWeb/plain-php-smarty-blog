<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default:'Plain PHP Smarty Blog'|escape}</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    {include file="partials/header.tpl"}

    <main class="site-main">
        <div class="container">
            {block name="content"}{/block}
        </div>
    </main>

    {include file="partials/footer.tpl"}
</body>
</html>