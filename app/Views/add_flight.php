<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Flight - OnlyFlights</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">
    <link rel="stylesheet" href="/css/style.css">
    <script>
        function validateForm() {
            var fields = ['flight_number', 'origin_id', 'destination_id', 'schedule', 'duration', 'price', 'capacity'];
            var isValid = true;

            for (var i = 0; i < fields.length; i++) {
                var field = document.getElementById(fields[i]);
                var alertDiv = document.getElementById(fields[i] + '_alert');

                if (!field || field.value == "") {
                    if (alertDiv) alertDiv.style.display = 'block';
                    isValid = false;
                } else {
                    if (alertDiv) alertDiv.style.display = 'none';
                }
            }
            
            // Check if origin and destination are the same
            var origin = document.getElementById('origin_id').value;
            var dest = document.getElementById('destination_id').value;
            if (origin && dest && origin === dest) {
                alert("Departure Airport and Arrival Airport cannot be the same!");
                isValid = false;
            }

            return isValid;
        }

        window.onload = function() {
            var now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            var tomorrow = new Date(now);
            tomorrow.setDate(tomorrow.getDate() + 1);
            tomorrow.setHours(0,0,0,0);

            var minDateTime = tomorrow.toISOString().slice(0,16);
            var scheduleField = document.getElementById("schedule");
            if (scheduleField) {
                scheduleField.setAttribute("min", minDateTime);
            }
        }
    </script>
</head>
<body>
    <div class="premium-container">
        <h1 class="page-title">Add New Flight Schedule</h1>
        <p class="page-subtitle">Register new aircraft routes and capacity logistics</p>
        
        <div class="premium-card" style="max-width: 650px; margin: 0 auto;">
            <form action="/flight/add" method="POST" onsubmit="return validateForm();" class="premium-form">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="flight_number">Flight Number (OF-...)</label>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <span style="font-weight: 700; color: var(--text-secondary); background: rgba(255,255,255,0.05); padding: 14px 18px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">OF-</span>
                        <input type="text" name="flight_number" id="flight_number" class="premium-input" placeholder="e.g. 123, 908" required maxlength="10">
                    </div>
                    <div id="flight_number_alert" class="form-alert">Flight number is required.</div>
                </div>
                
                <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label for="origin_id">Departure Airport</label>
                        <select name="origin_id" id="origin_id" class="premium-select" required>
                            <option value="">Select departure</option>
                            <?php foreach ($airports as $airport) : ?>
                                <option value="<?= $airport->iata ?>"><?= $airport->iata ?> - <?= $airport->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="origin_id_alert" class="form-alert">Departure airport is required.</div>
                    </div>
                    
                    <div>
                        <label for="destination_id">Arrival Airport</label>
                        <select name="destination_id" id="destination_id" class="premium-select" required>
                            <option value="">Select arrival</option>
                            <?php foreach ($airports as $airport) : ?>
                                <option value="<?= $airport->iata ?>"><?= $airport->iata ?> - <?= $airport->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="destination_id_alert" class="form-alert">Arrival airport is required.</div>
                    </div>
                </div>
                
                <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label for="schedule">Departure Time</label>
                        <input type="datetime-local" name="schedule" id="schedule" class="premium-input" required>
                        <div id="schedule_alert" class="form-alert">Departure date and time are required.</div>
                    </div>
                    
                    <div>
                        <label for="duration">Flight Duration</label>
                        <input type="time" name="duration" id="duration" class="premium-input" required step="60">
                        <div id="duration_alert" class="form-alert">Flight duration is required.</div>
                    </div>
                </div>
                
                <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label for="price">Ticket Price (IDR)</label>
                        <input type="number" name="price" id="price" class="premium-input" placeholder="e.g. 750000" required min="1000">
                        <div id="price_alert" class="form-alert">Ticket price is required.</div>
                    </div>
                    
                    <div>
                        <label for="capacity">Passenger Capacity</label>
                        <input type="number" name="capacity" id="capacity" class="premium-input" placeholder="e.g. 150" required min="1">
                        <div id="capacity_alert" class="form-alert">Passenger capacity is required.</div>
                    </div>
                </div>
                
                <button type="submit" class="premium-btn premium-btn-primary premium-btn-block" style="margin-top: 10px;">
                    <i class="fa-solid fa-plane-circle-check"></i> Register Flight
                </button>
            </form>
        </div>
    </div>
</body>
</html>
