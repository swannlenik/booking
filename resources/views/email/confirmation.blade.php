<div style="width:100%;text-align:center;">
    <h1>Booking confirmed!</h1>
</div>
<div style="width:100%;display:flex;flex-flow:column wrap;justify-content:center;">
    <div style="width: 100%; padding: 10px">
        You booked a shuttle for <u>{{ $destination }}</u> at <b>{{ $bookingTime }}</b> on <b>{{ $bookingDay }}</b>.
    </div>
    <div style="width: 100%; padding: 10px">
        <a href="{{ $viewURL }}">
            View/Modify/Cancel my booking
        </a>
    </div>
    <div style="width: 100%; padding: 10px">
        You can also contact the organization committee by calling these numbers:
        <ul>
            <li>Murray - <b>204-558-5679</b></li>
            <li>Tasha - <b>204-330-0055</b></li>
        </ul>
    </div>
</div>
