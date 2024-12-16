# htmxer
HTMX for WordPress


# example

## initial HTML with HTMX
```
<div hx-get="/wp-json/htmxer/toolbar" hx-trigger="load delay:0s" hx-swap="outerHTML"></div>
```
url https://github.com/aiiddqd/aab/blob/main/main.php

## AJAX response
```
add_action('htmxer/toolbar', function ($context) {
    echo 'Hello World';
});
```

## Context (optional)

```
add_filter('htmxer/context', function ($context) {
    global $wp;
    $post_id = get_post()->ID ?? null;
    $context['post_id'] = $post_id;
    $context['url'] = site_url($wp->request);
    return $context;
});
```