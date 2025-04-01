<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather - {{ $city }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .weather-container {
            width: 100%;
            max-width: 500px;
            background: rgba(30, 30, 30, 0.8);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid #333;
            overflow: hidden;
        }
        
        .weather-header {
            background: #1a1a1a;
            padding: 25px 30px;
            position: relative;
            text-align: center;
            border-bottom: 1px solid #333;
        }
        
        .weather-header h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: #FFD700;
        }
        
        .weather-date {
            font-size: 0.9rem;
            color: #aaa;
            margin-bottom: 15px;
        }
        
        .weather-body {
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .weather-temp-box {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        .weather-icon {
            width: 100px;
            height: 100px;
            filter: drop-shadow(0 0 10px rgba(255, 215, 0, 0.3));
            margin-right: 20px;
        }
        
        .temperature {
            font-size: 4rem;
            font-weight: 700;
            color: #ffffff;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
        }
        
        .description {
            font-size: 1.2rem;
            font-weight: 500;
            color: #FFD700;
            margin-bottom: 30px;
            text-transform: capitalize;
        }
        
        .weather-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            width: 100%;
        }
        
        .detail-item {
            background: rgba(50, 50, 50, 0.4);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            border: 1px solid #333;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .detail-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        
        .detail-item .label {
            font-size: 0.9rem;
            color: #aaa;
            margin-bottom: 8px;
        }
        
        .detail-item .value {
            font-size: 1.5rem;
            font-weight: 600;
            color: #FFD700;
        }
        
        @media (max-width: 500px) {
            .weather-header h1 {
                font-size: 1.7rem;
            }
            
            .temperature {
                font-size: 3rem;
            }
            
            .weather-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="weather-container">
        <div class="weather-header">
            <h1>{{ ucfirst($city) }}</h1>
            <div class="weather-date">{{ date('l, F j, Y') }}</div>
        </div>
        
        <div class="weather-body">
            <div class="weather-temp-box">
                <img src="https://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@4x.png" 
                     alt="Weather Icon" 
                     class="weather-icon">
                
                <div class="temperature">
                    {{ round($weather['main']['temp']) }}°C
                </div>
            </div>
            
            <div class="description">
                {{ $weather['weather'][0]['description'] }}
            </div>
            
            <div class="weather-details">
                <div class="detail-item">
                    <div class="label">Humidity</div>
                    <div class="value">{{ $weather['main']['humidity'] }}%</div>
                </div>
                
                <div class="detail-item">
                    <div class="label">Wind Speed</div>
                    <div class="value">{{ round($weather['wind']['speed']) }} m/s</div>
                </div>
                
                <div class="detail-item">
                    <div class="label">Feels Like</div>
                    <div class="value">{{ round($weather['main']['feels_like']) }}°C</div>
                </div>
                
                <div class="detail-item">
                    <div class="label">Pressure</div>
                    <div class="value">{{ $weather['main']['pressure'] }} hPa</div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>