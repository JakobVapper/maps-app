<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Map Markers</title>
    <link href="https://js.radar.com/v4.4.10/radar.css" rel="stylesheet">
    <script src="https://js.radar.com/v4.4.10/radar.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #121212;
            color: #ffffff;
        }
        
        #map-container {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }
        
        #map {
            width: 100%;
            height: 100%;
        }
        
        #marker-form {
            display: none;
            position: absolute;
            top: 20px;
            right: 20px;
            background: #121212;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            width: 350px;
            max-width: 90%;
            animation: slide-in 0.3s ease-out;
            border: 1px solid #333;
        }
        
        @keyframes slide-in {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #ffffff;
            font-size: 0.9rem;
        }
        
        input[type="text"], 
        input[type="number"], 
        textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #333;
            border-radius: 8px;
            font-size: 14px;
            transition: border 0.3s;
            background-color: #1e1e1e;
            color: #ffffff;
        }
        
        input[type="text"]:focus, 
        input[type="number"]:focus, 
        textarea:focus {
            border-color: #FFD700;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .form-header {
            margin-bottom: 20px;
            border-bottom: 1px solid #333;
            padding-bottom: 15px;
        }
        
        .form-header h3 {
            font-weight: 600;
            color: #FFD700;
            font-size: 1.2rem;
        }
        
        .btn-group {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn-primary {
            background: #FFD700;
            color: #000000;
        }
        
        .btn-primary:hover {
            background: #FFC400;
        }
        
        .btn-cancel {
            background: #333333;
            color: #ffffff;
        }
        
        .btn-cancel:hover {
            background: #444444;
        }
        
        .btn-save {
            background: #FFD700;
            color: #000000;
        }
        
        .btn-save:hover {
            background: #FFC400;
        }
        
        .btn-delete {
            background: #333333;
            color: #ffffff;
        }
        
        .btn-delete:hover {
            background: #444444;
        }
        
        .marker-edit-form {
            display: none;
        }
        
        .marker-display {
            display: block;
        }

        .maplibregl-popup-content {
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            background-color: #121212;
            color: #ffffff;
            border: 1px solid #333;
        }
        
        .maplibregl-popup-close-button {
            font-size: 16px;
            color: #ffffff;
            right: 10px;
            top: 10px;
        }

        .marker-card {
            min-width: 250px;
        }
        
        .marker-card h3 {
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 10px;
            color: #FFD700;
        }
        
        .marker-card p {
            margin-bottom: 15px;
            color: #ffffff;
            font-size: 14px;
            line-height: 1.5;
        }

        .title-bar {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #121212;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 900;
            display: flex;
            align-items: center;
            border: 1px solid #333;
        }
        
        .title-bar h1 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #FFD700;
            margin:.0;
        }

        .instructions {
            display: none;
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: rgba(18, 18, 18, 0.95);
            padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 900;
            max-width: 300px;
            font-size: 14px;
            line-height: 1.5;
            color: #ffffff;
            animation: fade-in 0.5s ease-out;
            border: 1px solid #333;
        }
        
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .instructions.show {
            display: block;
        }
        
        .instructions h4 {
            font-weight: 600;
            margin-bottom: 10px;
            color: #FFD700;
        }
        
        .instructions p {
            margin-bottom: 8px;
        }

        .maplibregl-ctrl button {
            background-color: #121212;
            border: 1px solid #333;
        }

        .maplibregl-ctrl button:hover {
            background-color: #1e1e1e;
        }

        .maplibregl-ctrl button span {
            filter: invert(1);
        }

        ::placeholder {
            color: #999;
            opacity: 0.7;
        }
    </style>
</head>

<body>
<div class="title-bar">
    <h1>Map Markers</h1>
</div>

<div class="instructions show" id="instructions">
    <h4>How to use:</h4>
    <p>• Click anywhere on the map to add a new marker</p>
    <p>• Click on a marker to see details</p>
    <p>• Use Edit and Delete buttons to manage markers</p>
</div>

