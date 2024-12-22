<!doctype html>
<html lang="en">
<head>
    <title>Notification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabel">Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                // Display the message passed from the main page
                if (isset($_GET['message'])) {
                    echo htmlspecialchars($_GET['message']);
                }
                ?>
            </div>
            <div class="modal-footer">
                <a href="time_in.php" class="btn btn-secondary">Close</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Automatically show the modal when the page loads
    const feedbackModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
    feedbackModal.show();
</script>
</body>
</html>
