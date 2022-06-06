<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
        }

        .header {
            background-color: crimson;
            color: white;
            display: block;
            margin: auto;
        }

        .header img {
            padding-top: 2rem;
            width: fit-content;
            height: 100px;
            display: block;
            margin: auto;
            filter: drop-shadow(1px 1px 0 rgb(164, 0, 0)) drop-shadow(-1px -1px 0 rgb(164, 0, 0));
        }

        .header h1 {
            padding-bottom: 2rem;
            font-size: 2rem;
            width: fit-content;
            display: block;
            margin: auto;
        }

        .body {
            padding: 1rem;
        }

        .footer {
            display: block;
            margin: auto;
            background-color: #334f80;
            /* padding: 2rem 0; */
        }

        .footer * {
            padding: 0.5rem 0
        }

        .footer .detail {
            text-align: center;
            color: white;
        }

        .social-line {
            width: fit-content;
            display: block;
            margin: auto;
        }

        .social-line a {
            margin-right: 0.5rem;
        }

        .social-line a img {
            height: 2rem;
            width: 2rem;
        }
    </style>
    <title>Gharagan mail</title>
</head>

<body>


    <div>
        <div class="header">
            <img src="https://uc30c3be216a32774cdeeff922b3.dl.dropboxusercontent.com/cd/0/inline/Bmp_ysK5Q2Sig9ZZyI0Z0dYf35NBhilMjqEZPdL6h1tId5e4Io8DBkXsrQEXVcRZrvNrCpbZKN6ZPzVg8R_rpmO8QP0h1c5EAt6ZfWQOxVX4W25DEdtJgURoOfCgr4CCaC3MmemVQMvZnT1Y-BVOdOhDay8sXzElT1BZoO6VFcqizg/file#"
                alt="Gharagan logo" />
            <h1>Gharagan</h1>
        </div>
    </div>

    <div class="body">
        @php
            echo $body;
        @endphp
    </div>


    <div class="footer">
        <div class="social-line">
            <a href="http://facebook.com" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Facebook_Logo_%282019%29.png/800px-Facebook_Logo_%282019%29.png"
                    alt="facebook logo" />
            </a>

            <a href="http://instagram.com" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/58/Instagram-Icon.png/640px-Instagram-Icon.png"
                    alt="instagram logo" />
            </a>

            <a href="http://twitter.com" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/fr/thumb/c/c8/Twitter_Bird.svg/langfr-280px-Twitter_Bird.svg.png"
                    alt="twitter logo" />
            </a>
        </div>
        <div class="detail">
            &copy; Gharagan {{ date('Y') }}
        </div>
    </div>

</body>

</html>
