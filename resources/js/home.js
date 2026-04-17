import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

document.addEventListener("DOMContentLoaded", () => {
    const el = document.querySelector("#dateRange");

    if (el) {
        flatpickr(el, {
            mode: "range",
            dateFormat: "d M Y",
            minDate: "today",
            showMonths: 2,
            disableMobile: true,
            onClose: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    console.log("Check-in:", selectedDates[0]);
                    console.log("Check-out:", selectedDates[1]);
                }
            }
        });
    }
});
