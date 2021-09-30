<?php

require_once(dirname(__FILE__). '/../entity/Booking.php');
require_once(dirname(__FILE__). '/../repository/BookingRep.php');

class BookingService {

	private $booking_rep;

	public function __construct() {
		$this->booking_rep = new BookingRep();
	}

}
?>
