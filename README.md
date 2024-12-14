# htmxer
HTMX for WordPress


# example
```
<div hx-get="/wp-json/app/v1/toolbar" hx-trigger="load delay:0s" hx-swap="outerHTML"></div>
<script>
    document.body.addEventListener('htmx:configRequest', function (event) {
        event.detail.parameters['url'] = window.location.href;
    });
</script>Ï
```
url https://github.com/aiiddqd/aab/blob/main/main.php
