<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">

<head>

    <title>@yield('title') </title>
    @include('admin/layouts/title-meta')

    @include('admin/layouts/head-css')

</head>

<body class="account-page">

<div class="main-wrapper">
    @include('admin/layouts/menu')
    <!-- Modal HTML -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('modalMessage') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        @if (session('showModal'))
            var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
        @endif
    </script>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        @if (session('showModal'))
            var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
        @endif
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all date and datetime-local input fields
            const dateInputs = document.querySelectorAll('input[type="date"], input[type="datetime-local"]');

            dateInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const value = this.value;
                    const year = value.split('-')[0]; // Extract year part
                    let errorMessage = this
                    .nextElementSibling; // Check if error message already exists

                    if (!errorMessage || !errorMessage.classList.contains('date-error')) {
                        // Create a new error message element if not already present
                        errorMessage = document.createElement('div');
                        errorMessage.className = 'date-error';
                        errorMessage.style.color = 'red';
                        errorMessage.style.fontSize = '12px';
                        errorMessage.style.fontWeight = 'bold';
                        this.parentNode.insertBefore(errorMessage, this.nextSibling);
                    }
                    if (year.length > 4) {
                        //this.value = ''; // Clear invalid value if year is more than 4 digits
                        errorMessage.innerText = 'Please enter a valid year with up to 4 digits.';
                    }
                });
            });
        });
    </script>
    <!-- Layout Content -->
    @yield('content')

    @include('admin/layouts/vendor-scripts')

</div>

</body>

</html>
