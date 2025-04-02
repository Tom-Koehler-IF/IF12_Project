<?php session_start(); ?>

<script>
    // Helper function to make secure ajax refresh to php using X-CSRF
    function ajax_fetch(path, method, headers, body) {
        return fetch(path, {
            method: method,
            headers: {
                ...headers,
                'X-CSRF-Token': '<?php echo $_SESSION["csrf_token"]; ?>'
            },
            credentials: 'same-origin',
            body: body,
        });
    }
</script>
