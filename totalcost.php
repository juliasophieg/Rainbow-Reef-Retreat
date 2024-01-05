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


?>


<script>
    //Show feature and total cost depending on checkboxes. Room cost by default.

    const totalCostElement = document.getElementById("total_cost");
    let totalCost = <?php echo json_encode($totalRoomCost); ?>;
    totalCostElement.textContent = "Total Cost: $" + totalCost;

    document.addEventListener("DOMContentLoaded", function() {
        const features = <?php echo json_encode($features); ?>; // Converting PHP array to js object

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