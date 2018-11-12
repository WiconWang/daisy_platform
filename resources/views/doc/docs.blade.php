<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>技术文档</title>
    <!--<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Source+Code+Pro:300,600|Titillium+Web:400,600,700" rel="stylesheet">-->
    <link rel="stylesheet" type="text/css" href="/static/swagger-ui/swagger-ui.css" >
    <style>
        html
        {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }

        *,
        *:before,
        *:after
        {
            box-sizing: inherit;
        }

        body
        {
            margin:0;
            background: #fafafa;
        }

        .swagger-ui .parameter__type { color: #0d5aa7; text-decoration: underline}
        .swagger-ui .parameter__in { color: #20895e}
        .swagger-ui table tr { border-bottom: 1px dashed #ccc}
        .swagger-ui textarea.curl,.swagger-ui .opblock-body pre,.swagger-ui .opblock-body pre.microlight span,.swagger-ui .opblock-body pre span.headerline {
            line-height: 1.4em;
            background: #000; color: #04d602}
        .swagger-ui .opblock-body pre.example,.swagger-ui .opblock-body pre.example span{    background: #41444e;line-height: 1.4em;}
        .swagger-ui .responses-inner div div table.responses-table{ background: #fefefe}
        .swagger-ui .responses-inner div div table.responses-table .response-col_status {text-align: center}
        .swagger-ui .btn.execute { background: #f00; border: #ff6300}
        .swagger-ui .btn.btn-clear { border-color: #f00;}

    </style>
</head>

<body>
<a href="/docs/index.html" style="position: absolute; display: block; top: 10px; right: 10px;">回首页</a>
<div id="swagger-ui"></div>

<script src="/static/swagger-ui/swagger-ui-bundle.js"> </script>
<script src="/static/swagger-ui/swagger-ui-standalone-preset.js"> </script>
<script>
    window.onload = function() {

        // Build a system
        const ui = SwaggerUIBundle({
            url: "/docs/json/<?php echo $type;?>",
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],
            layout: "StandaloneLayout"
        })

        window.ui = ui
    }
</script>

<style>.topbar {
        display: none;}</style>
</body>
</html>
