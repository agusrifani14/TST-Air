<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Partner Airport - OnlyFlights</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .toast-container {
            visibility: hidden;
            min-width: 300px;
            background-color: var(--success-color);
            color: #ffffff;
            text-align: center;
            border-radius: var(--radius-sm);
            padding: 16px 24px;
            position: fixed;
            z-index: 1000;
            left: 50%;
            bottom: 40px;
            font-size: 1rem;
            font-weight: 700;
            transform: translateX(-50%);
            box-shadow: 0 10px 25px rgba(16, 185, 201, 0.3);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: visibility 0s, opacity 0.3s ease;
            opacity: 0;
        }

        .toast-container.show {
            visibility: visible;
            opacity: 1;
        }
    </style>
    <script>
        window.onload = function() {
            document.querySelector('form').addEventListener('submit', function(event) {
                event.preventDefault();

                var form = event.target;
                var data = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: data
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'success') {
                        var toast = document.getElementById("toast");
                        toast.classList.add("show");
                        form.reset(); // clear the form
                        setTimeout(function(){ 
                            toast.classList.remove("show"); 
                        }, 3000);
                    } else {
                        alert('Failed to add airport');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error adding airport');
                });
            });
        }
    </script>
</head>
<body>
    <div class="premium-container">
        <h1 class="page-title">Add Partner Airport</h1>
        <p class="page-subtitle">Register new destination and hub facilities into the system</p>
        
        <div class="premium-card" style="max-width: 600px; margin: 0 auto;">
            <form action="/airport/add" method="post" class="premium-form">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="iata">IATA Airport Code</label>
                    <input type="text" name="iata" id="iata" class="premium-input" placeholder="e.g. CGK, DPS, SIN" required maxlength="3" style="text-transform: uppercase;">
                </div>
                
                <div class="form-group">
                    <label for="name">Airport Facility Name</label>
                    <input type="text" name="name" id="name" class="premium-input" placeholder="e.g. Soekarno-Hatta International Airport" required>
                </div>
                
                <div class="form-group">
                    <label for="city">Serving City</label>
                    <input type="text" name="city" id="city" class="premium-input" placeholder="e.g. Jakarta, Bali, Singapore" required>
                </div>
                
                <div class="form-group">
                    <label for="country">Country Region</label>
                    <select name="country" id="country" class="premium-select" required>
                        <option value="">Select a country</option>
                        <?php foreach ($countries as $country) : ?>
                            <option value="<?= $country->code ?>"><?= $country->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" class="premium-btn premium-btn-primary premium-btn-block" style="margin-top: 10px;">
                    <i class="fa-solid fa-plus"></i> Register Airport
                </button>
            </form>
        </div>
    </div>
    
    <div id="toast" class="toast-container">
        <i class="fa-solid fa-circle-check"></i> Airport added successfully!
    </div>
</body>
</html>