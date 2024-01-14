https://juliaju.se/Rainbow-Reef-Retreat/

# Rainbow Reef

Nestled in the heart of the crystal-clear waters of the Pacific Ocean, Rainbow Reef is a dazzling jewel among tropical islands. Located in a remote and untouched corner of the world, this pristine paradise is renowned for its vibrant underwater world and breathtaking coral formations.

# Rainbow Reef Retreat

Welcome to Rainbow Reef Retreat, an exclusive haven nestled on the shores of the enchanting tropical island, offering a luxurious escape where paradise meets unparalleled hospitality. Located on the edge of the pristine Rainbow Reef, our resort is a seamless blend of opulence and natural beauty.

The hotel has three rooms: Lagoon Loft (budget), Turtle Terrace (standard) and Coral Suite (luxury).

The hotel offers 30% off on all stays longer than three days.

It is also possible to aff features such att Wildlife Watching, Lotus Spa and Jet Ski Adventures!


# Instructions

The database is built by five tables (Rooms, Features, Guests, Reservations and Reservation_features).
- Rooms: id, room_name, price_per_day, img_src, room_type
- Features: id, feature_name, extra_cost
- Guests: id, full_name, email
- Reservations: id, guest_id, arrival_date, departure_date, total_cost
- Reservation_features: id, reservation_id, feature_id

# Code review

Good job!

Keep in mind when reading trough my feedback that I learned a lot form looking trough your code and a lot of the feedback I’m giving I didn’t even implement myself. I’m definitely going back to my own project and change up some stuff.

Overall really really clean code and a tidy project. You’re going to be an excellent developer. I had to work hard to find something to give feedback on. First of all:

Neat with all functions in one file
I liked the array_diff solutions! Didn’t know about that one.
Good looking website with a clean interface and consistent margins and padding that makes the feel of the site calm and trustworthy.

1. Keep session start and if isset in index.php in a separate file and keep index.php clean, only requiring other files.

2. In hotelFunctions.php it would have been nice for the $allRooms on line 65 to be called their string name just for clarity. Then later in the code translate those string to their respective ID:s.

3. In rooms.php half of the data in $roomInfo is fetched from the database and the rest is hardcoded. Try keep everything in the database to have better control and make it easier to update trough an admin page for example. 

4. Create one script.js file instead of having small snippets of javascript spread out in the project. 

5. Change the filenames of room.php and rooms.php to something a bit more descriptive. Right now they are a bit so similar. roominfo.php and roompage.php for example.

6. Create a separate file for footer and header and require them to not repeat yourself. Separate html and php as much as possible.

7. Im not sure about this one but Is it necessary to check the dates availability several times? I see the dates availability is checked repeatedly over project. Maybe theres a smarter solutions to keep the dates occupied. Try keep code DRY.

8. Not really a coding feedback but from a UX perspective the solution to check availability isn’t ideal. It would be nice with some visual feedback to make a decision based on what dates are available directly instead of trying out different dates. For example put some css-classes on dates that are already booked in the calendar. But again, not a coding problem.

9. The check for empty form fields in booking.php could be a function.

10. This is far fetched but a few more comments in the code to explain certain parts.
