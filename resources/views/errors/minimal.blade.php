<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style>
            .container {
                height: 100vh;
            }
        </style>
    </head>
    <body>
        <div class="container d-flex justify-content-center align-items-center">
            <h4>404 | Not Found</h4>
        </div>

        <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 1600 900" preserveAspectRatio="xMidYMax slice" class="fixed-bottom" style="z-index: -1">
          <defs>
              <linearGradient id="bg">
                  <stop offset="0%" style="stop-color:rgba(2, 6, 23, 0.06)"></stop>
                  <stop offset="50%" style="stop-color:rgba(2, 1, 23, 0.9)"></stop>
                  <stop offset="100%" style="stop-color:rgba(2, 0, 23, 0.2)"></stop>
              </linearGradient>
              <path id="wave" fill="url(#bg)" d="M-363.852,502.589c0,0,236.988-41.997,505.475,0
      s371.981,38.998,575.971,0s293.985-39.278,505.474,5.859s493.475,48.368,716.963-4.995v560.106H-363.852V502.589z" />
          </defs>
          <g>
              <use xlink:href='#wave' opacity=".3">
                  <animateTransform
            attributeName="transform"
            attributeType="XML"
            type="translate"
            dur="10s"
            calcMode="spline"
            values="270 230; -334 180; 270 230"
            keyTimes="0; .5; 1"
            keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
            repeatCount="indefinite" />
              </use>
              <use xlink:href='#wave' opacity=".6">
                  <animateTransform
            attributeName="transform"
            attributeType="XML"
            type="translate"
            dur="8s"
            calcMode="spline"
            values="-270 230;243 220;-270 230"
            keyTimes="0; .6; 1"
            keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
            repeatCount="indefinite" />
              </use>
              <use xlink:href='#wave' opacty=".9">
                  <animateTransform
            attributeName="transform"
            attributeType="XML"
            type="translate"
            dur="6s"
            calcMode="spline"
            values="0 230;-140 200;0 230"
            keyTimes="0; .4; 1"
            keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
            repeatCount="indefinite" />
              </use>
          </g>
      </svg>

    </body>
</html>
