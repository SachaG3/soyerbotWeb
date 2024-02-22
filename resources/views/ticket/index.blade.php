@include('layout.header')

<div id="content">
    <div class="container">
        <div id="tickets-container">
            @include('ticket.partial.index', ['tickets' => $tickets])
        </div>
    </div>
</div>


@include('layout.footer')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('click', function(e) {
            if (e.target.matches('.ajax-link')) {
                e.preventDefault();
                const url = e.target.href;

                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('content').innerHTML = data.html;
                        history.pushState(null, '', url);
                    }).catch(error => console.error('Error:', error));
            }
        });
        document.addEventListener('click', function(e) {
            if (e.target.matches('.ajax-link, .pagination a')) {
                e.preventDefault();
                const url = e.target.href;
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('tickets-container').innerHTML = html;
                        history.pushState({ path: url }, '', url);
                    }).catch(error => console.error('Error:', error));
            }
        });

        window.onpopstate = function() {
            window.location.href = window.location.href;
        };
    });
</script>

