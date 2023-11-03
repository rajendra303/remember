<!DOCTYPE html>
<html>
<head>
<style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #f0f0f0;
      font-family: Arial, sans-serif;
      text-align: center;
    }

    #camera-button {
      display: inline;
      margin: 20px auto;
      text-decoration: none;
      background-color: #3498db;
      color:white;
      padding: 10px 20px;
      border-radius: 5px;
      border:2px solid black;
    }

    #captured-image {
      display: none;
      max-width: 100%;
      margin: 20px auto;
      border: 2px solid #ccc;
      border-radius: 5px;
    }

    button {
      display: block;
      margin: 10px auto;
      padding: 10px 20px;
      background-color: #3498db;
      color: #ffff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    canvas {
      display: none;
      max-width: 100%;
      border: 2px solid #ccc;
      border-radius: 5px;
    }

    .error {
      color: #ff0000;
    }
    #upload-button {
      display: block;
      margin: 20px auto;
      text-decoration: none;
      background-color: #3498db;
      color: #fff;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    #upload-button:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>
  
  <form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="image_data" id="image-data" value="">
    <!-- Add the submit button here -->
    <input type="submit" id="upload-button" value="Upload Image">
  </form>

  <a id="camera-button" href="#"><i class="fas fa-camera"></i> Capture Image</a>
  <img id="captured-image" alt="Captured Image">

  <script>
    const uploadButton = document.getElementById('upload-button');

    uploadButton.addEventListener('click', () => {
        // Here you can add your code to store the data in the database.
        // For example, you can use AJAX to send the data to the server.

        // Replace the following line with your database storage logic.
        // Example alert box:
        alert('Alert sent to the nearest NGO!');
    });
      const cameraButton = document.getElementById('camera-button');
    const capturedImage = document.getElementById('captured-image');

    cameraButton.addEventListener('click', () => {
      if ('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices) {
        navigator.mediaDevices.getUserMedia({ video: true })
          .then((stream) => {
            const video = document.createElement('video');
            document.body.appendChild(video);
            video.srcObject = stream;
            video.play();

            const canvas = document.createElement('canvas');
            document.body.appendChild(canvas);

            const captureButton = document.createElement('button');
            captureButton.innerHTML = 'Capture';
            document.body.appendChild(captureButton);

            captureButton.addEventListener('click', () => {
              canvas.width = video.videoWidth;
              canvas.height = video.videoHeight;
              const context = canvas.getContext('2d');
              context.drawImage(video, 0, 0, canvas.width, canvas.height);

              if ('geolocation' in navigator) {
                navigator.geolocation.getCurrentPosition((position) => {
                  const latitude = position.coords.latitude;
                  const longitude = position.coords.longitude;

                  const imageUrl = canvas.toDataURL('image/jpeg');

                  context.font = '16px Arial';
                  context.fillStyle = 'white';
                  context.fillText(`Latitude: ${latitude}`, 10, 30);
                  context.fillText(`Longitude: ${longitude}`, 10, 60);

                  capturedImage.src = canvas.toDataURL('image/jpeg');
                  capturedImage.style.display = 'block';
                }, (error) => {
                  console.error('Error getting location:', error);
                });
              } else {
                console.error('Geolocation is not supported by this browser.');
              }

              stream.getTracks().forEach(track => track.stop());
              video.remove(); 
              canvas.remove(); 
              captureButton.remove();
            });
          })
          .catch((error) => {
            console.error('Error accessing camera:', error);
          });
      } else {
        console.error('getUserMedia is not supported by this browser.');
      }
    });
  </script>
</body>
</html>