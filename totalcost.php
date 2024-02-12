<?php

//Price for room per day
foreach ($roomInfo as $rooms) {
    if ($rooms['id'] === $roomId) {
        $roomCost = $rooms['price_per_day'];
    }
}

// Room cost for whole stay
$startDate = new DateTime($checkIn);
$endDate = new DateTime($checkOut);
$interval = $startDate->diff($endDate);
$numberOfDays = $interval->days;

$totalRoomCost = $numberOfDays * $roomCost;

//30% discount if stay is longer than 3 days

$discount = 0;

if ($numberOfDays >= 1) {
    $discount = round($totalRoomCost * 0.5);
    $totalRoomCost = round($totalRoomCost * 0.5);
}

//Total cost if feature is chosen
if (!empty($featureCost)) {
    $_SESSION['total_cost'] = $totalRoomCost + $featureCost;
} else {
    $_SESSION['total_cost'] = $totalRoomCost;
}
$totalCost = $_SESSION['total_cost'];
?>

<script>
    //Show feature and total cost depending on checkboxes. Room cost and discount by default.
    const totalCostElement = document.getElementById("total_cost");
    let totalCost = <?php echo json_encode($totalRoomCost); ?>;
    const discountElement = document.getElementById("discount");
    let discount = <?php echo json_encode($discount); ?>;
    totalCostElement.textContent = "Total Cost: $" + totalCost.toFixed(2);
    discountElement.textContent = "Discount: -$" + discount.toFixed(2);


    document.addEventListener("DOMContentLoaded", function() {
        const features = <?php echo json_encode($features); ?>;

        // Update total cost function
        function updateTotalCost() {
            totalCost = <?php echo json_encode($totalRoomCost); ?>;
            features.forEach(feature => {
                const checkbox = document.getElementById(feature.feature_name);
                if (checkbox.checked) {
                    totalCost += parseFloat(feature.extra_cost);
                }
            });

            totalCostElement.textContent = "Total Cost: $" + totalCost.toFixed(2);
        }

        // Adding event listeners to checkboxes
        features.forEach(feature => {
            const checkbox = document.getElementById(feature.feature_name);
            checkbox.addEventListener("change", updateTotalCost);
        });
    });
</script>