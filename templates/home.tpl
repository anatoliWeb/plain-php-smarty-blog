<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|escape}</title>
</head>
<body>
    <h1>{$title|escape}</h1>
    {if $dbStatus}
        <p>{$dbStatus|escape}</p>
    {/if}
    <p>Project setup is ready.</p>
</body>
</html>
