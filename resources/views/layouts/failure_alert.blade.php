@if(!session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert" id="successAlert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
            <use href="#check-circle-fill"></use>
        </svg>
        <div>
            <strong>Failure!</strong>

        </div>
    </div>

    <script>
        setTimeout(function() {
            var alert = document.getElementById('successAlert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
            }
        }, 2000);
    </script>
@endif
