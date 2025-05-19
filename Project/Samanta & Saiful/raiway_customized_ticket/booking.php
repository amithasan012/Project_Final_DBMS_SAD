<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = trim($_POST['from']);
    $to = trim($_POST['to']);
    $date = $_POST['date'];
    $seats = (int)$_POST['seats'];
    $price_per_ticket = (float)$_POST['price_per_ticket'];

    if ($from === $to) {
        $error = "Source and destination cannot be the same.";
    } elseif ($seats < 1) {
        $error = "Seats must be at least 1.";
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, from_station, to_station, travel_date, seats, total_price, booking_date) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $total_price = $seats * $price_per_ticket;
        $stmt->bind_param("isssid", $_SESSION['user_id'], $from, $to, $date, $seats, $total_price);

        if ($stmt->execute()) {
            $success = "Ticket booked successfully! Total Price: ৳" . number_format($total_price, 2);
        } else {
            $error = "Booking failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Book Ticket - Railway Booking</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
  body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .card {
    width: 450px;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.3);
    background: white;
  }
  .btn-primary {
    background: #764ba2;
    border: none;
  }
  .btn-primary:hover {
    background: #667eea;
  }
  .price-display {
    font-weight: 600;
    font-size: 1.1rem;
    color: #764ba2;
    margin-top: -10px;
    margin-bottom: 15px;
  }
  /* Autocomplete styles */
  .autocomplete {
    position: relative;
  }
  .autocomplete-items {
    position: absolute;
    border: 1px solid #d4d4d4;
    border-top: none;
    z-index: 99;
    top: 100%;
    left: 0;
    right: 0;
    max-height: 200px;
    overflow-y: auto;
    background-color: white;
  }
  .autocomplete-items div {
    padding: 10px;
    cursor: pointer;
    background-color: #fff;
    border-bottom: 1px solid #d4d4d4;
  }
  .autocomplete-items div:hover {
    background-color: #e9e9e9;
  }
  .autocomplete-active {
    background-color: #764ba2 !important;
    color: white;
  }
</style>
</head>
<body>
  <div class="card">
    <h3 class="mb-4 text-center text-purple">Book Your Ticket</h3>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" novalidate autocomplete="off">
      <div class="mb-3 autocomplete">
        <label for="from" class="form-label">From</label>
        <input type="text" name="from" class="form-control" id="from" required />
      </div>
      <div class="mb-3 autocomplete">
        <label for="to" class="form-label">To</label>
        <input type="text" name="to" class="form-control" id="to" required />
      </div>
      <div class="mb-3">
        <label for="date" class="form-label">Travel Date</label>
        <input type="date" name="date" class="form-control" id="date" required min="<?= date('Y-m-d') ?>" />
      </div>
      <div class="mb-3">
        <label for="seats" class="form-label">Number of Seats</label>
        <input type="number" name="seats" class="form-control" id="seats" required min="1" value="1" />
      </div>

      <!-- Price display -->
      <div id="priceDisplay" class="price-display">Ticket Price: ৳0.00</div>
      
      <!-- Hidden input to submit the price per ticket -->
      <input type="hidden" name="price_per_ticket" id="price_per_ticket" value="0" />

      <button type="submit" class="btn btn-primary w-100">Book Now</button>
    </form>

    <div class="mt-3 text-center">
      <a href="index.php" class="text-decoration-none">&larr; Back to Home</a>
    </div>
  </div>

<script>
// Districts list for autocomplete
const districts = [
  "Bagerhat", "Bandarban", "Barguna", "Barisal", "Bhola", "Brahmanbaria",
  "Chandpur", "Chittagong", "Chuadanga", "Comilla", "Cox's Bazar", "Dhaka",
  "Dinajpur", "Feni", "Gaibandha", "Gazipur", "Gopalganj", "Habiganj",
  "Jamalpur", "Jessore", "Jhalokati", "Jhenaidah", "Joypurhat", "Kishoreganj",
  "Khagrachari", "Khulna", "Kurigram", "Kushtia", "Lakshmipur", "Lalmonirhat",
  "Madaripur", "Magura", "Manikganj", "Meherpur", "Moulvibazar", "Munshiganj",
  "Mymensingh", "Naogaon", "Narail", "Narayanganj", "Narsingdi", "Natore",
  "Netrokona", "Nilphamari", "Noakhali", "Pabna", "Panchagarh", "Patuakhali",
  "Pirojpur", "Rajbari", "Rajshahi", "Rangamati", "Rangpur", "Satkhira",
  "Shariatpur", "Sherpur", "Sirajganj", "Sunamganj", "Sylhet", "Tangail",
  "Thakurgaon"
];

