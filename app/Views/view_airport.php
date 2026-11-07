<!DOCTYPE html>
<html lang="en">
<head>
    <title>View & Manage Airports - OnlyFlights</title>
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

        .iata-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 10px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(217, 70, 239, 0.15));
            border: 1px solid rgba(139, 92, 246, 0.35);
            border-radius: var(--radius-sm);
            color: #d8b4fe;
            font-weight: 800;
            font-size: 1.05rem;
            letter-spacing: 0.08em;
            font-family: var(--font-heading);
        }
    </style>
</head>
<body>
    <div class="premium-container">
        <h1 class="page-title">Partner Airports</h1>
        <p class="page-subtitle">Manage registered global airport facilities and connections</p>
        
        <div class="premium-card">
            <div class="page-toolbar">
                <div class="filter-search-wrapper" style="max-width: 400px;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="airportSearchInput" class="filter-search-input" placeholder="Search by IATA, city, country, or name...">
                </div>

                <div style="display: flex; gap: 12px; align-items: center;">
                    <span class="badge badge-primary">
                        <span class="radar-dot radar-dot-purple"></span> <?= count($airports) ?> Partner Hubs
                    </span>
                    <a href="/airport/add-airport" class="premium-btn premium-btn-primary" style="padding: 10px 18px; font-size: 0.88rem;">
                        <i class="fa-solid fa-plus"></i> Add New Airport
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="premium-table" id="airportsTable">
                    <thead>
                        <tr>
                            <th>IATA Code</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Airport Name</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($airports)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                    <i class="fa-solid fa-plane-circle-exclamation" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                                    No airports found. Click "Add New Airport" to register one.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($airports as $a): ?>
                            <tr class="airport-row">
                                <td>
                                    <span class="iata-badge"><?= $a->iata; ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-primary">
                                        <i class="fa-solid fa-earth-asia" style="margin-right: 4px;"></i> <?= $a->country_id; ?>
                                    </span>
                                </td>
                                <td style="font-weight: 700; color: #ffffff;">
                                    <i class="fa-solid fa-location-dot" style="color: var(--accent-color); margin-right: 6px; font-size: 0.85rem;"></i>
                                    <?= $a->city; ?>
                                </td>
                                <td style="color: var(--text-secondary); font-weight: 500;">
                                    <?= $a->name; ?>
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="#edit-modal" class="action-link action-link-edit edit-link" data-iata="<?= $a->iata; ?>" rel="modal:open" title="Edit Airport">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="#delete-modal" class="action-link action-link-delete delete-link" data-iata="<?= $a->iata; ?>" rel="modal:open" title="Delete Airport">
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
        <p class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Edit Airport Details</p>
        <form id="edit-form" class="premium-form">
            <div class="form-group">
                <label for="edit-iata"><i class="fa-solid fa-barcode"></i> IATA Code</label>
                <input type="text" id="edit-iata" name="iata" class="premium-input" style="opacity: 0.6; cursor: not-allowed; text-transform: uppercase; font-weight: 800;" value="" disabled>
            </div>
            
            <div class="form-group">
                <label for="edit-name"><i class="fa-solid fa-building"></i> Airport Name</label>
                <input type="text" id="edit-name" name="name" class="premium-input" placeholder="Airport Name" required>
            </div>
            
            <div class="form-group">
                <label for="edit-city"><i class="fa-solid fa-city"></i> City</label>
                <input type="text" id="edit-city" name="city" class="premium-input" placeholder="City" required>
            </div>
            
            <div class="form-group">
                <label for="edit-country-id"><i class="fa-solid fa-globe"></i> Country</label>
                <select id="edit-country-id" name="country_id" class="premium-select" required>
                    <?php foreach ($countries as $country): ?>
                        <option value="<?= $country->code; ?>"><?= $country->name; ?> (<?= $country->code ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="premium-btn premium-btn-primary premium-btn-block" style="margin-top: 10px;">
                <i class="fa-solid fa-floppy-disk"></i> Save Changes
            </button>
        </form>
    </div>

    <!-- Delete Modal -->
    <div id="delete-modal" class="modal" style="text-align: center;">
        <p class="modal-title" style="color: var(--danger-color); background: none; -webkit-text-fill-color: var(--danger-color);"><i class="fa-solid fa-triangle-exclamation"></i> Delete Airport</p>
        <p style="color: var(--text-secondary); margin-bottom: 24px; font-size: 0.95rem;">Are you sure you want to remove this airport? This action cannot be undone.</p>
        <form id="delete-form">
            <input type="hidden" id="delete-iata" name="iata" value="">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <a href="#" rel="modal:close" class="premium-btn premium-btn-secondary" style="margin: 0;">Cancel</a>
                <button type="submit" class="premium-btn premium-btn-primary" style="background: var(--danger-color); box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3); margin: 0;">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
            </div>
        </form>
    </div>

    <script>
    // Set CSRF token on all AJAX requests globally
    var csrfName  = $('meta[name]').filter(function(){ return $(this).attr('name') !== 'viewport'; }).attr('name');
    var csrfToken = $('meta[name="' + csrfName + '"]').attr('content');
    $.ajaxSetup({
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        },
        data: (function() { var d = {}; d[csrfName] = csrfToken; return d; })()
    });

    $(document).ready(function(){
        // Live client-side search filter
        $('#airportSearchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#airportsTable tbody tr.airport-row').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        $('.edit-link').click(function(){
            var iata = $(this).data('iata');
            $('#edit-iata').val(iata);

            // Fetch details via AJAX
            $.ajax({
                url: 'airport/fetch-airport/' + iata,
                method: 'GET',
                success: function(response) {
                    if (response && response.length > 0) {
                        $('#edit-country-id').val(response[0].country_id);
                        $('#edit-name').val(response[0].name);
                        $('#edit-city').val(response[0].city);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('AJAX request failed: ' + textStatus + ', ' + errorThrown);
                }
            });
        });

        $('#edit-form').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: 'airport/edit-airport/' + $('#edit-iata').val(),
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

        $('.delete-link').click(function(){
            var iata = $(this).data('iata');
            $('#delete-iata').val(iata);
        });

        $('#delete-form').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: 'airport/delete-airport/' + $('#delete-iata').val(),
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
    });
    </script>
</body>
</html>
