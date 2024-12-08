<?php
session_start();
require '../../../../../db.php';

$search = isset($_POST['search']) ? $_POST['search'] : '';
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$results_per_page = 5;
$start_from = ($page - 1) * $results_per_page;

$query = "SELECT * FROM booking WHERE (full_name LIKE ? OR event_type LIKE ?) AND status = 'pending' LIMIT ?, ?";
$stmt = $conn->prepare($query);
$searchTerm = "%" . $search . "%";
$stmt->bind_param("ssii", $searchTerm, $searchTerm, $start_from, $results_per_page);
$stmt->execute();

$result = $stmt->get_result();
$total_query = "SELECT COUNT(*) FROM booking WHERE full_name LIKE ? OR event_type LIKE ?";
$countStmt = $conn->prepare($total_query);
$countStmt->bind_param("ss", $searchTerm, $searchTerm);
$countStmt->execute();
$total_result = $countStmt->get_result();
$total_filtered = $total_result->fetch_row()[0];
$total_pages = ceil($total_filtered / $results_per_page);

$rows = '';
$modals = ''; 
while ($row = $result->fetch_assoc()) {
    $rows .= '<tr>';
    $rows .= '<td>' . htmlspecialchars($row['celebrants_name']) . '</td>'; 
    $rows .= '<td>' . htmlspecialchars($row['full_name']) . '</td>';
    $rows .= '<td>' . htmlspecialchars($row['email']) . '</td>';
    $rows .= '<td>' . htmlspecialchars($row['phone_number']) . '</td>'; 
    $rows .= '<td>' . htmlspecialchars($row['events_date']) . '</td>'; 
    $rows .= '<td>' . htmlspecialchars($row['guest_count']) . '</td>'; 
    $rows .= '<td>' . htmlspecialchars($row['event_starttime']) . '</td>';
    $rows .= '<td>' . htmlspecialchars($row['event_type']) . '</td>'; 
    $rows .= '<td>' . htmlspecialchars($row['event_package']) . '</td>'; 
    $rows .= '<td>' . htmlspecialchars($row['event_options']) . '</td>'; 
    $rows .= '<td>₱' . number_format($row['cost'], 2) . '</td>'; 
    $rows .= '<td>';
    $rows .= '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentImageModal" data-payment-image="' . htmlspecialchars($row['payment_image']) . '">View</button>';
    $rows .= '</td>'; 
    $rows .= '<td>' . htmlspecialchars($row['reference_no']) . '</td>'; 
    $rows .= '<td>₱' . number_format($row['payment_amount'], 2) . '</td>';
    $rows .= '<td>';
    $rows .= '<form method="POST" action="../function/php/pending.php" style="display:inline;">';
    $rows .= '<input type="hidden" name="booking_id" value="' . $row['id'] . '">';
    $rows .= '<input type="hidden" name="action" value="accept">';
    $rows .= '<button type="submit" class="btn btn-success">Approve</button>';
    $rows .= '</form>';
    $rows .= '<form method="POST" action="../function/php/pending.php" style="display:inline;">';
    $rows .= '<input type="hidden" name="booking_id" value="' . $row['id'] . '">';
    $rows .= '<input type="hidden" name="action" value="decline">';
    $rows .= '<button type="submit" class="btn btn-danger">Decline</button>';
    $rows .= '</form>';
    $rows .= '</td>';
    $rows .= '</tr>';
}


    $modals .= '
    <div class="modal fade" id="infoModal' . $row['id'] . '" tabindex="-1" aria-labelledby="infoModalLabel' . $row['id'] . '" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel' . $row['id'] . '">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <h5>Customer Info</h5>
                                <div class="form-group mt-1">
                                    <label for="full-name" class="form-label">Full Name</label>
                                    <input type="text" id="full-name" name="full_name" class="form-control" value="' . htmlspecialchars($row['full_name']) . '" readonly>
                                </div>
                                <div class="form-group mt-1">
                                    <label for="celebrants-name" class="form-label">Celebrant\'s Name</label>
                                    <input type="text" id="celebrants-name" name="celebrants_name" class="form-control" value="' . htmlspecialchars($row['celebrants_name']) . '" readonly>
                                </div>
                                <div class="form-group mt-1">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" value="' . htmlspecialchars($row['email']) . '" readonly>
                                </div>
                                <div class="form-group mt-1">
                                    <label for="phone-number" class="form-label">Phone Number</label>
                                    <input type="number" id="phone-number" name="phone_number" class="form-control" value="' . htmlspecialchars($row['phone_number']) . '" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h5 class="events">Event Info</h5>
                                <div class="form-group mt-1">
                                    <label for="events-date" class="form-label">Event Date</label>
                                    <input type="text" id="events-date" name="events_date" class="form-control" value="' . htmlspecialchars($row['events_date']) . '" readonly>
                                </div>
                                <div class="form-group mt-1">
                                    <label for="guest-count" class="form-label">Guest Count</label>
                                    <input type="number" id="guest-count" name="guest_count" class="form-control" value="' . htmlspecialchars($row['guest_count']) . '" readonly>
                                </div>
                                <div class="form-group mt-1">
                                    <label for="event-duration" class="form-label">Event Duration</label>
                                    <input type="text" id="event-duration" name="event_duration" class="form-control" value="' . htmlspecialchars($row['event_duration']) . ' hours" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h5>Event Selection</h5>
                                <div class="form-group">
                                    <label for="event-type" class="form-label">Type of Event</label>
                                    <input type="text" id="event-type" name="event_type" class="form-control" value="' . htmlspecialchars($row['event_type']) . '" readonly>
                                </div>
                                 <div class="form-group">
                                    <label for="package-type" class="form-label">Type of Package</label>
                                    <input type="text" id="package-type" name="event_type" class="form-control" value="' . htmlspecialchars($row['event_package']) . '" readonly>
                                </div>
                                 <div class="form-group">
                                    <label for="event-options" class="form-label">Event Options</label>
                                    <input type="text" id="event-options" name="event_type" class="form-control" value="' . htmlspecialchars($row['event_options']) . '" readonly>
                                </div>
                                
                               
                            </div>
                            <div class="col-md-3">
                                <h5>Total Payment</h5>
                                <div class="form-group">
                                    <label for="total-cost" class="form-label">Total</label>
                                  <input type="text" id="total-cost" name="event_type" class="form-control" value="₱' . number_format($row['cost'], 0, '.', ',') . '" readonly>

                                </div>
                                <div class="form-group mt-1">
                                    <label for="modal-payment-image" class="form-label">Payment Image</label>
                                 <img id="modal-payment-image" src="../../../assets/gcash-payments/' . htmlspecialchars($row['payment_image']) . '" alt="Payment Image" class="img-fluid" style="max-width: 100%;"/>
                                </div>
                                <div class="form-group mt-1">
                                    <label for="modal-reference-no" class="form-label">Reference No</label>
                                   <input type="text" id="modal-reference-no" class="form-control" value="' . htmlspecialchars($row['reference_no'] ?: 'No Reference') . '" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>';




echo json_encode([
    'rows' => $rows,
    'modals' => $modals
]);
?>
