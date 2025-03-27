/map.blade.php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Map Markers</title>
    <link href="https://js.radar.com/v4.4.10/radar.css" rel="stylesheet">
    <script src="https://js.radar.com/v4.4.10/radar.min.js"></script>
    <style>
        #map-container {
            position: relative;
            width: 100%;
            height: 500px;
        }
        #map {
            width: 100%;
            height: 100%;
        }
        #marker-form {
            display: none;
            position: absolute;
            top: 10px;
            right: 10px;
            background: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        .form-group {
            margin-bottom: 10px;
        }
        .btn {
            padding: 5px 10px;
            background: #4285f4;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .btn-cancel {
            background: #f44336;
        }
        .btn-save {
            background: #4CAF50;
        }
        .marker-edit-form {
            margin-top: 10px;
            display: none;
        }
        .marker-display {
            display: block;
        }
    </style>
</head>

<body>
<div id="map-container">
    <div id="map"></div>
    <div id="marker-form">
        <h3>Add New Marker</h3>
        <form id="create-marker-form">
            <div class="form-group">
                <label for="marker-name">Name:</label>
                <input type="text" id="marker-name" required>
            </div>
            <div class="form-group">
                <label for="marker-description">Description:</label>
                <textarea id="marker-description"></textarea>
            </div>
            <input type="hidden" id="marker-latitude">
            <input type="hidden" id="marker-longitude">
            <div class="form-group">
                <button type="submit" class="btn">Save</button>
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
      color: '#000257',
      width: 30,
      height: 45,
      popup: {
        maxWidth: '300px',
        html: `
          <div id="marker-${marker.id}-display" class="marker-display">
            <h3>${marker.name}</h3>
            <p>${marker.description || ''}</p>
            <p>
              <button onclick="toggleEditMarker(${marker.id}, event)" class="btn">Edit</button>
              <button onclick="deleteMarker(${marker.id}, event)" class="btn btn-cancel">Delete</button>
            </p>
          </div>
          <div id="marker-${marker.id}-edit" class="marker-edit-form">
            <h3>Edit Marker</h3>
            <div class="form-group">
              <label for="edit-name-${marker.id}">Name:</label>
              <input type="text" id="edit-name-${marker.id}" value="${marker.name}" required>
            </div>
            <div class="form-group">
              <label for="edit-description-${marker.id}">Description:</label>
              <textarea id="edit-description-${marker.id}">${marker.description || ''}</textarea>
            </div>
            <div class="form-group">
              <label for="edit-latitude-${marker.id}">Latitude:</label>
              <input type="number" id="edit-latitude-${marker.id}" value="${marker.latitude}" step="any" required>
            </div>
            <div class="form-group">
              <label for="edit-longitude-${marker.id}">Longitude:</label>
              <input type="number" id="edit-longitude-${marker.id}" value="${marker.longitude}" step="any" required>
            </div>
            <p>
              <button onclick="saveMarkerEdit(${marker.id}, event)" class="btn btn-save">Save</button>
              <button onclick="cancelMarkerEdit(${marker.id}, event)" class="btn btn-cancel">Cancel</button>
            </p>
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