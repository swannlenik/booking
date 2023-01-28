<div class="container">
    <div class="row justify-content-center">
        <h1>Booking confirmed!</h1>

        <div class="col-md-12">
            You booked a shuttle for {{ $destination }} at {{ $bookingTime }} on {{ $bookingDay }}.
        </div>
        <div class="col-md-12">
            <a href="{{ viewURL }}" class="btn btn-info">
                View My Booking
            </a>
            <a href="{{ cancelURL }}" class="btn btn-danger">
                Modify/Cancel My Booking
            </a>
        </div>
        <div class="col-md-12">
            You can also contact the organization committee by calling these numbers:
            <ul>
                <li>Murray - 204-558-5679</li>
                <li>Tasha - 204-330-0055</li>
            </ul>
        </div>
    </div>
</div>