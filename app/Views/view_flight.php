<!DOCTYPE html>
<html lang="en">
<head>
    <title>View & Manage Flights - OnlyFlights</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .page-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .flight-route-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: var(--radius-full);
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
        }

        .flight-arrow-icon {
            color: var(--accent-color);
            font-size: 0.8rem;
            animation: floatAirplane 3s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <div class="premium-container">
        <h1 class="page-title">Flight Schedules</h1>
        <p class="page-subtitle">Configure routes, ticket prices, capacities, and active schedules</p>
        
        <div class="premium-card">
            <div class="page-toolbar">
                <div class="filter-search-wrapper" style="max-width: 400px;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="flightSearchInput" class="filter-search-input" placeholder="Search by flight ID, origin, destination...">
                </div>

                <div style="display: flex; gap: 12px; align-items: center;">
                    <span class="badge badge-primary">
                        <span class="radar-dot radar-dot-purple"></span> <?= count($flights) ?> Active Flights
                    </span>
                    <a href="/flight/add-flight" class="premium-btn premium-btn-primary" style="padding: 10px 18px; font-size: 0.88rem;">
                        <i class="fa-solid fa-plus"></i> Add New Flight
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="premium-table" id="flightsTable">
                    <thead>
                        <tr>
                            <th>Flight ID</th>
                            <th>Route</th>
                            <th>Ticket Price</th>
                            <th>Capacity</th>
                            <th>Schedule Time</th>
                            <th>Duration</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($flights)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                    <i class="fa-solid fa-plane-slash" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                                    No flights scheduled yet. Click "Add New Flight" to create one.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($flights as $f): ?>
                            <tr class="flight-row">
                                <td style="font-weight: 800; color: var(--accent-color); font-family: var(--font-heading); font-size: 1.05rem;">
                                    <?= $f->id; ?>
                                </td>
                                <td>
                                    <div class="flight-route-badge">
                                        <span style="font-weight: 700; color: #a78bfa;"><?= $f->origin_id; ?></span>
                                        <i class="fa-solid fa-arrow-right-long flight-arrow-icon"></i>
                                        <span style="font-weight: 700; color: #f59e0b;"><?= $f->destination_id; ?></span>
                                    </div>
                                </td>
                                <td style="font-weight: 700; color: var(--success-color);">
                                    Rp <?= number_format($f->price, 0, ',', '.'); ?>
                                </td>
                                <td style="font-weight: 600;">
                                    <span style="display: inline-flex; align-items: center; gap: 6px;">
                                        <i class="fa-solid fa-chair" style="color: var(--text-muted); font-size: 0.85rem;"></i>
                                        <?= $f->capacity; ?> seats
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column;">
                                        <span style="font-weight: 600;"><?= date('d M Y', strtotime($f->schedule)); ?></span>
                                        <small style="color: var(--text-muted); font-size: 0.8rem;">
                                            <i class="fa-regular fa-clock"></i> <?= date('H:i', strtotime($f->schedule)); ?> UTC
                                        </small>
                                    </div>
                                </td>
                                <td style="color: var(--text-secondary);">
                                    <i class="fa-solid fa-hourglass-half" style="font-size: 0.85rem; margin-right: 4px; color: var(--accent-cyan);"></i>
                                    <?= date('H:i', strtotime($f->duration)); ?> hrs
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="#edit-modal" class="action-link action-link-edit edit-link" data-id="<?= $f->id; ?>" rel="modal:open" title="Edit Flight">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="#delete-modal" class="action-link action-link-delete delete-link" data-id="<?= $f->id; ?>" rel="modal:open" title="Delete Flight">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="modal">
        <p class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Edit Flight Schedule</p>
        <form id="edit-form" class="premium-form">
            <div class="form-group">
                <label for="edit-id"><i class="fa-solid fa-barcode"></i> Flight ID</label>
                <input type="text" id="edit-id" name="id" class="premium-input" style="opacity: 0.6; cursor: not-allowed;" value="" disabled>
            </div>
            
            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label for="edit-origin-id"><i class="fa-solid fa-plane-departure"></i> Origin</label>
                    <select id="edit-origin-id" name="origin_id" class="premium-select">
                        <?php foreach ($airports as $airport): ?>
                            <option value="<?= $airport->iata; ?>"><?= $airport->iata ?> - <?= $airport->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="edit-destination-id"><i class="fa-solid fa-plane-arrival"></i> Destination</label>
                    <select id="edit-destination-id" name="destination_id" class="premium-select">
                        <?php foreach ($airports as $airport): ?>
                            <option value="<?= $airport->iata; ?>"><?= $airport->iata ?> - <?= $airport->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label for="edit-price"><i class="fa-solid fa-tag"></i> Ticket Price (IDR)</label>
                    <input type="number" id="edit-price" name="price" class="premium-input" required min="0">
                </div>
                <div>
                    <label for="edit-capacity"><i class="fa-solid fa-chair"></i> Capacity</label>
                    <input type="number" id="edit-capacity" name="capacity" class="premium-input" required min="1">
                </div>
            </div>
            
            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label for="edit-schedule"><i class="fa-solid fa-calendar-day"></i> Departure Time</label>
                    <input type="datetime-local" id="edit-schedule" name="schedule" class="premium-input" required>
                </div>
                <div>
                    <label for="edit-duration"><i class="fa-solid fa-clock"></i> Duration</label>
                    <input type="time" id="edit-duration" name="duration" class="premium-input" required step="60">
                </div>
            </div>
            
            <button type="submit" class="premium-btn premium-btn-primary premium-btn-block" style="margin-top: 10px;">
                <i class="fa-solid fa-floppy-disk"></i> Save Schedule Changes
            </button>
        </form>
    </div>

    <!-- Delete Modal -->
    <div id="delete-modal" class="modal" style="text-align: center;">
        <p class="modal-title" style="color: var(--danger-color); background: none; -webkit-text-fill-color: var(--danger-color);"><i class="fa-solid fa-triangle-exclamation"></i> Delete Flight</p>
        <p style="color: var(--text-secondary); margin-bottom: 24px; font-size: 0.95rem;">Are you sure you want to remove this flight schedule? This action cannot be undone.</p>
        <form id="delete-form">
            <input type="hidden" id="delete-id" name="id" value="">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <a href="#" rel="modal:close" class="premium-btn premium-btn-secondary" style="margin: 0;">Cancel</a>
                <button type="submit" class="premium-btn premium-btn-primary" style="background: var(--danger-color); box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3); margin: 0;">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
            </div>
        </form>
    </div>

    <script>
        // Inject CSRF token into all jQuery AJAX requests
        var csrfName  = $('meta').not('[name="viewport"]').filter('[name]').first().attr('name');
        var csrfToken = $('meta[name="' + csrfName + '"]').attr('content');
        $.ajaxSetup({
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            }
        });

        $(document).ready(function(){
            // Live Search Filter for Flight Table
            $('#flightSearchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#flightsTable tbody tr.flight-row').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            $('.edit-link').click(function(){
                var id = $(this).data('id');
                $('#edit-id').val(id);
                
                // Fetch flight details
                $.ajax({
                    url: 'flight/fetch-flight/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                        if (response) {
                            $('#edit-origin-id').val(response.origin_id);
                            $('#edit-destination-id').val(response.destination_id);
                            $('#edit-price').val(response.price);
                            $('#edit-capacity').val(response.capacity);
                            
                            // Format date for datetime-local (YYYY-MM-DDTHH:MM)
                            if (response.schedule) {
                                var sDate = response.schedule.replace(" ", "T").substring(0, 16);
                                $('#edit-schedule').val(sDate);
                            }
                            
                            // Format duration (HH:MM)
                            if (response.duration) {
                                $('#edit-duration').val(response.duration.substring(0, 5));
                            }
                        }
                    }
                });
            });

            $('.delete-link').click(function(){
                var id = $(this).data('id');
                $('#delete-id').val(id);
            });

            $('#edit-form').submit(function(e){
                e.preventDefault();
                
                var origin = $('#edit-origin-id').val();
                var dest = $('#edit-destination-id').val();
                if (origin === dest) {
                    alert("Departure and Arrival airports cannot be the same!");
                    return false;
                }
                
                var formData = $(this).serialize();

                $.ajax({
                    url: 'flight/edit-flight/' + $('#edit-id').val(),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('AJAX request failed: ' + textStatus + ', ' + errorThrown);
                    }
                });
            });

            $('#delete-form').submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: 'flight/delete-flight/' + $('#delete-id').val(),
                    method: 'POST',
                    success: function(response) {
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('AJAX request failed: ' + textStatus + ', ' + errorThrown);
                    }
                });
            });
        });
            
        window.onload = function() {
            var now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            var tomorrow = new Date(now);
            tomorrow.setDate(tomorrow.getDate() + 1);
            tomorrow.setHours(0,0,0,0);

            var minDateTime = tomorrow.toISOString().slice(0,16);
            var editSchedule = document.getElementById("edit-schedule");
            if (editSchedule) {
                editSchedule.setAttribute("min", minDateTime);
            }
        }
    </script>
</body>
</html>
