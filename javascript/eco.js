const options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0,
};

function success(pos) {
    const crd = pos.coords;
    var latitude = crd.latitude;
    var longitude = crd.longitude;
    console.log("Your current position is:");
    console.log(`Latitude : ${crd.latitude}`);
    console.log(`Longitude: ${crd.longitude}`);
    console.log(`More or less ${crd.accuracy} meters.`);
}

function error(err) {
    console.warn(`ERROR(${err.code}): ${err.message}`);
}

function eco() {
    navigator.geolocation.getCurrentPosition(success, error, options);

    document.getElementById("sag_spate").addEventListener("click", event => {
        window.location.href = "main.php";
        console.log("!!");
    })
    let wrapper = document.getElementById("wrapper");
    let wrapper2 = document.getElementById("wrapper2");
    let roundup = document.getElementById("roundup");
    let metrou = document.getElementById("metrou");
    let livada = document.getElementById("livada");
    document.getElementById("b_roundup").addEventListener("click", event => {
        console.log('smth');
        roundup.style.display = 'block';
        wrapper2.style.display = 'grid';
        wrapper.style.display = 'none';
    });
    document.getElementById("b_metrou").addEventListener("click", event => {
        metrou.style.display = 'block';
        wrapper2.style.display = 'grid';
        wrapper.style.display = 'none';
    });
    document.getElementById("b_livada").addEventListener("click", event => {
        livada.style.display = 'block';
        wrapper2.style.display = 'grid';
        wrapper.style.display = 'none';
    });
    document.getElementById("pop-exit").onclick = function () {
        roundup.style.display = 'none';
        metrou.style.display = 'none';
        livada.style.display = 'none';
        wrapper2.style.display = 'none';
        wrapper.style.display = 'flex';
    }
}