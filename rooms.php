<?php

declare(strict_types=1);

require_once __DIR__ . '/hotelFunctions.php';

$db = connect('hotel.db');
$statement = $db->query("SELECT * FROM Rooms");
$rooms = $statement->fetchAll(PDO::FETCH_ASSOC);

$roomInfo = [
    [
        'id' => $rooms[0]['id'],
        'name' => $rooms[0]['room_name'],
        'type' => $rooms[0]['room_type'],
        'price_per_day' => $rooms[0]['price_per_day'],
        'room_description_first' => "The Lagoon Loft is a charming nook within the retreat, designed for those who appreciate simplicity without compromising on the essence of island living. Perched high, it offers a unique vantage point to soak in the natural beauty that surrounds the resort.",
        'room_description_second' => "The Lagoon Loft is a testament to the idea that luxury isn't always about size but about experience. It's a cocoon where the sounds of nature harmonize with the rhythm of the lagoon, offering guests a unique and intimate tropical retreat.",
        'amenities' => ['Ocean View', 'Daily Beach Bed', 'Rooftop Jacuzzi'],
        'room_img' => ['/assets/images/lagoonloft.jpeg'],
    ],
    [
        'id' => $rooms[1]['id'],
        'name' => $rooms[1]['room_name'],
        'type' => $rooms[1]['room_type'],
        'price_per_day' => $rooms[1]['price_per_day'],
        'room_description_first' => "Introducing the Turtle Terrace, a cozy haven within the sprawling beauty of Rainbow Reef Retreat. This intimate room is designed for travelers seeking comfort and simplicity while immersing themselves in the tropical charm of the island.",
        'room_description_second' => "The Turtle Terrace room is a delightful retreat for solo travelers or couples looking for a cozy space amidst the island's beauty. With its thoughtful design, serene ambiance, and convenient amenities, it offers a genuine taste of tropical paradise at an intimate scale.",
        'amenities' => ['Private Terrace', 'Private Access to the Beach', 'Rooftop Jacuzzi'],
        'room_img' => ['/assets/images/turtleterrace.jpeg'],
    ],
    [
        'id' => $rooms[2]['id'],
        'name' => $rooms[2]['room_name'],
        'type' => $rooms[2]['room_type'],
        'price_per_day' => $rooms[2]['price_per_day'],
        'room_description_first' => "Nestled amidst the azure waters and lush tropical greenery of the resort, the Coral Suite stands as an epitome of luxury and serenity. Set on a pristine tropical island, this suite is a harmonious blend of modern elegance and island charm.",
        'room_description_second' => "The Coral Suite is not just a room; it's an experience. It's where the rhythm of the waves lulls you to sleep, and the embrace of the island's beauty rejuvenates your spirit. Perfect for discerning travelers seeking an unparalleled tropical escape, the Coral Suite promises memories that linger long after the vacation ends.",
        'amenities' => ['Panoramic Ocean Views', 'Private Access to the Beach', 'En-suite Jacuzzi'],
        'room_img' => ['/assets/images/coralsuite.jpeg'],
    ],

];


// Get info about room
/*foreach ($roomInfo as $rooms) {
    if ($rooms['id'] === 1) {
        echo $rooms['name'];
        echo ", " . $rooms['price_per_day'];
    }
}*/