<div id="map-container">
    <div id="map"></div>
    <div id="marker-form">
        <div class="form-header">
            <h3>Add New Marker</h3>
        </div>
        <form id="create-marker-form">
            <div class="form-group">
                <label for="marker-name">Name</label>
                <input type="text" id="marker-name" placeholder="Enter location name" required>
            </div>
            <div class="form-group">
                <label for="marker-description">Description</label>
                <textarea id="marker-description" placeholder="Describe this location..."></textarea>
            </div>
            <input type="hidden" id="marker-latitude">
            <input type="hidden" id="marker-longitude">
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Save Location</button>
                <button type="button" class="btn btn-cancel" id="cancel-marker">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
  function debugLog(message) {
    console.log(message);
  }

  Radar.initialize('{{ config('services.radar.key') }}');

  const map = Radar.ui.map({
    container: 'map',
    style: 'radar-default-v1',
    center: [25.0136, 58.5953],
    zoom: 7,
  });

  let activeMarkers = {};

  setTimeout(() => {
    document.getElementById('instructions').classList.remove('show');
  }, 10000);

  map.on('load', function() {
    loadMarkers();
  });

  map.on('click', function(e) {
    const lat = e.lngLat.lat;
    const lng = e.lngLat.lng;
    
    document.getElementById('marker-form').style.display = 'block';
    document.getElementById('marker-latitude').value = lat;
    document.getElementById('marker-longitude').value = lng;
  });

  document.getElementById('cancel-marker').addEventListener('click', function() {
    document.getElementById('marker-form').style.display = 'none';
    document.getElementById('create-marker-form').reset();
  });

  document.getElementById('create-marker-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('marker-name').value;
    const description = document.getElementById('marker-description').value;
    const latitude = document.getElementById('marker-latitude').value;
    const longitude = document.getElementById('marker-longitude').value;
    
    createMarker(name, description, latitude, longitude);
  });

  function loadMarkers() {
    clearAllMarkers();
    
    fetch('{{ url("/markers/all") }}')
      .then(response => response.json())
      .then(markers => {
        markers.forEach(marker => {
          addMarkerToMap(marker);
        });
      })
      .catch(error => {
        console.error('Error loading markers:', error);
      });
  }

  function clearAllMarkers() {
    const markerCount = Object.keys(activeMarkers).length;
    
    Object.keys(activeMarkers).forEach(id => {
      if (activeMarkers[id]) {
        try {
          activeMarkers[id].remove();
        } catch (e) {
          console.error(`Error removing marker ${id}:`, e);
        }
      }
    });
    
    activeMarkers = {};
  }

  function createMarker(name, description, latitude, longitude) {
    const formData = new FormData();
    formData.append('name', name);
    formData.append('description', description);
    formData.append('latitude', latitude);
    formData.append('longitude', longitude);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route("markers.store") }}', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(marker => {
      addMarkerToMap(marker);
      
      document.getElementById('marker-form').style.display = 'none';
      document.getElementById('create-marker-form').reset();
    })
    .catch(error => {
      console.error('Error creating marker:', error);
    });
  }

  function addMarkerToMap(marker) {
    if (!marker || !marker.id) {
      return null;
    }
    
    if (activeMarkers[marker.id]) {
      activeMarkers[marker.id].remove();
      delete activeMarkers[marker.id];
    }
    
    const radarMarker = Radar.ui.marker({
      color: '#FFD700',
      width: 30,
      height: 45,
      popup: {
        maxWidth: '300px',
        html: `
          <div id="marker-${marker.id}-display" class="marker-display marker-card">
            <h3>${marker.name}</h3>
            <p>${marker.description || 'No description provided'}</p>
            <div class="btn-group">
              <button onclick="toggleEditMarker(${marker.id}, event)" class="btn btn-primary">Edit</button>
              <button onclick="deleteMarker(${marker.id}, event)" class="btn btn-delete">Delete</button>
            </div>
          </div>
          <div id="marker-${marker.id}-edit" class="marker-edit-form">
            <div class="form-header">
              <h3>Edit Marker</h3>
            </div>
            <div class="form-group">
              <label for="edit-name-${marker.id}">Name</label>
              <input type="text" id="edit-name-${marker.id}" value="${marker.name}" required>
            </div>
            <div class="form-group">
              <label for="edit-description-${marker.id}">Description</label>
              <textarea id="edit-description-${marker.id}">${marker.description || ''}</textarea>
            </div>
            <div class="form-group">
              <label for="edit-latitude-${marker.id}">Latitude</label>
              <input type="number" id="edit-latitude-${marker.id}" value="${marker.latitude}" step="any" required>
            </div>
            <div class="form-group">
              <label for="edit-longitude-${marker.id}">Longitude</label>
              <input type="number" id="edit-longitude-${marker.id}" value="${marker.longitude}" step="any" required>
            </div>
            <div class="btn-group">
              <button onclick="saveMarkerEdit(${marker.id}, event)" class="btn btn-save">Save Changes</button>
              <button onclick="cancelMarkerEdit(${marker.id}, event)" class="btn btn-cancel">Cancel</button>
            </div>
          </div>
        `
      }
    })
    .setLngLat([marker.longitude, marker.latitude])
    .addTo(map);
    
    activeMarkers[marker.id] = radarMarker;
    
    return radarMarker;
  }

  function toggleEditMarker(id, event) {
    if (event) event.stopPropagation();
    document.getElementById(`marker-${id}-display`).style.display = 'none';
    document.getElementById(`marker-${id}-edit`).style.display = 'block';
  }

  function cancelMarkerEdit(id, event) {
    if (event) event.stopPropagation();
    document.getElementById(`marker-${id}-display`).style.display = 'block';
    document.getElementById(`marker-${id}-edit`).style.display = 'none';
  }

  function saveMarkerEdit(id, event) {
    if (event) event.stopPropagation();
    
    const name = document.getElementById(`edit-name-${id}`).value;
    const description = document.getElementById(`edit-description-${id}`).value;
    const latitude = parseFloat(document.getElementById(`edit-latitude-${id}`).value);
    const longitude = parseFloat(document.getElementById(`edit-longitude-${id}`).value);

    const formData = new FormData();
    formData.append('name', name);
    formData.append('description', description);
    formData.append('latitude', latitude);
    formData.append('longitude', longitude);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT');

    fetch('{{ url("/markers") }}/' + id, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error('Server error: ' + text);
            });
        }
        return response.json();
    })
    .then(data => {
        if (activeMarkers[id]) {
            activeMarkers[id].remove();
            delete activeMarkers[id];
        }
        
        loadMarkers();
    })
    .catch(error => {
        console.error('Error updating marker:', error);
        alert('Error updating marker: ' + error.message);
    });
  }

  function deleteMarker(id, event) {
    if (event) event.stopPropagation();
    
    if (confirm('Are you sure you want to delete this marker?')) {
      const formData = new FormData();
      formData.append('_token', '{{ csrf_token() }}');
      formData.append('_method', 'DELETE');

      fetch('{{ url("/markers") }}/' + id, {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        
        if (activeMarkers[id]) {
          activeMarkers[id].remove();
          delete activeMarkers[id];
        }
        
        loadMarkers();
      })
      .catch(error => {
        console.error('Error deleting marker:', error);
      });
    }
  }
</script>
</body>
</html>