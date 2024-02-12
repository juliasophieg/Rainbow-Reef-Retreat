function validateDates() {
  // Get the checkin and checkout dates
  const checkin = document.getElementById('checkin').value;
  const checkout = document.getElementById('checkout').value;

  // Check if any of them are empty
  if (checkin === '' || checkout === '') {
    // Display error message
    alert('Please select both check-in and check-out dates.');

    // Focus on the first empty date field
    if (checkin === '') {
      document.getElementById('checkin').focus();
    } else {
      document.getElementById('checkout').focus();
    }

    // Prevent form submission
    return false;
  }

  // Check if checkin date is after checkout date
  if (checkin >= checkout) {
    // Display error message
    alert('Check-out date must be after check-in date.');

    // Focus on the checkout date field
    document.getElementById('checkout').focus();

    // Prevent form submission
    return false;
  }

  // Continue with form submission
  return true;
}
