import './bootstrap';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#tgl", {
        dateFormat: "d-m-Y",
        altFormat: "F j, Y",
        defaultDate: new Date(),
    });
});

