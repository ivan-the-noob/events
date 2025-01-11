function initMap() {
    const location = { lat: 14.3823, lng: 120.8806 };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 17, 
        center: location,
    });

    const marker = new google.maps.Marker({
        position: location,
        map: map,
        title: "CV4J+VW5, Epza-Bacao Rd, General Trias, Cavite",
    });
}

window.onload = initMap;