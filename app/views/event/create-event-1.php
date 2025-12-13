<body>
<main class="main">
    <section class="event-creation-section">
        <form class="event-creation-form" method="POST" action="/event/create-1" id="eventForm">
            <div class="legend-section">
                <h1 class="legend">Create an <span style="color: #009688;">Event</span>!</h1>
            </div>

            <!-- Event Name -->
            <div class="event-name-field">
                <label class="form-label" for="eventname">Event Name</label>
                <input type="text" id="eventname" name="eventname" placeholder="Enter the name of your Event" required>
            </div>

            <!-- Event Start Date -->
            <div class="event-date">
                <label class="form-label" for="eventstartdate">EVENT START DATE</label>
                <input type="date" min="2024-12-18" id="eventstartdate" name="eventstartdate" placeholder="18/12/2024" required>
            </div>

            <!-- Event Start Time -->
            <div class="event-time">
                <label class="form-label" for="eventstarttime">EVENT START TIME</label>
                <input type="time" id="eventstarttime" name="eventstarttime" placeholder="eg 16:00" required>
            </div>

            <!-- Event End Date -->
            <div class="event-date">
                <label class="form-label" for="eventenddate">EVENT END DATE</label>
                <input type="date" min="2024-12-18" id="eventenddate" name="eventenddate" placeholder="18/12/2024" required>
            </div>

            <!-- Event End Time -->
            <div class="event-time">
                <label class="form-label" for="eventendtime">EVENT END TIME</label>
                <input type="time" id="eventendtime" name="eventendtime" placeholder="eg 16:00" required>
            </div>

            <!-- Location Name -->
            <div class="location-name-field">
                <label class="form-label" for="locationname">Name of the Location</label>
                <input type="text" id="locationname" name="locationname" placeholder="Enter the name of the Location" required>
            </div>

            <!-- Location Address -->
            <div class="location-address-field">
                <label class="form-label" for="locationaddress">Address of the Location</label>
                <input type="text" id="locationaddress" name="locationaddress" placeholder="Enter the address of the Location" required>
            </div>

            <!-- Coordinates (hidden) -->
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">

            <!-- Map -->
            <div id="mapCreate" style="height: 320px; border-radius: 12px; margin-bottom: 20px;"></div>

            <!-- Location Capacity -->
            <div class="event-name-field">
                <label class="form-label" for="locationcapacity">Location Capacity</label>
                <input type="number" min="0" id="locationcapacity" name="locationcapacity" placeholder="Enter the capacity of the location, if you don’t know that enter “0”" required>
            </div>

            <button class="sign-up-button" type="submit">Continue</button>

        </form>
    </section>

    <section class="Join-us-section">
        <div class="join-us-section-text">
            <h2 class="join-us-today">Tell us your plans</h2>
            <p>Fill this simple form and for people to <br>come!</p>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Client-side form validation
        const form = document.getElementById('eventForm');
        const eventStartDate = document.getElementById('eventstartdate');
        const eventEndDate = document.getElementById('eventenddate');

        form.addEventListener('submit', (event) => {
            const startDate = new Date(eventStartDate.value);
            const endDate = new Date(eventEndDate.value);
            const currentDate = new Date();

            // Check if the event start date is in the future
            if (startDate <= currentDate) {
                alert("Event start date must be in the future.");
                event.preventDefault(); // Prevent form submission
                return;
            }

            // Check if the event end date is after the start date
            if (endDate < startDate) {
                alert("Event end date must be after the start date.");
                event.preventDefault(); // Prevent form submission
                return;
            }
        });
    });
</script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const map = L.map('mapCreate').setView([56.9496, 24.1052], 12); // Riga default

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = null;

    map.on('click', async (e) => {
        //document.getElementById('locationaddress').value = 'CLICK WORKS';
        const lat = e.latlng.lat;
        const lon = e.latlng.lng;

        if (!marker) {
            marker = L.marker([lat, lon]).addTo(map);
        } else {
            marker.setLatLng([lat, lon]);
        }

        // Save coordinates into hidden inputs
        document.getElementById('latitude').value = lat.toFixed(7);
        document.getElementById('longitude').value = lon.toFixed(7);

        // Reverse geocode via backend
        try {
            const res = await fetch(
                `/api/reverse-geocode?lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lon)}`
            );
            const data = await res.json();
            //const text = await res.text();
            //console.log('RAW RESPONSE >>>', text, '<<< RAW END');

            if (res.ok && data.ok && data.result?.display_name) {
                document.getElementById('locationaddress').value =
                    data.result.display_name;
            }
        } catch (e) {
            console.warn('Reverse geocoding failed');
        }

        try {
                const url = `/api/reverse-geocode?lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lon)}`;
                const res = await fetch(url);

                console.log('reverse status:', res.status);

                const data = await res.json();
                console.log('reverse data:', data);

                if (res.ok && data.ok && data.result?.display_name) {
                    document.getElementById('locationaddress').value = data.result.display_name;
                } else {
                    document.getElementById('locationaddress').value = 'NO ADDRESS FROM API';
                }
                } catch (e) {
                console.log('reverse error:', e);
                document.getElementById('locationaddress').value = 'REVERSE ERROR';
            }
    });
});
</script>

</body>