// Autocomplete function (same as before)
function autocomplete(inp, arr) {
  let currentFocus;

  inp.addEventListener("input", function() {
    let val = this.value;
    closeAllLists();
    if (!val) return false;
    currentFocus = -1;
    let list = document.createElement("DIV");
    list.setAttribute("id", this.id + "-autocomplete-list");
    list.setAttribute("class", "autocomplete-items");
    this.parentNode.appendChild(list);

    for (let i = 0; i < arr.length; i++) {
      if (arr[i].substr(0, val.length).toUpperCase() === val.toUpperCase()) {
        let item = document.createElement("DIV");
        item.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
        item.innerHTML += arr[i].substr(val.length);
        item.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";

        item.addEventListener("click", function() {
          inp.value = this.getElementsByTagName("input")[0].value;
          closeAllLists();
          calculatePrice();
        });

        list.appendChild(item);
      }
    }
  });

  inp.addEventListener("keydown", function(e) {
    let list = document.getElementById(this.id + "-autocomplete-list");
    if (list) list = list.getElementsByTagName("div");
    if (e.keyCode === 40) { // down
      currentFocus++;
      addActive(list);
    } else if (e.keyCode === 38) { // up
      currentFocus--;
      addActive(list);
    } else if (e.keyCode === 13) { // enter
      e.preventDefault();
      if (currentFocus > -1 && list) list[currentFocus].click();
    }
  });

  function addActive(list) {
    if (!list) return false;
    removeActive(list);
    if (currentFocus >= list.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (list.length - 1);
    list[currentFocus].classList.add("autocomplete-active");
  }

  function removeActive(list) {
    for (let i = 0; i < list.length; i++) {
      list[i].classList.remove("autocomplete-active");
    }
  }

  function closeAllLists(elmnt) {
    let items = document.getElementsByClassName("autocomplete-items");
    for (let i = 0; i < items.length; i++) {
      if (elmnt !== items[i] && elmnt !== inp) {
        items[i].parentNode.removeChild(items[i]);
      }
    }
  }

  document.addEventListener("click", function(e) {
    closeAllLists(e.target);
  });
}

autocomplete(document.getElementById("from"), districts);
autocomplete(document.getElementById("to"), districts);


// Simple pricing logic: base price + per km (fake km here as example)
const basePrice = 50; // Base price in Taka
const pricePerDistrict = 20; // Price per district difference

function calculatePrice() {
  const from = document.getElementById("from").value.trim();
  const to = document.getElementById("to").value.trim();
  const seats = parseInt(document.getElementById("seats").value) || 1;

  if (!from || !to || from === to) {
    updatePriceDisplay(0);
    return;
  }

  // Calculate price based on index difference of districts
  const fromIndex = districts.indexOf(from);
  const toIndex = districts.indexOf(to);

  if (fromIndex === -1 || toIndex === -1) {
    updatePriceDisplay(0);
    return;
  }

  const districtDiff = Math.abs(toIndex - fromIndex);
  let pricePerTicket = basePrice + districtDiff * pricePerDistrict;
  if (pricePerTicket < basePrice) pricePerTicket = basePrice;

  updatePriceDisplay(pricePerTicket * seats);
  // Store price per ticket for form submission
  document.getElementById("price_per_ticket").value = pricePerTicket;
}

function updatePriceDisplay(totalPrice) {
  const priceDisplay = document.getElementById("priceDisplay");
  if (totalPrice <= 0) {
    priceDisplay.textContent = "Ticket Price: ৳0.00";
  } else {
    priceDisplay.textContent = "Total Price: ৳" + totalPrice.toFixed(2);
  }
}

// Update price when inputs change
document.getElementById("from").addEventListener("change", calculatePrice);
document.getElementById("to").addEventListener("change", calculatePrice);
document.getElementById("seats").addEventListener("input", calculatePrice);

// Initialize price on page load
calculatePrice();
</script>

</body>
</html>
