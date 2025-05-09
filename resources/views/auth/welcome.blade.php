<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Page-Enter" content="revealTrans(Duration=2.0,Transition=?)">

    <title>Welcome Page</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: none;
            color: black;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }
        body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: var(--bg-image, url('/images/pupil.jpg'));
    opacity: var(--current-bg-opacity, 1);
    background-size: cover;
    transition: opacity 2s ease-in-out;
    z-index: -1;
}

body::after {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: var(--next-bg-image);
    opacity: var(--next-bg-opacity, 0);
    background-size: cover;
    opacity: 1;
    transition: opacity 2s ease-in-out;
    z-index: -2;
}

        .nav-bar {
            width: 100%;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.5);
        }
        .nav-links {
            display: flex;
            gap: 20px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 1em;
        }
        .get-started {
            padding: 10px 20px;
            border: 2px solid white;
            border-radius: 5px;
            background: transparent;
            color: white;
            text-decoration: none;
            font-size: 1em;
        }
        .get-started:hover {
            background-color: orange;
            color: #7F00FF;
        }
        .container {
            text-align: center;
            margin-top: 100px;
        }
        .header {
            font-size: 4em;
            margin-bottom: 20px;

        }
        .sub-header {
            font-size: 2em;
            margin-bottom: 40px;
        }
        .form-container {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
        }
        .input-field {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #00BFFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            font-size: 1em;
        }
        .btn:hover {
            background-color: #008CBA;
        }
        .remember-me {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }
        .remember-me label {
            display: flex;
            align-items: center;
        }
        .links a {
            color: #00BFFF;
            text-decoration: none;
        }
        
    </style>
    
   
</head>
<body >
    <div class="nav-bar">
        <div class="nav-links">
    
           <div class="get-started"> <a  href="{{ route('login') }}">ADMINISTRATOR LOGIN</a></div>
           
    </div>

        <a href="{{ route('dashboard') }}" class="get-started">GUEST VIEW</a>

    </div>
    <div class="container"style="color:white;">
    <div class="header">THE</div>
        <div class="header">MATHEMATICS CHALLENGE COMPETITION</div>
        <div class="sub-header">NUMBERS DONT LIE!!.</div>
         <div class="sub-header">  <img src="/images/math.jpg" alt="Logo" style="width:100px;height:100px;"></div>
        
        
    </div>
</body>
<script>
    const images = [
        '/images/pupil.jpg',
        '/images/pupil 7 (2).jpg',
        '/images/children on laptops.jpg',
        '/images/pupil 4.jpg',
        // Add more image paths as needed
    ];
    let currentIndex = 0;

    function changeBackground() {
        const body = document.body;
        currentIndex = (currentIndex + 1) % images.length;
        const newImage = images[currentIndex];
        
        body.style.setProperty('--next-bg-image', `url('${newImage}')`);
        body.style.setProperty('--current-bg-opacity', '0');
        body.style.setProperty('--next-bg-opacity', '1');
        
        setTimeout(() => {
            body.style.setProperty('--bg-image', `url('${newImage}')`);
            body.style.setProperty('--current-bg-opacity', '1');
            body.style.setProperty('--next-bg-opacity', '0');
        }, 2000); // This should match the transition duration
    }

    // Change background every 2 seconds
    setInterval(changeBackground, 2000);
</script>

</html>
