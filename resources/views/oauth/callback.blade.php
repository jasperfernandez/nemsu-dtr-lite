<!DOCTYPE html>
<html>
<body>
<script>
    if (window.opener) {
        window.opener.postMessage(
            {
                type: "oauth",
                provider: "{{ $provider }}",
                status: "{{ $status }}"
            },
            window.location.origin
        );
    }

    window.close();
</script>
</body>
</html>
